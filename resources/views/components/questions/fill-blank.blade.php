{{-- Fill in the Blank Question Component --}}
{{-- Fill in the Blank Question Component --}}
@php
    // 1. Escape HTML for safety first
    $escapedText = e($question->question_text);
    
    // 2. Define the inline input
    $inputHtml = '<input type="text" name="answers[' . $question->id . ']" class="inline-block w-40 px-3 py-1 bg-white/10 border-b-2 border-primary/50 text-white placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white/20 transition-all text-center font-bold mx-2 shadow-inner rounded-t-lg align-middle" autocomplete="off" placeholder="'.__('quiz.type_answer_placeholder').'" dir="auto">';
    
    // 3. Replace the placeholder with the input
    if (preg_match('/_{3,}|\.{3,}|\[blank\]/i', $escapedText)) {
        $formattedText = preg_replace('/_{3,}|\.{3,}|\[blank\]/i', $inputHtml, $escapedText, 1);
    } else {
        $formattedText = $escapedText . "\n\n" . $inputHtml;
    }
    
    // 4. Split by newlines so each block can determine its own direction natively
    $lines = preg_split('/\r\n|\r|\n/', $formattedText);
    $finalHtml = '';
    foreach($lines as $line) {
        if(trim($line) !== '') {
            $finalHtml .= '<p dir="auto" class="mb-2 last:mb-0">' . $line . '</p>';
        }
    }
@endphp
<div class="text-white font-medium text-lg leading-relaxed p-4 bg-white/5 rounded-xl border border-white/10 shadow-sm">
    {!! $finalHtml !!}
</div>
