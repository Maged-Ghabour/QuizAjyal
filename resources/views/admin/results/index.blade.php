@extends('layouts.admin')

@section('title', __('quiz.results_title'))

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-white">{{ __('quiz.results_title') }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ __('quiz.results_subtitle') }}</p>
    </div>
    <a href="{{ route('admin.results.export') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 glass rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        {{ __('quiz.export_csv') }}
    </a>
</div>

{{-- Filters --}}
<div class="glass rounded-2xl p-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <svg class="absolute {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('quiz.search_placeholder') }}"
                       class="w-full {{ app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
            </div>
        </div>
        <select name="quiz_id" class="px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 appearance-none cursor-pointer min-w-[180px]">
            <option value="" class="bg-dark">{{ __('quiz.all_quizzes') }}</option>
            @foreach($quizzes as $quiz)
                <option value="{{ $quiz->id }}" class="bg-dark" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>{{ $quiz->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-5 py-2.5 bg-primary/20 hover:bg-primary/30 border border-primary/30 rounded-xl text-primary-light text-sm font-medium transition-colors">
            {{ __('quiz.filter') }}
        </button>
        @if(request()->hasAny(['search', 'quiz_id']))
            <a href="{{ route('admin.results.index') }}" class="px-4 py-2.5 text-gray-400 hover:text-white text-sm transition-colors">{{ __('quiz.clear') }}</a>
        @endif
    </form>
</div>

{{-- Results table --}}
@if($attempts->isEmpty())
    <div class="glass rounded-2xl p-12 text-center">
        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <h3 class="text-lg font-semibold text-gray-300 mb-2">{{ __('quiz.no_results_found') }}</h3>
        <p class="text-gray-500 text-sm">{{ __('quiz.no_results_criteria') }}</p>
    </div>
@else
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.student') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.quiz') }}</th>
                        <th class="text-center px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.score') }}</th>
                        <th class="text-center px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.result') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.date') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }} px-6 py-4 text-xs font-medium text-gray-400 uppercase tracking-wider">{{ __('quiz.action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($attempts as $attempt)
                        <tr class="hover:bg-white/[0.03] transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-medium text-gray-200">{{ $attempt->student_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $attempt->student_phone }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-300">{{ $attempt->quiz->title }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-bold {{ $attempt->percentage >= 70 ? 'text-success' : ($attempt->percentage >= 50 ? 'text-warning' : 'text-danger') }}">
                                    {{ $attempt->percentage }}%
                                </span>
                                <div class="text-xs text-gray-500">{{ $attempt->score }}/{{ $attempt->total_points }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $attempt->is_passed ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }}">
                                    {{ $attempt->is_passed ? __('quiz.pass') : __('quiz.fail') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-400">{{ $attempt->completed_at->format('M d, Y') }}</span>
                                <div class="text-xs text-gray-500">{{ $attempt->completed_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'left' : 'right' }}">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.results.show', $attempt) }}" class="text-primary-light hover:text-primary text-sm transition-colors">
                                        {{ __('quiz.details') }} →
                                    </a>
                                    <form action="{{ route('admin.results.destroy', $attempt) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ هل أنت متأكد من حذف نتيجة هذا الطالب نهائياً؟\n\n- هذا الإجراء سيحذف كافة الإجابات والنقاط المسجلة لهذا الطالب.\n- لا يمكن التراجع عن هذا الإجراء أبداً!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger/70 hover:text-danger hover:bg-danger/10 p-1.5 rounded-lg transition-colors" title="حذف النتيجة نهائياً">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $attempts->links() }}
    </div>
@endif
@endsection
