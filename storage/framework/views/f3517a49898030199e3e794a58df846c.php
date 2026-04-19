<?php $__env->startSection('title', __('quiz.results_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white"><?php echo e(__('quiz.results_title')); ?></h1>
        <p class="text-gray-400 text-sm mt-1"><?php echo e(__('quiz.results_subtitle')); ?></p>
    </div>
    <a href="<?php echo e(route('admin.results.export')); ?>"
       class="inline-flex items-center gap-2 px-4 py-2.5 glass rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <?php echo e(__('quiz.export_csv')); ?>

    </a>
</div>


<div class="glass rounded-2xl p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <svg class="absolute <?php echo e(app()->getLocale() === 'ar' ? 'right-3' : 'left-3'); ?> top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('quiz.search_placeholder')); ?>"
                       class="w-full <?php echo e(app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4'); ?> py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
            </div>
        </div>
        <select name="quiz_id" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 appearance-none cursor-pointer min-w-[180px]">
            <option value="" class="bg-dark"><?php echo e(__('quiz.all_quizzes')); ?></option>
            <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($quiz->id); ?>" class="bg-dark" <?php echo e(request('quiz_id') == $quiz->id ? 'selected' : ''); ?>><?php echo e($quiz->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-primary/20 hover:bg-primary/30 border border-primary/30 rounded-xl text-primary-light text-sm font-medium transition-colors">
            <?php echo e(__('quiz.filter')); ?>

        </button>
        <?php if(request()->hasAny(['search', 'quiz_id'])): ?>
            <a href="<?php echo e(route('admin.results.index')); ?>" class="px-4 py-2.5 text-gray-400 hover:text-white text-sm transition-colors"><?php echo e(__('quiz.clear')); ?></a>
        <?php endif; ?>
    </form>
</div>


<?php if($attempts->isEmpty()): ?>
    <div class="glass rounded-2xl p-12 text-center">
        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <h3 class="text-lg font-semibold text-gray-300 mb-2"><?php echo e(__('quiz.no_results_found')); ?></h3>
        <p class="text-gray-500 text-sm"><?php echo e(__('quiz.no_results_criteria')); ?></p>
    </div>
<?php else: ?>
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-<?php echo e(app()->getLocale() === 'ar' ? 'right' : 'left'); ?> px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.student')); ?></th>
                        <th class="text-<?php echo e(app()->getLocale() === 'ar' ? 'right' : 'left'); ?> px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.quiz')); ?></th>
                        <th class="text-center px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.score')); ?></th>
                        <th class="text-center px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.result')); ?></th>
                        <th class="text-<?php echo e(app()->getLocale() === 'ar' ? 'right' : 'left'); ?> px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.date')); ?></th>
                        <th class="text-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?> px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider"><?php echo e(__('quiz.action')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php $__currentLoopData = $attempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-white/[0.03] transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-medium text-gray-200"><?php echo e($attempt->student_name); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($attempt->student_phone); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-300"><?php echo e($attempt->quiz->title); ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold <?php echo e($attempt->percentage >= 70 ? 'text-success' : ($attempt->percentage >= 50 ? 'text-warning' : 'text-danger')); ?>">
                                    <?php echo e($attempt->percentage); ?>%
                                </span>
                                <div class="text-xs text-gray-500"><?php echo e($attempt->score); ?>/<?php echo e($attempt->total_points); ?></div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($attempt->is_passed ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger'); ?>">
                                    <?php echo e($attempt->is_passed ? __('quiz.pass') : __('quiz.fail')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-400"><?php echo e($attempt->completed_at->format('M d, Y')); ?></span>
                                <div class="text-xs text-gray-500"><?php echo e($attempt->completed_at->format('h:i A')); ?></div>
                            </td>
                            <td class="px-6 py-4 text-<?php echo e(app()->getLocale() === 'ar' ? 'left' : 'right'); ?>">
                                <a href="<?php echo e(route('admin.results.show', $attempt)); ?>" class="text-primary-light hover:text-primary text-sm transition-colors">
                                    <?php echo e(__('quiz.details')); ?> →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <?php echo e($attempts->links()); ?>

    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/admin/results/index.blade.php ENDPATH**/ ?>