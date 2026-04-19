<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('quiz.nav_dashboard')) — {{ __('quiz.admin_panel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&family=Inter:wght@300;400;500;600;700;800;900&family=Noto+Kufi+Arabic:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-dark text-white font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 z-40 w-64 bg-dark-lighter border-white/5 transition-transform duration-300 {{ app()->getLocale() === 'ar' ? '' : 'left-0 border-r -translate-x-full lg:translate-x-0' }}">
            <div class="flex flex-col h-full">
                {{-- Logo --}}
                <div class="px-6 py-6 border-b border-white/5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        @if(!empty($system_settings['logo']))
                            <img src="{{ '/files/' . $system_settings['logo'] }}" alt="Logo" class="w-10 h-10 object-contain rounded-xl">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-primary/30 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                        @endif
                        <span class="text-2xl font-black text-white tracking-wide shadow-sm" style="font-family: 'Cairo', 'Noto Kufi Arabic', sans-serif;">{{ isset($system_settings['site_name']) ? $system_settings['site_name'] : 'أجيال المستقبل' }}</span>
                    </a>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.dashboard') ? 'bg-primary/15 text-primary-light border border-primary/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        {{ __('quiz.nav_dashboard') }}
                    </a>
                    <a href="{{ route('admin.quizzes.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.quizzes.*') ? 'bg-primary/15 text-primary-light border border-primary/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        {{ __('quiz.nav_quizzes') }}
                    </a>
                    <a href="{{ route('admin.results.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('admin.results.*') ? 'bg-primary/15 text-primary-light border border-primary/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        {{ __('quiz.nav_results') }}
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-white/5">
                        <a href="{{ route('admin.profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200
                                {{ request()->routeIs('admin.profile.*') ? 'bg-primary/15 text-primary-light border border-primary/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ __('quiz.profile_settings') ?? 'Account Settings' }}
                        </a>
                        <a href="{{ route('admin.settings.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 mt-2
                                {{ request()->routeIs('admin.settings.*') ? 'bg-primary/15 text-primary-light border border-primary/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            {{ __('quiz.system_settings') ?? 'System Settings' }}
                        </a>
                    </div>
                </nav>

                {{-- Language switcher + User section --}}
                <div class="px-4 py-4 border-t border-white/5 space-y-3">
                    {{-- Language switch --}}
                    <form action="{{ route('language.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" method="POST">
                        @csrf
                        <button type="submit" class="lang-switch-btn w-full justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                            {{ __('quiz.switch_language') }}
                        </button>
                    </form>

                    {{-- User --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-accent rounded-lg flex items-center justify-center text-xs font-bold">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-400">{{ auth()->user()->name ?? 'Admin' }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-danger transition-colors" title="{{ __('quiz.logout') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden" onclick="closeSidebar()"></div>

        {{-- Main content --}}
        <div class="flex-1 main-content {{ app()->getLocale() === 'ar' ? '' : 'lg:ml-64' }}">
            {{-- Top bar (mobile) --}}
            <header class="lg:hidden bg-dark-lighter/80 backdrop-blur-lg border-b border-white/5 sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 py-3">
                    <button onclick="toggleSidebar()" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <span class="text-xl font-black text-white" style="font-family: 'Cairo', 'Noto Kufi Arabic', sans-serif;">{{ isset($system_settings['site_name']) ? $system_settings['site_name'] : 'Quizez' }}</span>
                    <div class="w-6"></div>
                </div>
            </header>

            {{-- Toast notifications --}}
            @if(session('success'))
                <div id="toast-success" class="fixed top-6 z-50 animate-slide-up toast-position {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }}">
                    <div class="glass-strong rounded-xl px-6 py-4 flex items-center gap-3 shadow-2xl border-success/30">
                        <svg class="w-5 h-5 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
                <script>setTimeout(() => document.getElementById('toast-success')?.remove(), 4000);</script>
            @endif

            {{-- Page content --}}
            <main class="p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const isRtl = document.documentElement.dir === 'rtl';

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (isRtl) {
                sidebar.classList.toggle('sidebar-open');
                const isOpen = sidebar.classList.contains('sidebar-open');
                sidebar.style.transform = isOpen ? 'translateX(0)' : 'translateX(100%)';
            } else {
                sidebar.classList.toggle('-translate-x-full');
            }
            overlay.classList.toggle('hidden');
        }
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (isRtl) {
                sidebar.classList.remove('sidebar-open');
                sidebar.style.transform = 'translateX(100%)';
            } else {
                sidebar.classList.add('-translate-x-full');
            }
            overlay.classList.add('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
