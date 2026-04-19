<?php $__env->startSection('title', __('quiz.quiz_submitted')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md text-center animate-slide-up">
        <div class="glass rounded-3xl p-10 shadow-2xl">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/20 rounded-full mb-6 animate-bounce-in">
                <svg class="w-10 h-10 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>

            <h1 class="text-3xl font-bold text-white mb-3"><?php echo e(__('quiz.quiz_submitted')); ?></h1>
            <p class="text-gray-400 mb-6"><?php echo __('quiz.thank_you', ['name' => '<span class="text-white font-medium">' . e($attempt->student_name) . '</span>']); ?></p>

            <div class="glass-light rounded-xl p-4 mb-6">
                <p class="text-sm text-gray-400"><?php echo e(__('quiz.results_hidden_msg')); ?></p>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500"><?php echo e(__('quiz.quiz')); ?></span>
                    <span class="text-gray-300"><?php echo e($quiz->title); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500"><?php echo e(__('quiz.submitted_at')); ?></span>
                    <span class="text-gray-300"><?php echo e($attempt->completed_at->format('M d, Y h:i A')); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/quiz/result-hidden.blade.php ENDPATH**/ ?>