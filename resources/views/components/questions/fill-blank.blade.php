{{-- Fill in the Blank Question Component --}}
<div>
    <input type="text"
           name="answers[{{ $question->id }}]"
           class="w-full px-5 py-3.5 bg-white/5 border-2 border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all text-lg font-medium tracking-wide"
           placeholder="{{ __('quiz.type_answer_placeholder') }}"
           autocomplete="off">
</div>
