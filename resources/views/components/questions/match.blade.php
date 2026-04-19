{{-- Match Question Component --}}
<div class="space-y-3">
    @php
        $shuffledRight = $question->matchPairs->shuffle();
    @endphp

    @foreach($question->matchPairs as $pair)
        <div class="flex items-center gap-4">
            <div class="flex-1 glass-light rounded-xl px-4 py-3 text-center font-medium text-white flex flex-col items-center justify-center gap-2">
                @if($pair->left_image)
                    <img src="{{ '/files/' . $pair->left_image }}" class="max-h-32 object-contain rounded-lg">
                @endif
                @if($pair->left_text)
                    <span>{{ $pair->left_text }}</span>
                @endif
            </div>

            <svg class="w-6 h-6 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>

            <select name="answers[{{ $question->id }}][{{ $pair->id }}]"
                    class="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all appearance-none cursor-pointer">
                <option value="" class="bg-dark">{{ __('quiz.select_match') }}</option>
                @foreach($shuffledRight as $rightOption)
                    <option value="{{ $rightOption->id }}" class="bg-dark">{{ $rightOption->right_text ?: __('quiz.image_option', [], 'ar') }}</option>
                @endforeach
            </select>
        </div>
    @endforeach
</div>
