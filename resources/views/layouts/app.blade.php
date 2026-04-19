<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('quiz.quiz')) — {{ isset($system_settings['site_name']) ? $system_settings['site_name'] : 'أجيال المستقبل' }}</title>
    <meta name="description" content="@yield('description', 'Take interactive quizzes and test your knowledge')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Noto+Kufi+Arabic:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-dark text-white font-sans antialiased">
    {{-- Animated background orbs --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-secondary/15 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-20 left-1/3 w-72 h-72 bg-accent/15 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
    </div>

    {{-- Language switcher --}}
    <div class="fixed top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }} z-50">
        <form action="{{ route('language.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" method="POST">
            @csrf
            <button type="submit" class="lang-switch-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                {{ __('quiz.switch_language') }}
            </button>
        </form>
    </div>

    {{-- Toast notifications --}}
    @if(session('success'))
        <div id="toast-success" class="fixed top-6 z-50 animate-slide-up {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }}">
            <div class="glass-strong rounded-xl px-6 py-4 flex items-center gap-3 shadow-2xl border-success/30">
                <svg class="w-5 h-5 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('toast-success')?.remove(), 4000);</script>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed top-6 z-50 animate-slide-up {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }}">
            <div class="glass-strong rounded-xl px-6 py-4 flex items-center gap-3 shadow-2xl border-danger/30">
                <svg class="w-5 h-5 text-danger flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('toast-error')?.remove(), 4000);</script>
    @endif

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
