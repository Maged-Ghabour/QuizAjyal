<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() === 'ar' ? 'rtl' : 'ltr'); ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', __('quiz.quiz')); ?> — <?php echo e(isset($system_settings['site_name']) ? $system_settings['site_name'] : 'أجيال المستقبل'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Take interactive quizzes and test your knowledge'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Noto+Kufi+Arabic:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen bg-dark text-white font-sans antialiased">
    
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-secondary/15 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-20 left-1/3 w-72 h-72 bg-accent/15 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    
    <div class="fixed top-4 <?php echo e(app()->getLocale() === 'ar' ? 'left-4' : 'right-4'); ?> z-50">
        <form action="<?php echo e(route('language.switch', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="lang-switch-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                <?php echo e(__('quiz.switch_language')); ?>

            </button>
        </form>
    </div>

    
    <?php if(session('success')): ?>
        <div id="toast-success" class="fixed top-6 z-50 animate-slide-up <?php echo e(app()->getLocale() === 'ar' ? 'left-6' : 'right-6'); ?>">
            <div class="glass-strong rounded-xl px-6 py-4 flex items-center gap-3 shadow-2xl border-success/30">
                <svg class="w-5 h-5 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('toast-success')?.remove(), 4000);</script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div id="toast-error" class="fixed top-6 z-50 animate-slide-up <?php echo e(app()->getLocale() === 'ar' ? 'left-6' : 'right-6'); ?>">
            <div class="glass-strong rounded-xl px-6 py-4 flex items-center gap-3 shadow-2xl border-danger/30">
                <svg class="w-5 h-5 text-danger flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium"><?php echo e(session('error')); ?></span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('toast-error')?.remove(), 4000);</script>
    <?php endif; ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/u783610222/domains/ajyalfuture.com/public_html/quiz/resources/views/layouts/app.blade.php ENDPATH**/ ?>