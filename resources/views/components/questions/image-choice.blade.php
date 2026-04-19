{{-- Image Choice Question Component --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
    @foreach($question->options as $option)
        <label class="option-card relative overflow-hidden group cursor-pointer has-[:checked]:border-primary/60 has-[:checked]:ring-2 has-[:checked]:ring-primary/30 hover:border-primary/40 p-2" for="img-opt-{{ $option->id }}">
            <input type="radio"
                   name="answers[{{ $question->id }}]"
                   value="{{ $option->id }}"
                   id="img-opt-{{ $option->id }}"
                   class="sr-only">
            @if($option->option_image)
                <img src="{{ '/files/' . $option->option_image }}" alt="{{ $option->option_text }}" class="w-full h-32 object-cover rounded-lg mb-2">
            @endif
            <div class="text-center">
                <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">{{ $option->option_text }}</span>
            </div>
            <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 border-white/20 flex items-center justify-center opacity-0 group-has-[:checked]:opacity-100 bg-primary transition-all">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
        </label>
    @endforeach
</div>
