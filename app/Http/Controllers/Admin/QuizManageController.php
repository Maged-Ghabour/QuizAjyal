<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PassageSubQuestion;
use App\Models\Question;
use App\Models\QuestionMatchPair;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class QuizManageController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index(): View
    {
        $quizzes = Quiz::withCount([
            'questions',
            'attempts' => function ($query): void {
                $query->whereNotNull('completed_at');
            }
        ])
            ->latest()
            ->paginate(15);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create(): View
    {
        return view('admin.quizzes.create');
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'duration_minutes'    => ['required', 'integer', 'min:1', 'max:300'],
            'is_active'           => ['boolean'],
            'show_results'        => ['boolean'],
            'randomize_questions' => ['boolean'],
            'pass_percentage'     => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $validated['user_id']             = auth()->id();
        $validated['is_active']           = $request->boolean('is_active');
        $validated['show_results']        = $request->boolean('show_results');
        $validated['randomize_questions'] = $request->boolean('randomize_questions');

        $quiz = Quiz::create($validated);

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('success', 'Quiz created! Now add questions.');
    }

    /**
     * Show the form for editing the quiz (with questions).
     */
    public function edit(Quiz $quiz): View
    {
        $quiz->load(['questions.options', 'questions.matchPairs', 'questions.passageSubQuestions.options']);

        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz.
     */
    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $validated = $request->validate([
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'duration_minutes'    => ['required', 'integer', 'min:1', 'max:300'],
            'is_active'           => ['boolean'],
            'show_results'        => ['boolean'],
            'randomize_questions' => ['boolean'],
            'pass_percentage'     => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $validated['is_active']           = $request->boolean('is_active');
        $validated['show_results']        = $request->boolean('show_results');
        $validated['randomize_questions'] = $request->boolean('randomize_questions');

        $quiz->update($validated);

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz.
     */
    public function destroy(Quiz $quiz): RedirectResponse
    {
        $quiz->questions()->each(function ($question): void {
            $question->options()->delete();
            $question->matchPairs()->delete();
            $question->passageSubQuestions()->each(function ($sq): void {
                $sq->options()->delete();
            });
            $question->passageSubQuestions()->delete();
        });
        $quiz->attempts()->each(function ($attempt): void {
            $attempt->answers()->delete();
        });
        $quiz->attempts()->delete();
        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Store a new question for a quiz.
     */
    public function storeQuestion(Request $request, Quiz $quiz): RedirectResponse
    {
        $validated = $request->validate([
            'type'           => ['required', 'string', 'in:mcq,fill_blank,drag_drop,true_false,passage,essay,word_order'],
            'question_text'  => ['required', 'string'],
            'question_image' => ['nullable', 'image', 'max:2048'],
            'question_audio' => ['nullable', 'mimes:mp3,wav,ogg,mpga,webm', 'max:10240'],
            'correct_answer' => ['nullable', 'string'],
            'points'         => ['required_unless:type,passage', 'nullable', 'integer', 'min:1'],
        ]);

        if ($request->hasFile('question_image')) {
            $validated['question_image'] = $request->file('question_image')->store('questions', 'public');
        }

        if ($request->hasFile('question_audio')) {
            $validated['question_audio'] = $request->file('question_audio')->store('questions', 'public');
        }

        // For passage questions, points will be computed from sub-questions
        if ($validated['type'] === 'passage') {
            $validated['points'] = 0;
        }

        $validated['sort_order'] = $quiz->questions()->max('sort_order') + 1;

        $question = $quiz->questions()->create($validated);

        // Handle options for MCQ
        if ($validated['type'] === 'mcq') {
            $options = $request->input('options', []);
            foreach ($options as $i => $opt) {
                $optionData = [
                    'label'      => $opt['label'] ?? chr(65 + $i),
                    'option_text'=> $opt['option_text'] ?? '',
                    'is_correct' => isset($opt['is_correct']),
                    'sort_order' => $i,
                ];

                if (isset($opt['option_image']) && $request->hasFile("options.{$i}.option_image")) {
                    $optionData['option_image'] = $request->file("options.{$i}.option_image")->store('options', 'public');
                }

                $question->options()->create($optionData);
            }
        }

        // Handle drag_drop pairs
        if ($validated['type'] === 'drag_drop') {
            $pairs    = $request->input('pairs', []);
            $pairFiles = $request->file('pairs', []);

            foreach ($pairs as $i => $pair) {
                $pairData = [
                    'left_text'  => $pair['left_text'] ?? '',
                    'right_text' => $pair['right_text'] ?? '',
                    'sort_order' => $i,
                ];

                $leftFile = $pairFiles[$i]['left_image'] ?? null;
                if ($leftFile instanceof \Illuminate\Http\UploadedFile) {
                    $pairData['left_image'] = $leftFile->store('pairs', 'public');
                }

                $rightFile = $pairFiles[$i]['right_image'] ?? null;
                if ($rightFile instanceof \Illuminate\Http\UploadedFile) {
                    $pairData['right_image'] = $rightFile->store('pairs', 'public');
                }

                $question->matchPairs()->create($pairData);
            }
        }

        // Handle passage sub-questions
        if ($validated['type'] === 'passage') {
            $this->storePassageSubQuestions($request, $question);
        }

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('success', 'Question added successfully.');
    }

    /**
     * Update a question.
     */
    public function updateQuestion(Request $request, Quiz $quiz, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'question_text'  => ['required', 'string'],
            'question_image' => ['nullable', 'image', 'max:2048'],
            'question_audio' => ['nullable', 'mimes:mp3,wav,ogg,mpga,webm', 'max:10240'],
            'correct_answer' => ['nullable', 'string'],
            'points'         => ['required_unless:type,passage', 'nullable', 'integer', 'min:1'],
        ]);

        if ($request->hasFile('question_image')) {
            if ($question->question_image) {
                Storage::disk('public')->delete($question->question_image);
            }
            $validated['question_image'] = $request->file('question_image')->store('questions', 'public');
        }

        if ($request->hasFile('question_audio')) {
            if ($question->question_audio) {
                Storage::disk('public')->delete($question->question_audio);
            }
            $validated['question_audio'] = $request->file('question_audio')->store('questions', 'public');
        }

        $question->update($validated);

        // Update options for MCQ
        if ($question->type === 'mcq') {
            $question->options()->delete();
            $options = $request->input('options', []);
            foreach ($options as $i => $opt) {
                $optionData = [
                    'label'      => $opt['label'] ?? chr(65 + $i),
                    'option_text'=> $opt['option_text'] ?? '',
                    'is_correct' => isset($opt['is_correct']),
                    'sort_order' => $i,
                ];
                $question->options()->create($optionData);
            }
        }

        // Update drag_drop pairs
        if ($question->type === 'drag_drop') {
            $question->matchPairs()->delete();
            $pairs    = $request->input('pairs', []);
            $pairFiles = $request->file('pairs', []);

            foreach ($pairs as $i => $pair) {
                $pairData = [
                    'left_text'  => $pair['left_text'] ?? '',
                    'right_text' => $pair['right_text'] ?? '',
                    'sort_order' => $i,
                ];

                $leftFile = $pairFiles[$i]['left_image'] ?? null;
                if ($leftFile instanceof \Illuminate\Http\UploadedFile) {
                    $pairData['left_image'] = $leftFile->store('pairs', 'public');
                }

                $rightFile = $pairFiles[$i]['right_image'] ?? null;
                if ($rightFile instanceof \Illuminate\Http\UploadedFile) {
                    $pairData['right_image'] = $rightFile->store('pairs', 'public');
                }

                $question->matchPairs()->create($pairData);
            }
        }

        // Update passage sub-questions
        if ($question->type === 'passage') {
            $question->passageSubQuestions()->each(fn($sq) => $sq->options()->delete());
            $question->passageSubQuestions()->delete();
            $this->storePassageSubQuestions($request, $question);
        }

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('success', 'Question updated.');
    }

    /**
     * Delete a question.
     */
    public function destroyQuestion(Quiz $quiz, Question $question): RedirectResponse
    {
        if ($question->question_image) {
            Storage::disk('public')->delete($question->question_image);
        }

        $question->options()->delete();
        $question->matchPairs()->delete();
        $question->passageSubQuestions()->each(fn($sq) => $sq->options()->delete());
        $question->passageSubQuestions()->delete();
        $question->delete();

        return redirect()
            ->route('admin.quizzes.edit', $quiz)
            ->with('success', 'Question deleted.');
    }

    /**
     * Edit a question.
     */
    public function editQuestion(Quiz $quiz, Question $question): View
    {
        $question->load(['options', 'matchPairs', 'passageSubQuestions.options']);
        return view('admin.quizzes.questions.edit', compact('quiz', 'question'));
    }

    /**
     * Store passage sub-questions from request.
     */
    private function storePassageSubQuestions(Request $request, Question $question): void
    {
        $subQuestions = $request->input('sub_questions', []);
        $totalPoints  = 0;

        foreach ($subQuestions as $i => $sq) {
            $sqPoints = max(1, (int) ($sq['points'] ?? 1));
            $totalPoints += $sqPoints;

            $subQuestion = $question->passageSubQuestions()->create([
                'sub_question_text' => $sq['sub_question_text'] ?? '',
                'type'              => $sq['type'] ?? 'mcq',
                'correct_answer'    => $sq['correct_answer'] ?? null,
                'points'            => $sqPoints,
                'sort_order'        => $i,
            ]);

            // MCQ options for the sub-question
            if (($sq['type'] ?? 'mcq') === 'mcq') {
                $options = $sq['options'] ?? [];
                foreach ($options as $j => $opt) {
                    $subQuestion->options()->create([
                        'label'      => $opt['label'] ?? chr(65 + $j),
                        'option_text'=> $opt['option_text'] ?? '',
                        'is_correct' => isset($opt['is_correct']),
                        'sort_order' => $j,
                    ]);
                }
            }
        }

        // Update parent question points = sum of sub-questions
        $question->update(['points' => max(1, $totalPoints)]);
    }
}
