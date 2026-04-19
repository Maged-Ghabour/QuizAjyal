<?php $__env->startSection('title', __('quiz.dashboard_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white"><?php echo e(__('quiz.dashboard_title')); ?></h1>
    <p class="text-gray-400 text-sm mt-1"><?php echo e(__('quiz.dashboard_subtitle')); ?></p>
</div>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopPush(); ?>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    
    <div class="glass rounded-2xl p-6 hover:bg-white/[0.07] transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-primary/15 rounded-xl flex items-center justify-center group-hover:bg-primary/25 transition-colors">
                <svg class="w-6 h-6 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1"><?php echo e($totalQuizzes); ?></div>
        <div class="text-sm text-gray-400"><?php echo e(__('quiz.total_quizzes')); ?></div>
        <div class="text-xs text-primary-light mt-2"><?php echo e(__('quiz.active_count', ['count' => $activeQuizzes])); ?></div>
    </div>

    
    <div class="glass rounded-2xl p-6 hover:bg-white/[0.07] transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-accent/15 rounded-xl flex items-center justify-center group-hover:bg-accent/25 transition-colors">
                <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1"><?php echo e($totalAttempts); ?></div>
        <div class="text-sm text-gray-400"><?php echo e(__('quiz.total_submissions')); ?></div>
    </div>

    
    <div class="glass rounded-2xl p-6 hover:bg-white/[0.07] transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-success/15 rounded-xl flex items-center justify-center group-hover:bg-success/25 transition-colors">
                <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1"><?php echo e(round($averageScore)); ?>%</div>
        <div class="text-sm text-gray-400"><?php echo e(__('quiz.average_score')); ?></div>
    </div>

    
    <div class="glass rounded-2xl p-6 hover:bg-white/[0.07] transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-secondary/15 rounded-xl flex items-center justify-center group-hover:bg-secondary/25 transition-colors">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-white mb-1"><?php echo e($activeQuizzes); ?></div>
        <div class="text-sm text-gray-400"><?php echo e(__('quiz.active_quizzes')); ?></div>
    </div>
</div>


<div class="glass rounded-2xl p-6 mb-8 hidden sm:block">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-white"><?php echo e(__('quiz.activity_last_7_days') ?? 'Activity Last 7 Days'); ?></h2>
    </div>
    <div class="relative w-full h-[300px]">
        <canvas id="activityChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <div class="glass rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-white"><?php echo e(__('quiz.recent_submissions')); ?></h2>
            <a href="<?php echo e(route('admin.results.index')); ?>" class="text-sm text-primary-light hover:text-primary transition-colors"><?php echo e(__('quiz.view_all')); ?> →</a>
        </div>

        <?php if($recentAttempts->isEmpty()): ?>
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-500 text-sm"><?php echo e(__('quiz.no_submissions_yet')); ?></p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $recentAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.results.show', $attempt)); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-primary/30 to-accent/30 rounded-lg flex items-center justify-center text-xs font-bold text-white">
                                <?php echo e(substr($attempt->student_name, 0, 2)); ?>

                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-200 group-hover:text-white transition-colors"><?php echo e($attempt->student_name); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($attempt->quiz->title); ?> · <?php echo e($attempt->completed_at->diffForHumans()); ?></div>
                            </div>
                        </div>
                        <span class="text-sm font-bold <?php echo e($attempt->is_passed ? 'text-success' : 'text-danger'); ?>"><?php echo e($attempt->percentage); ?>%</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="glass rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-white"><?php echo e(__('quiz.popular_quizzes')); ?></h2>
            <a href="<?php echo e(route('admin.quizzes.index')); ?>" class="text-sm text-primary-light hover:text-primary transition-colors"><?php echo e(__('quiz.manage')); ?> →</a>
        </div>

        <?php if($topQuizzes->isEmpty()): ?>
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-gray-500 text-sm"><?php echo e(__('quiz.no_quizzes_yet')); ?></p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $topQuizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.quizzes.edit', $quiz)); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors group">
                        <div>
                            <div class="text-sm font-medium text-gray-200 group-hover:text-white transition-colors"><?php echo e($quiz->title); ?></div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="inline-flex items-center gap-1 text-xs <?php echo e($quiz->is_active ? 'text-success' : 'text-gray-500'); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($quiz->is_active ? 'bg-success' : 'bg-gray-500'); ?>"></span>
                                    <?php echo e($quiz->is_active ? __('quiz.active') : __('quiz.inactive')); ?>

                                </span>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-accent"><?php echo e($quiz->attempts_count); ?> <span class="text-xs text-gray-500 font-normal"><?php echo e(__('quiz.submissions')); ?></span></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
                    datasets: [
                        {
                            type: 'line',
                            label: '<?php echo e(__('quiz.average_score') ?? "Average Score"); ?> (%)',
                            data: <?php echo json_encode($chartAverages, 15, 512) ?>,
                            borderColor: '#f6df56',
                            backgroundColor: 'rgba(246, 223, 86, 0.2)',
                            borderWidth: 2,
                            tension: 0.4,
                            yAxisID: 'y1',
                        },
                        {
                            type: 'bar',
                            label: '<?php echo e(__('quiz.total_submissions') ?? "Total Submissions"); ?>',
                            data: <?php echo json_encode($chartTotals, 15, 512) ?>,
                            backgroundColor: '#6ceeec',
                            borderRadius: 6,
                            yAxisID: 'y',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            labels: { color: '#9ca3af' }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#9ca3af', stepSize: 1 }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: { color: '#f6df56', max: 100, min: 0 }
                        }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>