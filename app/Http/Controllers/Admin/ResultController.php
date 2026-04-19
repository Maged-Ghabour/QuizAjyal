<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResultController extends Controller
{
    /**
     * Display a listing of quiz attempts.
     */
    public function index(Request $request): View
    {
        $query = QuizAttempt::with('quiz')
            ->whereNotNull('completed_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('student_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->input('quiz_id'));
        }

        $attempts = $query->latest('completed_at')->paginate(20)->withQueryString();
        $quizzes = Quiz::orderBy('title')->get();

        return view('admin.results.index', compact('attempts', 'quizzes'));
    }

    /**
     * Show detailed results for a specific attempt.
     */
    public function show(QuizAttempt $attempt): View
    {
        $attempt->load(['quiz', 'answers.question.options', 'answers.question.matchPairs']);

        return view('admin.results.show', compact('attempt'));
    }

    /**
     * Export results as CSV.
     */
    public function export(Request $request, ?Quiz $quiz = null): StreamedResponse
    {
        $query = QuizAttempt::with('quiz')->whereNotNull('completed_at');

        if ($quiz) {
            $query->where('quiz_id', $quiz->id);
        }

        $attempts = $query->latest('completed_at')->get();

        $filename = $quiz
            ? "results_{$quiz->slug}_" . now()->format('Y-m-d') . '.csv'
            : 'results_all_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($attempts): void {
            $handle = fopen('php://output', 'w');

            // Header
            fputcsv($handle, [
                'Quiz',
                'Student Name',
                'Phone',
                'Score',
                'Total Points',
                'Percentage',
                'Result',
                'Started At',
                'Completed At',
                'Duration',
            ]);

            foreach ($attempts as $attempt) {
                fputcsv($handle, [
                    $attempt->quiz->title,
                    $attempt->student_name,
                    $attempt->student_phone,
                    $attempt->score,
                    $attempt->total_points,
                    $attempt->percentage . '%',
                    $attempt->is_passed ? 'Pass' : 'Fail',
                    $attempt->started_at?->format('Y-m-d H:i'),
                    $attempt->completed_at?->format('Y-m-d H:i'),
                    $attempt->duration,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
