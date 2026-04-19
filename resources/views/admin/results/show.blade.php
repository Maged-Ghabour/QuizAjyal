@extends('layouts.admin')

@section('title', __('quiz.result') . ': ' . $attempt->student_name)

@section('content')
<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('admin.results.index') }}" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5 back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-white">{{ __('quiz.result_of', ['name' => $attempt->student_name]) }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $attempt->quiz->title }}</p>
    </div>
</div>

{{-- Summary card --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold {{ $attempt->is_passed ? 'text-success' : 'text-danger' }}">{{ $attempt->percentage }}%</div>
        <div class="text-xs text-gray-500 mt-1">{{ __('quiz.score') }}</div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-white">{{ $attempt->score }}<span class="text-lg text-gray-500">/{{ $attempt->total_points }}</span></div>
        <div class="text-xs text-gray-500 mt-1">{{ __('quiz.points') }}</div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-primary-light">{{ $attempt->answers->where('is_correct', true)->count() }}</div>
        <div class="text-xs text-gray-500 mt-1">{{ __('quiz.correct_answers') }}</div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="text-3xl font-bold text-danger">{{ $attempt->answers->where('is_correct', false)->count() }}</div>
        <div class="text-xs text-gray-500 mt-1">{{ __('quiz.wrong_answers') }}</div>
    </div>
    <div class="glass rounded-2xl p-5 text-center">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $attempt->is_passed ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }}">
            {{ $attempt->is_passed ? __('quiz.PASS') : __('quiz.FAIL') }}
        </div>
        <div class="text-xs text-gray-500 mt-1">{{ __('quiz.result') }}</div>
    </div>
</div>

{{-- Student info --}}
<div class="glass rounded-2xl p-5 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div>
            <span class="text-gray-500 block text-xs mb-1">{{ __('quiz.student') }}</span>
            <span class="text-gray-200 font-medium">{{ $attempt->student_name }}</span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1">{{ __('quiz.phone') }}</span>
            <span class="text-gray-200 font-medium">{{ $attempt->student_phone }}</span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1">{{ __('quiz.started') }}</span>
            <span class="text-gray-200 font-medium">{{ $attempt->started_at?->format('M d, Y h:i A') ?? __('quiz.na') }}</span>
        </div>
        <div>
            <span class="text-gray-500 block text-xs mb-1">{{ __('quiz.duration') }}</span>
            <span class="text-gray-200 font-medium">{{ $attempt->duration ?? __('quiz.na') }}</span>
        </div>
    </div>
</div>

{{-- Answer breakdown --}}
<h3 class="text-lg font-semibold text-white mb-4">{{ __('quiz.answer_details') }}</h3>
<div class="space-y-4">
    @foreach($attempt->answers as $index => $answer)
        <div class="glass rounded-2xl p-5 result-border-left {{ $answer->is_correct ? 'border-l-4 border-success' : 'border-l-4 border-danger' }}">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-400">Q{{ $index + 1 }}.</span>
                    <span class="inline-flex items-center px-2 py-0.5 bg-white/5 rounded-lg text-xs text-gray-400">
                        {{ __('quiz.type_' . $answer->question->type) }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $answer->is_correct ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }}">
                        {{ $answer->is_correct ? __('quiz.correct_mark') : __('quiz.wrong_mark') }}
                    </span>
                    <span class="text-xs text-gray-500">{{ $answer->points_earned }}/{{ $answer->question->points }} {{ __('quiz.pts') }}</span>
                </div>
            </div>

            <p class="text-white text-sm mb-3">{{ $answer->question->question_text }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                <div class="p-3 rounded-xl {{ $answer->question->type === 'essay' ? 'bg-indigo-500/5 border border-indigo-500/20 col-span-full' : ($answer->is_correct ? 'bg-success/5 border border-success/20' : 'bg-danger/5 border border-danger/20') }}">
                    <span class="text-xs font-medium {{ $answer->question->type === 'essay' ? 'text-indigo-400' : ($answer->is_correct ? 'text-success/60' : 'text-danger/60') }} block mb-1">{{ __('quiz.student_answer') }}</span>
                    <span class="text-gray-200">
                        @php
                            $studentAnswer = $answer->student_answer;
                            if (in_array($answer->question->type, ['mcq', 'image_choice'])) {
                                $selectedOption = $answer->question->options->firstWhere('id', $studentAnswer);
                                $studentAnswer = $selectedOption ? $selectedOption->option_text : $studentAnswer;
                            } elseif (in_array($answer->question->type, ['match', 'drag_drop'])) {
                                $decoded = json_decode($studentAnswer, true);
                                if (is_array($decoded)) {
                                    $parts = [];
                                    foreach ($answer->question->matchPairs as $pair) {
                                        $matchedId = $decoded[$pair->id] ?? null;
                                        $matchedPair = $answer->question->matchPairs->firstWhere('id', $matchedId);
                                        $parts[] = $pair->left_text . ' → ' . ($matchedPair ? $matchedPair->right_text : '?');
                                    }
                                    $studentAnswer = implode(' | ', $parts);
                                }
                            }
                        @endphp
                        {{ $studentAnswer ?: __('quiz.no_answer') }}
                    </span>

                    @if($answer->question->type === 'essay')
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <form action="{{ route('admin.results.grade', ['attempt' => $attempt->id, 'answer' => $answer->id]) }}" method="POST" class="flex gap-2 items-end">
                                @csrf
                                <div class="w-24">
                                    <label class="block text-xs font-medium text-gray-400 mb-1">الدرجة (من {{ $answer->question->points }})</label>
                                    <input type="number" name="points" min="0" max="{{ $answer->question->points }}" value="{{ $answer->points_earned }}" required class="w-full px-2 py-1.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary">
                                </div>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white text-xs font-bold transition-colors">
                                    حفظ الدرجة
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                @if($answer->question->type !== 'essay')
                    <div class="p-3 rounded-xl bg-success/5 border border-success/10">
                        <span class="text-xs font-medium text-success/60 block mb-1">{{ __('quiz.correct_answer_label') }}</span>
                        <span class="text-gray-200">
                            @if(in_array($answer->question->type, ['mcq', 'image_choice']))
                                {{ $answer->question->options->firstWhere('is_correct', true)?->option_text ?? $answer->question->correct_answer }}
                            @elseif(in_array($answer->question->type, ['match', 'drag_drop']))
                                {{ $answer->question->matchPairs->map(fn($p) => $p->left_text . ' → ' . $p->right_text)->implode(' | ') }}
                            @else
                                {{ $answer->question->correct_answer }}
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
