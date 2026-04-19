@extends('layouts.admin')

@section('title', __('quiz.edit_question') ?? 'Edit Question')

@section('content')
<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5 back-arrow rtl:-scale-x-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-white">{{ __('quiz.edit_question') ?? 'Edit Question' }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $quiz->title }}</p>
    </div>
</div>

<div class="max-w-3xl mx-auto">
    <div class="glass rounded-2xl p-6 border-2 border-dashed border-white/10">
        <form method="POST" action="{{ route('admin.quizzes.questions.update', [$quiz, $question]) }}" enctype="multipart/form-data" id="edit-question-form" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_type') }} *</label>
                    <input type="hidden" name="type" value="{{ $question->type }}">
                    <input type="text" value="{{ __('quiz.type_' . $question->type) }}" disabled class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-gray-400 text-sm opacity-70 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.points') }} *</label>
                    <input type="number" name="points" value="{{ old('points', $question->points) }}" min="1" required
                           class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_text') }} *</label>
                <textarea name="question_text" rows="2" required
                          class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all resize-none">{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_image') }}</label>
                    @if($question->question_image)
                        <div class="mb-2">
                            <img src="{{ '/files/' . $question->question_image }}" class="h-16 rounded object-contain bg-white/5 p-1 border border-white/10">
                        </div>
                    @endif
                    <input type="file" name="question_image" accept="image/*"
                           class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/20 file:text-primary-light hover:file:bg-primary/30 file:cursor-pointer cursor-pointer">
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_audio') ?? 'Audio (optional)' }}</label>
                    @if($question->question_audio)
                        <div class="mb-2">
                            <audio controls class="h-8 max-w-full">
                                <source src="{{ '/files/' . $question->question_audio }}">
                            </audio>
                        </div>
                    @endif
                    <div class="space-y-2">
                        <input type="file" name="question_audio" accept="audio/*"
                               class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/20 file:text-primary-light hover:file:bg-primary/30 file:cursor-pointer cursor-pointer">
                        <div class="flex items-center gap-2">
                            <button type="button" class="start-record-btn flex items-center gap-1.5 px-3 py-1.5 bg-danger/10 text-danger hover:bg-danger hover:text-white rounded-lg text-xs font-bold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                تسجيل صوت
                            </button>
                            <div class="recording-ui hidden flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-lg border border-danger/20">
                                <span class="animate-pulse w-2.5 h-2.5 bg-danger rounded-full"></span>
                                <span class="record-time text-xs text-danger font-mono font-bold w-10 text-center">00:00</span>
                                <button type="button" class="stop-record-btn px-2 py-0.5 bg-danger hover:bg-red-600 text-white rounded text-[10px] transition-colors ml-2 rtl:ml-0 rtl:mr-2">إيقاف</button>
                            </div>
                        </div>
                    </div>
            </div>

            {{-- Correct answer for fill_blank --}}
            @if($question->type === 'fill_blank')
            <div id="correct-answer-field">
                <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.correct_answer') }} *</label>
                <input type="text" name="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}" required
                       class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
            </div>
            @endif

            {{-- MCQ Options --}}
            @if(in_array($question->type, ['mcq', 'image_choice']))
            <div id="options-field" class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-medium text-gray-400">{{ __('quiz.options') }}</label>
                    <button type="button" onclick="addOption()" class="text-xs text-primary-light hover:text-primary transition-colors">{{ __('quiz.add_option') }}</button>
                </div>
                <div id="options-container" class="space-y-2">
                    @foreach($question->options as $i => $opt)
                    <div class="flex flex-col gap-2 option-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
                        <div class="flex items-center gap-2">
                            <input type="text" name="options[{{ $i }}][label]" value="{{ $opt->label }}" class="w-12 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-primary/50">
                            <input type="text" name="options[{{ $i }}][option_text]" value="{{ $opt->option_text }}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                            <label class="flex items-center gap-1 text-xs text-gray-400 whitespace-nowrap cursor-pointer">
                                <input type="checkbox" name="options[{{ $i }}][is_correct]" {{ $opt->is_correct ? 'checked' : '' }} class="w-4 h-4 rounded bg-white/5 border-white/20 text-success focus:ring-success/50 focus:ring-offset-0">
                                {{ __('quiz.correct') }}
                            </label>
                            <button type="button" onclick="this.closest('.option-row').remove()" class="p-1 text-gray-500 hover:text-danger">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($opt->option_image)
                                <img src="{{ Storage::url($opt->option_image) }}" class="h-6 w-6 object-cover rounded">
                            @endif
                            <input type="file" name="options[{{ $i }}][option_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20 mt-1">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Match Pairs --}}
            @if(in_array($question->type, ['match', 'drag_drop']))
            <div id="pairs-field" class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="block text-xs font-medium text-gray-400">{{ __('quiz.match_pairs') }}</label>
                    <button type="button" onclick="addPair()" class="text-xs text-primary-light hover:text-primary transition-colors">{{ __('quiz.add_pair') }}</button>
                </div>
                <div id="pairs-container" class="space-y-2">
                    @foreach($question->matchPairs as $i => $pair)
                    <div class="flex flex-col gap-2 pair-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
                        <div class="flex items-center gap-2">
                            <input type="text" name="pairs[{{ $i }}][left_text]" value="{{ $pair->left_text }}" placeholder="{{ __('quiz.left_item') }}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            <input type="text" name="pairs[{{ $i }}][right_text]" value="{{ $pair->right_text }}" placeholder="{{ __('quiz.right_item') }}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="p-1 text-gray-500 hover:text-danger">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-2 mr-6 rtl:ml-6 rtl:mr-0">
                            <div class="flex-1 flex items-center gap-2">
                                @if($pair->left_image)
                                    <img src="{{ '/files/' . $pair->left_image }}" class="h-6 w-6 object-cover rounded">
                                @endif
                                <input type="file" name="pairs[{{ $i }}][left_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20">
                            </div>
                            <div class="flex-1 flex items-center gap-2">
                                @if($pair->right_image)
                                    <img src="{{ '/files/' . $pair->right_image }}" class="h-6 w-6 object-cover rounded">
                                @endif
                                <input type="file" name="pairs[{{ $i }}][right_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- True/False selector --}}
            @if($question->type === 'true_false')
            <div id="truefalse-field">
                <label class="block text-xs font-medium text-gray-400 mb-2">{{ __('quiz.correct_answer') }} *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="option-card flex items-center justify-center py-3 cursor-pointer has-[:checked]:bg-success/15 has-[:checked]:border-success/40 text-center">
                        <input type="radio" name="correct_answer" value="true" class="sr-only" {{ $question->correct_answer === 'true' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-300">{{ __('quiz.true') }}</span>
                    </label>
                    <label class="option-card flex items-center justify-center py-3 cursor-pointer has-[:checked]:bg-danger/15 has-[:checked]:border-danger/40 text-center">
                        <input type="radio" name="correct_answer" value="false" class="sr-only" {{ $question->correct_answer === 'false' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-300">{{ __('quiz.false') }}</span>
                    </label>
                </div>
            </div>
            @endif

            {{-- Word Order field --}}
            @if($question->type === 'word_order')
            <div id="word-order-field" class="space-y-3">
                <div class="rounded-xl bg-primary/10 border border-primary/20 p-3 text-xs text-primary-light flex items-start gap-2">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('quiz.word_order_hint') }}
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.word_order_sentence') }} *</label>
                    <input type="text" name="correct_answer"
                           value="{{ old('correct_answer', $question->correct_answer) }}"
                           class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                           placeholder="{{ __('quiz.word_order_sentence_placeholder') }}">
                </div>
            </div>
            @endif

            <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-success to-emerald-600 hover:from-emerald-500 hover:to-success rounded-xl font-medium text-white text-sm shadow-lg shadow-success/25 hover:shadow-success/40 transition-all duration-300 flex items-center justify-center gap-2 mt-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ __('quiz.save_settings') ?? 'Save Changes' }}
            </button>
        </form>
    </div>
