<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(): View
    {
        $totalQuizzes = Quiz::count();
        $activeQuizzes = Quiz::where('is_active', true)->count();
        $totalAttempts = QuizAttempt::whereNotNull('completed_at')->count();
        $averageScore = QuizAttempt::whereNotNull('completed_at')->avg('percentage') ?? 0;

        $recentAttempts = QuizAttempt::with('quiz')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->limit(10)
            ->get();

        $topQuizzes = Quiz::withCount(['attempts' => function ($query): void {
            $query->whereNotNull('completed_at');
        }])
            ->orderByDesc('attempts_count')
            ->limit(5)
            ->get();

        // Chart Data (Last 7 Days)
        $startDate = now()->subDays(6)->startOfDay();
        $stats = QuizAttempt::whereNotNull('completed_at')
            ->where('completed_at', '>=', $startDate)
            ->selectRaw('DATE(completed_at) as date, count(*) as total, avg(percentage) as average')
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartTotals = [];
        $chartAverages = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d'); // Example: "Apr 08"
            $chartTotals[] = $stats->has($date) ? $stats[$date]->total : 0;
            $chartAverages[] = $stats->has($date) ? round($stats[$date]->average, 1) : 0;
        }

        return view('admin.dashboard', compact(
            'totalQuizzes',
            'activeQuizzes',
            'totalAttempts',
            'averageScore',
            'recentAttempts',
            'topQuizzes',
            'chartLabels',
            'chartTotals',
            'chartAverages'
        ));
    }
}
