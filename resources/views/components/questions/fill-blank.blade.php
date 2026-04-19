{{-- Fill in the Blank Question Component --}}
{{-- Fill in the Blank Question Component --}}
@php
    $text = $question->question_text;
    $inputHtml = '<input type="text" name="answers[' . $question->id . ']" class="inline-block w-40 px-3 py-1 bg-white/10 border-b-2 border-primary/50 text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white/20 transition-all text-center font-bold mx-2 shadow-inner rounded-t-lg" autocomplete="off" placeholder="'.__('quiz.type_answer_placeholder').'" dir="auto">';
    
    // Check if text has ___ or ... or [blank]
    if (preg_match('/_{3,}|\.{3,}|\[blank\]/i', $text)) {
        $formattedText = preg_replace('/_{3,}|\.{3,}|\[blank\]/i', $inputHtml, $text, 1);
    } else {
        $formattedText = $text . ' ' . $inputHtml;
    }
@endphp
<div class="text-white font-medium text-lg leading-relaxed flex flex-wrap items-center gap-1.5 p-4 bg-white/5 rounded-xl border border-white/10 shadow-sm" dir="auto">
    {!! $formattedText !!}
</div>
