{{-- Word Order Question Component --}}
{{-- الكلمات مخزنة في correct_answer، نشتتها هنا --}}
@php
    $sentence    = $question->correct_answer ?? '';
    $words       = preg_split('/\s+/', trim($sentence), -1, PREG_SPLIT_NO_EMPTY);
    $shuffled    = collect($words)->shuffle()->values();
    $qId         = $question->id;
@endphp

<div class="word-order-container" data-question-id="{{ $qId }}" data-correct="{{ e($sentence) }}">

    {{-- بنك الكلمات (المشتتة) --}}
    <p class="text-xs font-semibold text-gray-400 mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 10h16M4 14h8"/>
        </svg>
        {{ app()->getLocale() === 'ar' ? 'اضغط على الكلمات بالترتيب الصحيح:' : 'Tap words in the correct order:' }}
    </p>

    <div class="word-bank flex flex-wrap gap-2 p-4 bg-white/5 rounded-2xl min-h-[56px] border border-white/10 mb-5 transition-all"
         id="bank-{{ $qId }}">
        @foreach($shuffled as $idx => $word)
            <button type="button"
                    class="word-chip bank-chip px-3 py-1.5 bg-white/10 border border-white/20 rounded-xl text-sm font-bold text-white
                           hover:bg-primary/20 hover:border-primary/40 hover:scale-105
                           active:scale-95 transition-all duration-150 cursor-pointer select-none shadow-sm"
                    data-word="{{ e($word) }}"
                    onclick="wordOrderSelect(this, {{ $qId }})">
                {{ $word }}
            </button>
        @endforeach
    </div>

    {{-- منطقة الترتيب --}}
    <p class="text-xs font-semibold text-gray-400 mb-2 flex items-center gap-2">
        <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4"/>
        </svg>
        {{ app()->getLocale() === 'ar' ? 'الجملة التي رتّبتها:' : 'Your arranged sentence:' }}
    </p>

    <div class="answer-zone flex flex-wrap gap-2 p-4 rounded-2xl min-h-[56px] border-2 border-dashed border-white/20
                bg-dark/40 hover:border-primary/30 transition-all relative group"
         id="zone-{{ $qId }}">
        <span class="zone-placeholder text-gray-500 text-sm italic pointer-events-none absolute inset-0 flex items-center justify-center">
            {{ app()->getLocale() === 'ar' ? 'ستظهر الكلمات هنا...' : 'Words will appear here...' }}
        </span>
    </div>

    {{-- زر مسح --}}
    <button type="button"
            onclick="wordOrderReset({{ $qId }})"
            class="mt-3 flex items-center gap-1.5 text-xs text-gray-500 hover:text-danger transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        {{ app()->getLocale() === 'ar' ? 'إعادة ضبط' : 'Reset' }}
    </button>

    {{-- حقل مخفي يُرسل الجملة المرتبة --}}
    <input type="hidden"
           name="answers[{{ $qId }}]"
           id="wo-answer-{{ $qId }}"
           value="">
</div>

@push('scripts')
<style>
.word-chip { user-select: none; }
.word-chip.placed {
    background: rgba(var(--color-primary-rgb, 59,130,246), 0.15);
    border-color: rgba(var(--color-primary-rgb, 59,130,246), 0.4);
    color: #a5b4fc;
    opacity: 0.4;
    pointer-events: none;
    transform: scale(0.96);
}
.zone-chip {
    background: rgba(var(--color-success-rgb, 16,185,129), 0.12);
    border: 1px solid rgba(var(--color-success-rgb,16,185,129), 0.35);
    color: #6ee7b7;
    cursor: pointer;
    padding: 0.375rem 0.75rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 700;
    transition: all 0.15s ease;
}
.zone-chip:hover {
    background: rgba(239,68,68,0.12);
    border-color: rgba(239,68,68,0.35);
    color: #fca5a5;
}
.answer-zone:not(:empty) .zone-placeholder { display: none; }
</style>
<script>
if (typeof window._woInitialized === 'undefined') {
    window._woInitialized = true;

    // قائمة كلمات كل سؤال في الـ zone
    window._woZoneWords = {};

    window.wordOrderSelect = function(btn, qId) {
        if (btn.classList.contains('placed')) return;
        const word = btn.dataset.word;
        if (!window._woZoneWords[qId]) window._woZoneWords[qId] = [];
        window._woZoneWords[qId].push({ word, bankBtn: btn });

        // وضع الكلمة في الـ zone
        const zone = document.getElementById('zone-' + qId);
        const chip = document.createElement('button');
        chip.type = 'button';
        chip.className = 'zone-chip';
        chip.textContent = word;
        chip.dataset.word = word;
        const idx = window._woZoneWords[qId].length - 1;
        chip.dataset.idx = idx;
        chip.onclick = function () { wordOrderRemove(qId, idx, chip); };
        zone.appendChild(chip);

        // إخفاء الزر من البنك
        btn.classList.add('placed');

        wordOrderUpdateAnswer(qId);
    };

    window.wordOrderRemove = function(qId, idx, chip) {
        const info = window._woZoneWords[qId][idx];
        if (info) {
            // إعادة تفعيل الزر في البنك
            info.bankBtn.classList.remove('placed');
            window._woZoneWords[qId][idx] = null;
        }
        chip.remove();
        wordOrderUpdateAnswer(qId);
    };

    window.wordOrderUpdateAnswer = function(qId) {
        const words = (window._woZoneWords[qId] || [])
            .filter(Boolean)
            .map(i => i.word);
        const input = document.getElementById('wo-answer-' + qId);
        if (input) {
            input.value = words.join(' ');
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    };

    window.wordOrderReset = function(qId) {
        // إعادة تفعيل كل أزرار البنك
        const bank = document.getElementById('bank-' + qId);
        if (bank) {
            bank.querySelectorAll('.bank-chip').forEach(b => b.classList.remove('placed'));
        }
        // تفريغ الـ zone
        const zone = document.getElementById('zone-' + qId);
        if (zone) {
            zone.querySelectorAll('.zone-chip').forEach(c => c.remove());
        }
        window._woZoneWords[qId] = [];
        wordOrderUpdateAnswer(qId);
    };
}
</script>
@endpush
