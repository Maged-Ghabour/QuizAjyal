@extends('layouts.admin')

@section('title', __('quiz.quizzes_title'))

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">{{ __('quiz.quizzes_title') }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ __('quiz.quizzes_subtitle') }}</p>
    </div>
    <a href="{{ route('admin.quizzes.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-light hover:to-primary rounded-xl font-medium text-white text-sm shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all duration-300 transform hover:-translate-y-0.5">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        {{ __('quiz.new_quiz') }}
    </a>
</div>

@if($quizzes->isEmpty())
    <div class="glass rounded-2xl p-12 text-center">
        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <h3 class="text-lg font-semibold text-gray-300 mb-2">{{ __('quiz.no_quizzes_found') }}</h3>
        <p class="text-gray-500 text-sm mb-6">{{ __('quiz.create_first_quiz') }}</p>
        <a href="{{ route('admin.quizzes.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary-light rounded-xl font-medium text-white text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('quiz.create_quiz') }}
        </a>
    </div>
@else
    <div class="space-y-4">
        @foreach($quizzes as $quiz)
            <div class="glass rounded-2xl p-5 hover:bg-white/[0.07] transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0 {{ app()->getLocale() === 'ar' ? 'ml-4' : 'mr-4' }}">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-semibold text-white truncate group-hover:text-primary-light transition-colors">{{ $quiz->title }}</h3>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $quiz->is_active ? 'bg-success/15 text-success' : 'bg-gray-500/15 text-gray-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $quiz->is_active ? 'bg-success' : 'bg-gray-500' }}"></span>
                                {{ $quiz->is_active ? __('quiz.active') : __('quiz.inactive') }}
                            </span>
                        </div>
                        @if($quiz->description)
                            <p class="text-gray-400 text-sm truncate mb-3">{{ $quiz->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('quiz.questions_count', ['count' => $quiz->questions_count]) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('quiz.duration_minutes', ['count' => $quiz->duration_minutes]) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ __('quiz.submissions_count', ['count' => $quiz->attempts_count]) }}
                            </span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                        <button onclick="copyToClipboard('{{ route('quiz.show', $quiz->slug) }}')" title="{{ __('quiz.copy_quiz_link') }}"
                                class="p-2 rounded-lg hover:bg-white/10 text-gray-400 hover:text-accent transition-colors">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                        </button>
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" title="{{ __('quiz.edit') }}"
                           class="p-2 rounded-lg hover:bg-white/10 text-gray-400 hover:text-primary-light transition-colors">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('{{ __('quiz.delete_quiz_confirm') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" title="{{ __('quiz.delete') }}"
                                    class="p-2 rounded-lg hover:bg-danger/10 text-gray-400 hover:text-danger transition-colors">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $quizzes->links() }}
    </div>
@endif

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 {{ app()->getLocale() === "ar" ? "left-6" : "right-6" }} z-50 glass-strong rounded-xl px-6 py-3 text-sm font-medium text-success animate-slide-up';
        toast.textContent = '{{ __("quiz.link_copied") }}';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>
@endsection
