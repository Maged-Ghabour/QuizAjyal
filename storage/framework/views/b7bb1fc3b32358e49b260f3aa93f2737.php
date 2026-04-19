

<?php $__env->startSection('title', __('quiz.taking_quiz', ['title' => $quiz->title])); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-6 px-4">
    <div class="max-w-3xl mx-auto">
        
        <div class="sticky top-0 z-30 mb-6">
            <div class="glass-strong rounded-2xl px-6 py-4 shadow-xl">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="text-lg font-bold text-white truncate <?php echo e(app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4'); ?>"><?php echo e($quiz->title); ?></h1>
                    <div id="timer" class="flex items-center gap-2 px-4 py-2 bg-white/5 rounded-xl font-mono text-lg font-bold timer-normal" data-end="<?php echo e($endTime); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="timer-display">--:--</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-2 bg-white/10 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-primary to-accent rounded-full transition-all duration-500 progress-animated" style="width: 0%"></div>
                    </div>
                    <span id="progress-text" class="text-xs text-gray-400 font-medium whitespace-nowrap">0 / <?php echo e($questions->count()); ?></span>
                </div>
            </div>
        </div>

        
        <form method="POST" action="<?php echo e(route('quiz.submit', $quiz->slug)); ?>" id="quiz-form">
            <?php echo csrf_field(); ?>

            <div class="space-y-6 stagger-children">
                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="question-card animate-slide-up opacity-0" data-question="<?php echo e($index); ?>" id="question-<?php echo e($question->id); ?>">
                        
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-primary/20 text-primary-light rounded-lg text-sm font-bold"><?php echo e($index + 1); ?></span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/5 rounded-lg text-xs font-medium text-gray-400">
                                    <?php switch($question->type):
                                        case ('mcq'): ?>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            <?php echo e(__('quiz.type_mcq')); ?>

                                            <?php break; ?>
                                        <?php case ('fill_blank'): ?>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <?php echo e(__('quiz.type_fill_blank')); ?>

                                            <?php break; ?>
                                        <?php case ('true_false'): ?>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <?php echo e(__('quiz.type_true_false')); ?>

                                            <?php break; ?>
                                        <?php case ('drag_drop'): ?>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                            <?php echo e(__('quiz.type_drag_drop')); ?>

                                            <?php break; ?>
                                        <?php case ('passage'): ?>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <?php echo e(__('quiz.type_passage')); ?>

                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </span>
                            </div>
                            <span class="text-xs text-gray-500 font-medium"><?php echo e($question->points); ?> <?php echo e(__('quiz.pts')); ?></span>
                        </div>

                        
                        <p class="text-white font-medium mb-1 text-base leading-relaxed"><?php echo e($question->question_text); ?></p>

                        
                        <?php if($question->question_image): ?>
                            <div class="my-4">
                                <img src="<?php echo e(Storage::url($question->question_image)); ?>" alt="Question image" class="rounded-xl max-h-64 object-contain mx-auto">
                            </div>
                        <?php endif; ?>

                        
                        <?php if($question->question_audio): ?>
                            <div class="my-4">
                                <audio controls class="w-full h-10 rounded-lg custom-audio">
                                    <source src="<?php echo e(Storage::url($question->question_audio)); ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mt-5">
                            <?php echo $__env->make('components.questions.' . str_replace('_', '-', $question->type), ['question' => $question], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-8 mb-12">
                <button type="submit" id="submit-btn"
                        class="w-full py-4 bg-gradient-to-r from-success to-emerald-600 hover:from-emerald-500 hover:to-success rounded-2xl font-bold text-white text-lg shadow-lg shadow-success/25 hover:shadow-success/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php echo e(__('quiz.submit_quiz')); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer
    const timerEl = document.getElementById('timer');
    const timerDisplay = document.getElementById('timer-display');
    const endTime = parseInt(timerEl.dataset.end) * 1000;

    function updateTimer() {
        const now = Date.now();
        const remaining = Math.max(0, endTime - now);
        const minutes = Math.floor(remaining / 60000);
        const seconds = Math.floor((remaining % 60000) / 1000);

        timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        const totalDuration = <?php echo e($quiz->duration_minutes); ?> * 60 * 1000;
        const percentRemaining = (remaining / totalDuration) * 100;

        timerEl.classList.remove('timer-normal', 'timer-warning', 'timer-danger');
        if (percentRemaining <= 10) {
            timerEl.classList.add('timer-danger');
        } else if (percentRemaining <= 30) {
            timerEl.classList.add('timer-warning');
        } else {
            timerEl.classList.add('timer-normal');
        }

        if (remaining <= 0) {
            timerDisplay.textContent = '00:00';
            document.getElementById('quiz-form').submit();
            return;
        }

        requestAnimationFrame(updateTimer);
    }
    updateTimer();

    // Progress tracking
    const totalQuestions = <?php echo e($questions->count()); ?>;
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');

    function updateProgress() {
        let answered = 0;
        document.querySelectorAll('.question-card').forEach(card => {
            const inputs = card.querySelectorAll('input, select, textarea');
            let hasAnswer = false;
            inputs.forEach(input => {
                if (input.type === 'radio' || input.type === 'checkbox') {
                    if (input.checked) hasAnswer = true;
                } else if (input.value.trim()) {
                    hasAnswer = true;
                }
            });
            if (hasAnswer) answered++;
        });

        const percent = (answered / totalQuestions) * 100;
        progressBar.style.width = percent + '%';
        progressText.textContent = `${answered} / ${totalQuestions}`;
    }

    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('change', updateProgress);
        el.addEventListener('input', updateProgress);
    });

    // Confirm before leaving
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '';
    });

    document.getElementById('quiz-form').addEventListener('submit', function() {
        window.removeEventListener('beforeunload', function() {});
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/quiz/take.blade.php ENDPATH**/ ?>