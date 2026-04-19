<?php $__env->startSection('title', __('quiz.result') . ': ' . $attempt->student_name); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-8">
    <a href="<?php echo e(route('admin.results.index')); ?>" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5 back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-white"><?php echo e(__('quiz.result_of', ['name' => $attempt->student_name])); ?></h1>
        <p class="text-gray-400 text-sm mt-1"><?php echo e($attempt->quiz->title); ?></p>
    </div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold <?php echo e($attempt->is_passed ? 'text-success' : 'text-danger'); ?>"><?php echo e($attempt->percentage); ?>%</div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(__('quiz.score')); ?></div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-white"><?php echo e($attempt->score); ?><span class="text-lg text-gray-500">/<?php echo e($attempt->total_points); ?></span></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(__('quiz.points')); ?></div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-primary-light"><?php echo e($attempt->answers->where('is_correct', true)->count()); ?></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(__('quiz.correct_answers')); ?></div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-danger"><?php echo e($attempt->answers->where('is_correct', false)->count()); ?></div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(__('quiz.wrong_answers')); ?></div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold <?php echo e($attempt->is_passed ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger'); ?>">
            <?php echo e($attempt->is_passed ? __('quiz.PASS') : __('quiz.FAIL')); ?>

        </div>
        <div class="text-xs text-gray-500 mt-1"><?php echo e(__('quiz.result')); ?></div>
    </div>
</div>


<div class="glass rounded-2xl p-5 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div>
            <span class="text-gray-500 block text-xs mb-1"><?php echo e(__('quiz.student')); ?></span>
            <span class="text-gray-200 font-medium"><?php echo e($attempt->student_name); ?></span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1"><?php echo e(__('quiz.phone')); ?></span>
            <span class="text-gray-200 font-medium"><?php echo e($attempt->student_phone); ?></span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1"><?php echo e(__('quiz.started')); ?></span>
            <span class="text-gray-200 font-medium"><?php echo e($attempt->started_at?->format('M d, Y h:i A') ?? __('quiz.na')); ?></span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1"><?php echo e(__('quiz.duration')); ?></span>
            <span class="text-gray-200 font-medium"><?php echo e($attempt->duration ?? __('quiz.na')); ?></span>
        </div>
    </div>
</div>


<h3 class="text-lg font-semibold text-white mb-4"><?php echo e(__('quiz.answer_details')); ?></h3>
<div class="space-y-4">
    <?php $__currentLoopData = $attempt->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="glass rounded-2xl p-5 result-border-left <?php echo e($answer->is_correct ? 'border-l-4 border-success' : 'border-l-4 border-danger'); ?>">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-400">Q<?php echo e($index + 1); ?>.</span>
                    <span class="inline-flex items-center px-2 py-0.5 bg-white/5 rounded-lg text-xs text-gray-400">
                        <?php echo e(__('quiz.type_' . $answer->question->type)); ?>

                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($answer->is_correct ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger'); ?>">
                        <?php echo e($answer->is_correct ? __('quiz.correct_mark') : __('quiz.wrong_mark')); ?>

                    </span>
                    <span class="text-xs text-gray-500"><?php echo e($answer->points_earned); ?>/<?php echo e($answer->question->points); ?> <?php echo e(__('quiz.pts')); ?></span>
                </div>
            </div>

            <p class="text-white text-sm mb-3"><?php echo e($answer->question->question_text); ?></p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div class="p-3 rounded-xl <?php echo e($answer->is_correct ? 'bg-success/5 border border-success/20' : 'bg-danger/5 border border-danger/20'); ?>">
                    <span class="text-xs font-medium <?php echo e($answer->is_correct ? 'text-success/60' : 'text-danger/60'); ?> block mb-1"><?php echo e(__('quiz.student_answer')); ?></span>
                    <span class="text-gray-200">
                        <?php
                            $studentAnswer = $answer->student_answer;
                            if (in_array($answer->question->type, ['mcq', 'image_choice'])) {
                                $selectedOption = $answer->question->options->firstWhere('id', $studentAnswer);
                                $studentAnswer = $selectedOption ? $selectedOption->option_text : $studentAnswer;
                            } elseif (in_array($answer->question->type, ['match', 'drag_drop'])) {
                                $decoded = json_decode($studentAnswer, true);
                                if (is_array($decoded)) {
                                    $parts = [];
                                    foreach ($answer->question->matchPairs as $pair) {
                                        $matchedId = $decoded[$pair->id] ?? null;
                                        $matchedPair = $answer->question->matchPairs->firstWhere('id', $matchedId);
                                        $parts[] = $pair->left_text . ' → ' . ($matchedPair ? $matchedPair->right_text : '?');
                                    }
                                    $studentAnswer = implode(' | ', $parts);
                                }
                            }
                        ?>
                        <?php echo e($studentAnswer ?: __('quiz.no_answer')); ?>

                    </span>
                </div>

                <div class="p-3 rounded-xl bg-success/5 border border-success/10">
                    <span class="text-xs font-medium text-success/60 block mb-1"><?php echo e(__('quiz.correct_answer_label')); ?></span>
                    <span class="text-gray-200">
                        <?php if(in_array($answer->question->type, ['mcq', 'image_choice'])): ?>
                            <?php echo e($answer->question->options->firstWhere('is_correct', true)?->option_text ?? $answer->question->correct_answer); ?>

                        <?php elseif(in_array($answer->question->type, ['match', 'drag_drop'])): ?>
                            <?php echo e($answer->question->matchPairs->map(fn($p) => $p->left_text . ' → ' . $p->right_text)->implode(' | ')); ?>

                        <?php else: ?>
                            <?php echo e($answer->question->correct_answer); ?>

                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/admin/results/show.blade.php ENDPATH**/ ?>