<?php $__env->startSection('title', __('quiz.create_quiz_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-8">
    <a href="<?php echo e(route('admin.quizzes.index')); ?>" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5 back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-white"><?php echo e(__('quiz.create_quiz_title')); ?></h1>
        <p class="text-gray-400 text-sm mt-1"><?php echo e(__('quiz.create_quiz_subtitle')); ?></p>
    </div>
</div>

<div class="max-w-2xl">
    <form method="POST" action="<?php echo e(route('admin.quizzes.store')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="glass rounded-2xl p-6 space-y-5">
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.quiz_title')); ?> *</label>
                <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" required
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                       placeholder="<?php echo e(__('quiz.quiz_title_placeholder')); ?>">
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-danger"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.description')); ?></label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all resize-none"
                          placeholder="<?php echo e(__('quiz.description_placeholder')); ?>"><?php echo e(old('description')); ?></textarea>
            </div>

            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.duration_label')); ?> *</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" value="<?php echo e(old('duration_minutes', 15)); ?>" min="1" max="300" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                </div>
                <div>
                    <label for="pass_percentage" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.pass_percentage')); ?> *</label>
                    <input type="number" name="pass_percentage" id="pass_percentage" value="<?php echo e(old('pass_percentage', 60)); ?>" min="0" max="100" required
                           class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                </div>
            </div>

            
            <div class="space-y-3 pt-2">
                <label class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer">
                    <div>
                        <span class="text-sm font-medium text-gray-200"><?php echo e(__('quiz.is_active')); ?></span>
                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e(__('quiz.is_active_desc')); ?></p>
                    </div>
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                           class="w-5 h-5 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                </label>
                <label class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer">
                    <div>
                        <span class="text-sm font-medium text-gray-200"><?php echo e(__('quiz.show_results')); ?></span>
                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e(__('quiz.show_results_desc')); ?></p>
                    </div>
                    <input type="checkbox" name="show_results" value="1" <?php echo e(old('show_results', true) ? 'checked' : ''); ?>

                           class="w-5 h-5 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                </label>
                <label class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer">
                    <div>
                        <span class="text-sm font-medium text-gray-200"><?php echo e(__('quiz.randomize_questions')); ?></span>
                        <p class="text-xs text-gray-500 mt-0.5"><?php echo e(__('quiz.randomize_questions_desc')); ?></p>
                    </div>
                    <input type="checkbox" name="randomize_questions" value="1" <?php echo e(old('randomize_questions') ? 'checked' : ''); ?>

                           class="w-5 h-5 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                </label>
            </div>
        </div>

        <button type="submit"
                class="w-full py-3.5 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-light hover:to-primary rounded-xl font-semibold text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <?php echo e(__('quiz.create_and_add')); ?>

        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/admin/quizzes/create.blade.php ENDPATH**/ ?>