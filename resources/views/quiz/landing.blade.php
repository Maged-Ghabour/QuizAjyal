@extends('layouts.app')

@section('title', $quiz->title)
@section('description', $quiz->description)

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg animate-slide-up">
        {{-- Quiz card --}}
        <div class="glass rounded-3xl overflow-hidden shadow-2xl">
            {{-- Header gradient --}}
            <div class="relative bg-gradient-to-br from-primary via-primary-dark to-surface p-8 pb-12">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-50"></div>
                <div class="relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-xs font-medium text-white/80 mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $quiz->duration_minutes }} {{ __('quiz.minutes') }}
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-3">{{ $quiz->title }}</h1>
                    @if($quiz->description)
                        <p class="text-white/70 text-sm leading-relaxed">{{ $quiz->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 -mt-6 mx-6 relative z-10 mb-8">
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-primary-light">{{ $quiz->questions_count }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ __('quiz.questions_label') }}</div>
                </div>
                <div class="glass rounded-xl p-4 text-center mx-2">
                    <div class="text-2xl font-bold text-accent">{{ $quiz->duration_minutes }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ __('quiz.minutes_label') }}</div>
                </div>
                <div class="glass rounded-xl p-4 text-center">
                    <div class="text-2xl font-bold text-secondary">{{ $quiz->pass_percentage ?? 50 }}%</div>
                    <div class="text-xs text-gray-400 mt-1">{{ __('quiz.to_pass') }}</div>
                </div>
            </div>

            {{-- Student form --}}
            <div class="px-8 pb-8">
                <h2 class="text-lg font-semibold text-white mb-4">{{ __('quiz.enter_info') }}</h2>
                <form method="POST" action="{{ route('quiz.start', $quiz->slug) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="student_name" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.full_name') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" required
                                   class="w-full {{ app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4' }} py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                                   placeholder="{{ __('quiz.name_placeholder') }}">
                        </div>
                        @error('student_name')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_phone" class="block text-sm font-medium text-gray-300 mb-2">{{ __('quiz.phone_number') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-4' : 'left-0 pl-4' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="student_phone" id="student_phone" value="{{ old('student_phone') }}" required
                                   class="w-full {{ app()->getLocale() === 'ar' ? 'pr-12 pl-4' : 'pl-12 pr-4' }} py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                                   placeholder="{{ __('quiz.phone_placeholder') }}">
                        </div>
                        @error('student_phone')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 mt-4 bg-gradient-to-r from-primary to-secondary hover:from-primary-light hover:to-secondary/90 rounded-xl font-semibold text-white shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                        <span>{{ __('quiz.start_quiz') }}</span>
                        <svg class="w-5 h-5 arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
