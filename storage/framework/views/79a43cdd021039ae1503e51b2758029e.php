<?php $__env->startSection('title', __('quiz.profile_settings') ?? 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white"><?php echo e(__('quiz.profile_settings') ?? 'Profile Settings'); ?></h1>
    <p class="text-gray-400 text-sm mt-1"><?php echo e(__('quiz.update_profile') ?? 'Update your account\'s profile information and standard security.'); ?></p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <div class="glass rounded-2xl p-6">
        <h2 class="text-lg font-semibold text-white mb-4"><?php echo e(__('quiz.personal_info') ?? 'Personal Information'); ?></h2>
        
        <form method="POST" action="<?php echo e(route('admin.profile.update')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.name') ?? 'Name'); ?></label>
                <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                <?php $__errorArgs = ['name'];
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
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.email') ?? 'Email'); ?></label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
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

            <hr class="border-white/10 my-6">

            <h2 class="text-lg font-semibold text-white mb-4"><?php echo e(__('quiz.update_password') ?? 'Update Password'); ?></h2>
            <p class="text-xs text-gray-400 mb-4"><?php echo e(__('quiz.update_password_hint') ?? 'Ensure your account is using a long, random password to stay secure.'); ?></p>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.new_password') ?? 'New Password'); ?></label>
                <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
                <?php $__errorArgs = ['password'];
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
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2"><?php echo e(__('quiz.confirm_password') ?? 'Confirm Password'); ?></label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-200">
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary-dark text-dark font-bold rounded-xl transition-colors">
                    <?php echo e(__('quiz.save_changes') ?? 'Save Changes'); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/admin/profile/edit.blade.php ENDPATH**/ ?>