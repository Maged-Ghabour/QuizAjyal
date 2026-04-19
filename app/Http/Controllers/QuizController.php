<?php

namespace App\Http\Controllers;

use App\Models\PassageSubQuestion;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * Display the quiz landing page.
     */
    public function show(string $slug): View
    {
        $quiz = Quiz::active()
            ->where('slug', $slug)
            ->withCount('questions')
            ->firstOrFail();

        return view('quiz.landing', compact('quiz'));
    }

    /**
     * Start a quiz attempt — validate student info and redirect to questions.
     */
    public function start(Request $request, string $slug): RedirectResponse
    {
        $quiz = Quiz::active()->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'student_name'  => ['required', 'string', 'max:255'],
            'student_phone' => ['required', 'string', 'max:20'],
        ]);

        $attempt = QuizAttempt::create([
            'quiz_id'       => $quiz->id,
            'student_name'  => $validated['student_name'],
            'student_phone' => $validated['student_phone'],
            'total_points'  => $quiz->questions()->sum('points'),
            'started_at'    => now(),
        ]);

        session(['quiz_attempt_id' => $attempt->id]);

        return redirect()->route('quiz.take', $slug);
    }

    /**
     * Show the quiz questions page.
     */
    public function questions(string $slug): View|RedirectResponse
    {
        $quiz = Quiz::active()
            ->where('slug', $slug)
            ->with([
                'questions.options',
                'questions.matchPairs',
                'questions.passageSubQuestions.options',
            ])
            ->firstOrFail();

        $attemptId = session('quiz_attempt_id');
        if (!$attemptId) {
            return redirect()->route('quiz.show', $slug)
                ->with('error', 'Please enter your information first.');
        }

        $attempt = QuizAttempt::findOrFail($attemptId);

        if ($attempt->completed_at) {
            return redirect()->route('quiz.result', ['slug' => $slug, 'attempt' => $attempt->id]);
        }

        $questions = $quiz->questions;
        if ($quiz->randomize_questions) {
            $questions = $questions->shuffle();
        }

        $endTime = $attempt->started_at->addMinutes($quiz->duration_minutes)->timestamp;

        return view('quiz.take', compact('quiz', 'questions', 'attempt', 'endTime'));
    }

    /**
     * Submit quiz answers and calculate score.
     */
    public function submit(Request $request, string $slug): RedirectResponse
    {
        $quiz = Quiz::where('slug', $slug)
            ->with([
                'questions.options',
                'questions.matchPairs',
                'questions.passageSubQuestions.options',
            ])
            ->firstOrFail();

        $attemptId = session('quiz_attempt_id');
        if (!$attemptId) {
            return redirect()->route('quiz.show', $slug);
        }

        $attempt = QuizAttempt::findOrFail($attemptId);

        if ($attempt->completed_at) {
            return redirect()->route('quiz.result', ['slug' => $slug, 'attempt' => $attempt->id]);
        }

        $answers    = $request->input('answers', []);
        $totalScore = 0;

        foreach ($quiz->questions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;

            if ($question->type === 'passage') {
                // Grade each sub-question independently
                $subAnswers   = is_array($studentAnswer) ? $studentAnswer : [];
                $passageScore = 0;

                foreach ($question->passageSubQuestions as $subQ) {
                    $subAnswer    = $subAnswers[$subQ->id] ?? null;
                    $isSubCorrect = $this->gradeSubQuestion($subQ, $subAnswer);
                    if ($isSubCorrect) {
                        $passageScore += $subQ->points;
                    }
                }

                $totalScore += $passageScore;

                $attempt->answers()->create([
                    'question_id'    => $question->id,
                    'student_answer' => json_encode($subAnswers),
                    'is_correct'     => $passageScore >= $question->points && $question->points > 0,
                    'points_earned'  => $passageScore,
                ]);
            } else {
                $answerString = $this->normalizeAnswer($question, $studentAnswer);
                $isCorrect    = $this->gradeAnswer($question, $studentAnswer);
                $pointsEarned = 0;

                if ($isCorrect) {
                    $pointsEarned = $question->points;
                    $totalScore  += $pointsEarned;
                }

                $attempt->answers()->create([
                    'question_id'    => $question->id,
                    'student_answer' => $answerString,
                    'is_correct'     => $isCorrect,
                    'points_earned'  => $pointsEarned,
                ]);
            }
        }

        $totalPoints = $quiz->questions->sum('points');
        $percentage  = $totalPoints > 0 ? round(($totalScore / $totalPoints) * 100) : 0;

        $attempt->update([
            'score'        => $totalScore,
            'total_points' => $totalPoints,
            'percentage'   => $percentage,
            'completed_at' => now(),
        ]);

        session()->forget('quiz_attempt_id');

        return redirect()->route('quiz.result', ['slug' => $slug, 'attempt' => $attempt->id]);
    }

    /**
     * Show quiz results.
     */
    public function result(string $slug, QuizAttempt $attempt): View|RedirectResponse
    {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();

        $attempt->load([
            'answers.question.options',
            'answers.question.matchPairs',
            'answers.question.passageSubQuestions.options',
        ]);

        if (!$quiz->show_results) {
            return view('quiz.result-hidden', compact('quiz', 'attempt'));
        }

        return view('quiz.result', compact('quiz', 'attempt'));
    }

    /**
     * Normalize the student answer into a string for storage.
     */
    private function normalizeAnswer(Question $question, mixed $answer): string
    {
        if (is_array($answer)) {
            return json_encode($answer);
        }

        return (string) ($answer ?? '');
    }

    /**
     * Grade a single answer against the correct answer.
     */
    private function gradeAnswer(Question $question, mixed $studentAnswer): bool
    {
        if ($studentAnswer === null || $studentAnswer === '') {
            return false;
        }

        return match ($question->type) {
            'mcq'        => $this->gradeMcq($question, $studentAnswer),
            'fill_blank' => $this->gradeFillBlank($question, $studentAnswer),
            'true_false' => $this->gradeTrueFalse($question, $studentAnswer),
            'drag_drop'  => $this->gradeMatch($question, $studentAnswer),
            'word_order' => $this->gradeWordOrder($question, $studentAnswer),
            default      => false,
        };
    }

    /**
     * Grade a passage sub-question.
     */
    private function gradeSubQuestion(PassageSubQuestion $subQ, mixed $answer): bool
    {
        if ($answer === null || $answer === '') {
            return false;
        }

        return match ($subQ->type) {
            'mcq' => (function () use ($subQ, $answer) {
                $correct = $subQ->options->firstWhere('is_correct', true);
                return $correct && (string) $correct->id === (string) $answer;
            })(),
            'fill_blank', 'true_false' =>
                $this->normalizeTextForGrading((string) $answer) === $this->normalizeTextForGrading($subQ->correct_answer ?? ''),
            default => false,
        };
    }

    /**
     * Normalize text for robust grading (handles Arabic variations, case, extra spaces, and basic punctuation).
     */
    private function normalizeTextForGrading(string $text): string
    {
        $text = mb_strtolower(trim($text));
        // Remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);
        // Remove basic punctuation (English and Arabic)
        $text = preg_replace('/[.,?!؛،؟]/u', '', $text);
        // Normalize Arabic characters
        $text = preg_replace('/[أإآ]/u', 'ا', $text); // Alefs
        $text = str_replace('ة', 'ه', $text); // Teh Marbuta to Heh
        $text = str_replace('ى', 'ي', $text); // Alef Maksura to Yeh
        // Remove Arabic Diacritics (Tashkeel)
        $text = preg_replace('/[\x{0617}-\x{061A}\x{064B}-\x{0652}]/u', '', $text);
        
        return trim($text);
    }

    private function gradeMcq(Question $question, mixed $answer): bool
    {
        $correctOption = $question->options->firstWhere('is_correct', true);

        return $correctOption && (string) $correctOption->id === (string) $answer;
    }

    private function gradeFillBlank(Question $question, mixed $answer): bool
    {
        return $this->normalizeTextForGrading((string) $answer) === $this->normalizeTextForGrading($question->correct_answer ?? '');
    }

    private function gradeTrueFalse(Question $question, mixed $answer): bool
    {
        return $this->normalizeTextForGrading((string) $answer) === $this->normalizeTextForGrading($question->correct_answer ?? '');
    }

    private function gradeMatch(Question $question, mixed $answer): bool
    {
        if (!is_array($answer)) {
            return false;
        }

        $pairs     = $question->matchPairs;
        $allCorrect = true;

        foreach ($pairs as $pair) {
            $studentMatch = $answer[$pair->id] ?? null;
            if ((string) $studentMatch !== (string) $pair->id) {
                $allCorrect = false;
                break;
            }
        }

        return $allCorrect;
    }

    /**
     * Grade a word-order question — compare normalised strings.
     */
    private function gradeWordOrder(Question $question, mixed $answer): bool
    {
        $correct = $this->normalizeTextForGrading($question->correct_answer ?? '');
        $student = $this->normalizeTextForGrading((string) $answer);

        return $correct !== '' && $correct === $student;
    }
}

