<?php $__env->startSection('title', $quiz->title); ?>
<?php $__env->startSection('description', $quiz->description); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg animate-slide-up">
        
        <div class="glass rounded-3xl overflow-hidden shadow-2xl">
            
            <div class="relative bg-gradient-to-br from-primary via-primary-dark to-surface p-8 pb-12">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-50"></div>
                <div class="relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-xs font-medium text-white/80 mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <?php echo e($quiz->duration_minutes); ?> <?php echo e(__('quiz.minutes')); ?>

                    </div>
                    <h1 class="text-3xl font-bold text-white mb-3"><?php echo e($quiz->title); ?></h1>
                    <?php if($quiz->description): ?>
                        <p class="text-white/70 text-sm leading-relaxed"><?php echo e($quiz->description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="grid grid-cols-3 -mt-6 mx-6 relative z-10 mb-8">
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-primary-light"><?php echo e($quiz->questions_count); ?></div>
                    <div class="text-xs text-gray-400 mt-1"><?php echo e(__('quiz.questions_label')); ?></div>
                </div>
                <div class="glass rounded-xl p-4 text-center mx-2">
                    <div class="text-2xl font-bold text-accent"><?php echo e($quiz->duration_minutes); ?></div>
                    <div class="text-xs text-gray-400 mt-1"><?php echo e(__('quiz.minutes_label')); ?></div>
                </div>
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-secondary"><?php echo e($quiz->pass_percentage ?? 50); ?>%</div>
                    <div class="text-xs text-gray-400 mt-1"><?php echo e(__('quiz.to_pass')); ?></div>
                </div>
            </div>

            
            <div class="px-8 pb-8">
                <h2 class="text-lg font-semibold text-white mb-4"><?php echo e(__('quiz.enter_info')); ?></h2>
                <form method="POST" action="<?php echo e(route('quiz.start', $quiz->slug)); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="student_name" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.full_name')); ?></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4'); ?> flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="student_name" id="student_name" value="<?php echo e(old('student_name')); ?>" required
                                   class="w-full <?php echo e(app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4'); ?> py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                                   placeholder="<?php echo e(__('quiz.name_placeholder')); ?>">
                        </div>
                        <?php $__errorArgs = ['student_name'];
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
                        <label for="student_phone" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.phone_number')); ?></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4'); ?> flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="student_phone" id="student_phone" value="<?php echo e(old('student_phone')); ?>" required
                                   class="w-full <?php echo e(app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4'); ?> py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                                   placeholder="<?php echo e(__('quiz.phone_placeholder')); ?>">
                        </div>
                        <?php $__errorArgs = ['student_phone'];
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

                    <button type="submit"
                            class="w-full py-3.5 mt-4 bg-gradient-to-r from-primary to-secondary hover:from-primary-light hover:to-secondary/90 rounded-xl font-semibold text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                        <span><?php echo e(__('quiz.start_quiz')); ?></span>
                        <svg class="w-5 h-5 arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/quiz/landing.blade.php ENDPATH**/ ?>