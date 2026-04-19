

<?php $__env->startSection('title', __('quiz.login_title')); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md animate-slide-up">
        
        <div class="text-center mb-8">
            <?php if(!empty($system_settings['logo'])): ?>
                <img src="<?php echo e('/files/' . $system_settings['logo']); ?>" alt="Logo" class="h-20 mx-auto mb-4 object-contain">
            <?php else: ?>
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl shadow-2xl mb-4 animate-pulse-glow">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
            <?php endif; ?>
            <h1 class="text-3xl font-black text-white" style="font-family: 'Cairo', 'Noto Kufi Arabic', sans-serif;"><?php echo e(isset($system_settings['site_name']) ? $system_settings['site_name'] : __('quiz.login_title')); ?></h1>
            <p class="text-gray-400 mt-2 text-sm"><?php echo e(__('quiz.login_subtitle')); ?></p>
        </div>

        
        <div class="glass rounded-2xl p-8 shadow-2xl">
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.email')); ?></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 <?php echo e(app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4'); ?> flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full <?php echo e(app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4'); ?> py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200"
                               placeholder="<?php echo e(__('quiz.email_placeholder')); ?>">
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-danger"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.password')); ?></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 <?php echo e(app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4'); ?> flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="password" required
                               class="w-full <?php echo e(app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4'); ?> py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200"
                               placeholder="<?php echo e(__('quiz.password_placeholder')); ?>">
                    </div>
                </div>

                
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                        <span class="text-sm text-gray-400"><?php echo e(__('quiz.remember_me')); ?></span>
                    </label>
                </div>

                
                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-light hover:to-primary rounded-xl font-semibold text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0">
                    <?php echo e(__('quiz.sign_in')); ?>

                </button>
            </form>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/auth/login.blade.php ENDPATH**/ ?>