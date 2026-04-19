{{-- True/False Question Component --}}
<div class="grid grid-cols-2 gap-4">
    <label class="option-card flex flex-col items-center justify-center py-6 group hover:bg-success/10 hover:border-success/40 cursor-pointer has-[:checked]:bg-success/15 has-[:checked]:border-success/50 text-center" for="tf-true-{{ $question->id }}">
        <input type="radio"
               name="answers[{{ $question->id }}]"
               value="true"
               id="tf-true-{{ $question->id }}"
               class="sr-only">
        <svg class="w-10 h-10 text-success/60 group-hover:text-success mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-lg font-semibold text-gray-300 group-hover:text-white transition-colors">{{ __('quiz.true') }}</span>
    </label>

    <label class="option-card flex flex-col items-center justify-center py-6 group hover:bg-danger/10 hover:border-danger/40 cursor-pointer has-[:checked]:bg-danger/15 has-[:checked]:border-danger/50 text-center" for="tf-false-{{ $question->id }}">
        <input type="radio"
               name="answers[{{ $question->id }}]"
               value="false"
               id="tf-false-{{ $question->id }}"
               class="sr-only">
        <svg class="w-10 h-10 text-danger/60 group-hover:text-danger mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-lg font-semibold text-gray-300 group-hover:text-white transition-colors">{{ __('quiz.false') }}</span>
    </label>
</div>
