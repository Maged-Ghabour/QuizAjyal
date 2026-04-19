@extends('layouts.app')

@section('title', __('quiz.result') . ': ' . $quiz->title)

@section('content')
<div class="min-h-screen py-8 px-4">
    <div class="max-w-3xl mx-auto">
        {{-- Score card --}}
        <div class="glass rounded-3xl overflow-hidden shadow-2xl mb-8 animate-slide-up">
            <div class="relative bg-gradient-to-br {{ $attempt->is_passed ? 'from-success/20 via-emerald-900/30 to-dark' : 'from-danger/20 via-red-900/30 to-dark' }} p-8 text-center">
                {{-- Pass/Fail badge --}}
                <div class="mb-4 animate-bounce-in">
                    @if($attempt->is_passed)
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-success/20 rounded-full mb-3">
                            <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-3xl font-bold text-success mb-1">{{ __('quiz.passed') }}</h2>
                    @else
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-danger/20 rounded-full mb-3">
                            <svg class="w-12 h-12 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-3xl font-bold text-danger mb-1">{{ __('quiz.not_passed') }}</h2>
                    @endif
                    <p class="text-gray-400 text-sm">{{ $quiz->title }}</p>
                </div>

                {{-- Score display --}}
                <div class="animate-count-up">
                    <div class="text-6xl font-black text-white mb-2">{{ $attempt->percentage }}%</div>
                    <p class="text-gray-400">{{ __('quiz.points_display', ['score' => $attempt->score, 'total' => $attempt->total_points]) }}</p>
                </div>
            </div>

            {{-- Stats row --}}
            <div class="grid grid-cols-3 gap-px bg-white/5">
                <div class="p-5 text-center bg-dark">
                    <div class="text-lg font-bold text-white">{{ $attempt->student_name }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ __('quiz.student') }}</div>
                </div>
                <div class="p-5 text-center bg-dark">
                    <div class="text-lg font-bold text-primary-light">{{ $attempt->answers->where('is_correct', true)->count() }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ __('quiz.correct_answers') }}</div>
                </div>
                <div class="p-5 text-center bg-dark">
                    <div class="text-lg font-bold text-accent">{{ $attempt->duration ?? __('quiz.na') }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ __('quiz.duration') }}</div>
                </div>
            </div>
        </div>

        {{-- Answer breakdown --}}
        <h3 class="text-xl font-bold text-white mb-4">{{ __('quiz.answer_breakdown') }}</h3>
        <div class="space-y-4 stagger-children">
            @foreach($attempt->answers as $index => $answer)
                <div class="question-card animate-slide-up opacity-0 {{ $answer->is_correct ? 'border-success/30' : 'border-danger/30' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-8 h-8 {{ $answer->is_correct ? 'bg-success/20 text-success' : 'bg-danger/20 text-danger' }} rounded-lg text-sm font-bold">
                                @if($answer->is_correct)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                @endif
                            </span>
                            <span class="text-sm font-medium text-gray-400">Q{{ $index + 1 }}</span>
                        </div>
                        <span class="text-xs font-medium {{ $answer->is_correct ? 'text-success' : 'text-danger' }}">
                            {{ $answer->points_earned }} / {{ $answer->question->points }} {{ __('quiz.pts') }}
                        </span>
                    </div>
                    <p class="text-white font-medium mb-3">{{ $answer->question->question_text }}</p>

                    <div class="space-y-2 text-sm">
                        <div class="flex items-start gap-2">
                            <span class="text-gray-500 font-medium whitespace-nowrap">{{ __('quiz.your_answer') }}</span>
                            <span class="text-gray-300">
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
                                            $studentAnswer = implode(', ', $parts);
                                        }
                                    }
                                @endphp
                                @if($answer->question->type === 'word_order')
                                    @php $woW = preg_split('/\s+/', trim($studentAnswer ?? ''), -1, PREG_SPLIT_NO_EMPTY); @endphp
                                    @if(count($woW))
                                        <span class="flex flex-wrap gap-1.5">
                                            @foreach($woW as $w)
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold
                                                    {{ $answer->is_correct ? 'bg-success/15 border border-success/25 text-success' : 'bg-danger/10 border border-danger/20 text-danger/70' }}">
                                                    {{ $w }}
                                                </span>
                                            @endforeach
                                        </span>
                                    @else
                                        <span class="italic text-gray-500">{{ __('quiz.no_answer') }}</span>
                                    @endif
                                @else
                                    {{ $studentAnswer ?: __('quiz.no_answer') }}
                                @endif
                            </span>
                        </div>
                        @if(!$answer->is_correct)
                            <div class="flex items-start gap-2">
                                <span class="text-success/60 font-medium whitespace-nowrap">{{ __('quiz.correct_label') }}</span>
                                <span class="text-success/80">
                                    @if(in_array($answer->question->type, ['mcq', 'image_choice']))
                                        {{ $answer->question->options->firstWhere('is_correct', true)?->option_text ?? $answer->question->correct_answer }}
                                    @elseif(in_array($answer->question->type, ['match', 'drag_drop']))
                                        {{ $answer->question->matchPairs->map(fn($p) => $p->left_text . ' → ' . $p->right_text)->implode(', ') }}
                                    @elseif($answer->question->type === 'word_order')
                                        @php $cwWords = preg_split('/\s+/', trim($answer->question->correct_answer ?? ''), -1, PREG_SPLIT_NO_EMPTY); @endphp
                                        <span class="flex flex-wrap gap-1.5">
                                            @foreach($cwWords as $cw)
                                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-success/15 border border-success/25 text-success">{{ $cw }}</span>
                                            @endforeach
                                        </span>
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

        {{-- Back button --}}
        <div class="mt-8 mb-12 text-center">
            <a href="{{ route('quiz.show', $quiz->slug) }}"
               class="inline-flex items-center gap-2 px-8 py-3 glass rounded-xl text-gray-300 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5 back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('quiz.take_again') }}
            </a>
        </div>
    </div>
</div>
@endsection