</div>

<script>
let optionCount = {{ max(count($question->options), 2) }};
function addOption() {
    const container = document.getElementById('options-container');
    const label = String.fromCharCode(65 + optionCount);
    const html = `
        <div class="flex flex-col gap-2 option-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
            <div class="flex items-center gap-2">
                <input type="text" name="options[${optionCount}][label]" value="${label}" class="w-12 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-primary/50">
                <input type="text" name="options[${optionCount}][option_text]" placeholder="Option text" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                <label class="flex items-center gap-1 text-xs text-gray-400 whitespace-nowrap cursor-pointer">
                    <input type="checkbox" name="options[${optionCount}][is_correct]" class="w-4 h-4 rounded bg-white/5 border-white/20 text-success focus:ring-success/50 focus:ring-offset-0">
                    Correct
                </label>
                <button type="button" onclick="this.closest('.option-row').remove()" class="p-1 text-gray-500 hover:text-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex items-center gap-2">
                <input type="file" name="options[${optionCount}][option_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20 mt-1">
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    optionCount++;
}

let pairCount = {{ max(count($question->matchPairs), 2) }};
function addPair() {
    const container = document.getElementById('pairs-container');
    const html = `
        <div class="flex flex-col gap-2 pair-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
            <div class="flex items-center gap-2">
                <input type="text" name="pairs[${pairCount}][left_text]" placeholder="Left Item" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                <input type="text" name="pairs[${pairCount}][right_text]" placeholder="Right item" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                <button type="button" onclick="this.parentElement.parentElement.remove()" class="p-1 text-gray-500 hover:text-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex items-center gap-2 mr-6 rtl:ml-6 rtl:mr-0">
                <div class="flex-1"><input type="file" name="pairs[${pairCount}][left_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20"></div>
                <div class="flex-1"><input type="file" name="pairs[${pairCount}][right_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20"></div>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    pairCount++;
}

// Image Preview Logic
document.addEventListener('change', function(e) {
    if (e.target.matches('input[type="file"][accept="image/*"]')) {
        const file = e.target.files[0];
        const input = e.target;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                let previewContainer = input.parentElement.querySelector('.live-image-preview');
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'live-image-preview mb-2 mt-2 inline-flex items-center gap-2';
                    input.parentElement.insertBefore(previewContainer, input);
                }
                previewContainer.innerHTML = `
                    <div class="relative group">
                        <img src="${evt.target.result}" class="h-14 w-auto rounded object-contain bg-dark/50 p-1 border border-white/10 shadow-sm" style="max-width:100px;">
                        <button type="button" class="absolute -top-1.5 -right-1.5 bg-danger text-white rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-all transform scale-90 hover:scale-110 shadow-md" onclick="removeImagePreview(this)">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    }
});

window.removeImagePreview = function(btn) {
    const container = btn.closest('.live-image-preview');
    const input = container.parentElement.querySelector('input[type="file"]');
    if (input) input.value = '';
    container.remove();
}
</script>
@endsection
