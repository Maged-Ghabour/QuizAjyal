{{-- Passage Question Component --}}
@php
    use Illuminate\Support\Facades\Storage;
@endphp

{{-- Passage text box --}}
<div class="rounded-xl bg-white/5 border border-white/10 p-5 mb-5">
    <div class="flex items-center gap-2 mb-3">
        <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <span class="text-xs font-semibold text-accent uppercase tracking-wider">{{ __('quiz.passage_text') }}</span>
    </div>
    <p class="text-gray-200 text-sm leading-relaxed whitespace-pre-line">{{ $question->question_text }}</p>
</div>

{{-- Sub-questions --}}
<div class="space-y-5">
    @foreach($question->passageSubQuestions as $sqIndex => $subQ)
        <div class="rounded-xl bg-white/[0.03] border border-white/10 p-4">
            {{-- Sub-question header --}}
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center justify-center w-6 h-6 bg-accent/20 text-accent rounded-md text-xs font-bold flex-shrink-0">
                    {{ $sqIndex + 1 }}
                </span>
                <p class="text-white text-sm font-medium leading-snug">{{ $subQ->sub_question_text }}</p>
                <span class="ms-auto text-xs text-gray-500 whitespace-nowrap">{{ $subQ->points }} {{ __('quiz.pts') }}</span>
            </div>

            {{-- MCQ options --}}
            @if($subQ->type === 'mcq')
                <div class="space-y-2 ps-8">
                    @foreach($subQ->options as $opt)
                        <label class="option-card flex items-center gap-3 px-4 py-2.5 cursor-pointer
                                      has-[:checked]:bg-primary/15 has-[:checked]:border-primary/40">
                            <input type="radio"
                                   name="answers[{{ $question->id }}][{{ $subQ->id }}]"
                                   value="{{ $opt->id }}"
                                   class="w-4 h-4 text-primary bg-white/5 border-white/20 focus:ring-primary/30">
                            <span class="inline-flex items-center justify-center w-5 h-5 bg-white/10 rounded text-xs font-semibold text-gray-300 flex-shrink-0">
                                {{ $opt->label }}
                            </span>
                            <span class="text-sm text-gray-200">{{ $opt->option_text }}</span>
                        </label>
                    @endforeach
                </div>

            {{-- Fill in the blank --}}
            @elseif($subQ->type === 'fill_blank')
                <div class="ps-8">
                    <input type="text"
                           name="answers[{{ $question->id }}][{{ $subQ->id }}]"
                           placeholder="{{ __('quiz.type_answer_placeholder') }}"
                           class="w-full px-4 py-2.5 bg-white/5 border border-white/15 rounded-xl text-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary/40 transition-all">
                </div>

            {{-- True / False --}}
            @elseif($subQ->type === 'true_false')
                <div class="grid grid-cols-2 gap-3 ps-8">
                    <label class="option-card flex items-center justify-center py-2.5 cursor-pointer text-center
                                  has-[:checked]:bg-success/15 has-[:checked]:border-success/40">
                        <input type="radio"
                               name="answers[{{ $question->id }}][{{ $subQ->id }}]"
                               value="true"
                               class="sr-only">
                        <span class="text-sm font-medium text-gray-300">{{ __('quiz.true') }}</span>
                    </label>
                    <label class="option-card flex items-center justify-center py-2.5 cursor-pointer text-center
                                  has-[:checked]:bg-danger/15 has-[:checked]:border-danger/40">
                        <input type="radio"
                               name="answers[{{ $question->id }}][{{ $subQ->id }}]"
                               value="false"
                               class="sr-only">
                        <span class="text-sm font-medium text-gray-300">{{ __('quiz.false') }}</span>
                    </label>
                </div>
            @endif
        </div>
    @endforeach
</div>
