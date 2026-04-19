{{-- Drag & Drop Question Component --}}
@php
    $shuffledRight = $question->matchPairs->shuffle();
@endphp

<div class="drag-drop-container" data-question-id="{{ $question->id }}">
    <p class="text-sm font-semibold text-gray-300 mb-4 pb-2 border-b border-white/5">{{ app()->getLocale() == 'ar' ? 'اسحب العناصر من هنا:' : 'Drag items from here:' }}</p>
    
    {{-- Draggable Items (Right side mixed) --}}
    <div class="flex flex-wrap gap-4 mb-8 p-4 bg-white/5 rounded-2xl min-h-[100px] border border-white/10 items-center justify-center transition-all duration-300" id="source-zone-{{ $question->id }}" ondragover="allowDrop(event)" ondrop="drop(event)">
        @foreach($shuffledRight as $rightOption)
            <div class="draggable-item bg-white/10 border border-white/20 rounded-xl cursor-grab active:cursor-grabbing hover:bg-white/20 hover:border-white/40 transition-all w-24 h-24 sm:w-28 sm:h-28 flex flex-col items-center justify-center text-center shadow-md transform hover:-translate-y-1 shrink-0" 
                 draggable="true" 
                 ondragstart="drag(event)" 
                 id="drag-{{ $rightOption->id }}" 
                 data-id="{{ $rightOption->id }}">
                
                @if($rightOption->right_image)
                    <img src="{{ '/files/' . $rightOption->right_image }}" class="h-14 w-14 sm:h-16 sm:w-16 object-contain rounded-md mb-1 pointer-events-none drop-shadow-sm">
                @endif
                @if($rightOption->right_text)
                    <span class="text-xs sm:text-sm font-bold text-white pointer-events-none px-1 line-clamp-2 w-full">{{ $rightOption->right_text }}</span>
                @endif
            </div>
        @endforeach
        
        {{-- Empty state hint if all items are dragged --}}
        <div class="hidden source-empty-hint text-gray-400 text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'تم سحب جميع العناصر' : 'All items placed' }}</div>
    </div>

    {{-- Drop Zones (Left side items) --}}
    <div class="space-y-3">
        @foreach($question->matchPairs as $pair)
            <div class="flex items-stretch gap-3 sm:gap-4 bg-dark/40 p-2 sm:p-3 rounded-2xl border border-white/10 hover:bg-white/5 transition-colors">
                
                {{-- Left Item (Static) --}}
                <div class="w-20 sm:w-28 bg-white/10 text-center font-bold text-white flex flex-col items-center justify-center gap-1 sm:gap-2 rounded-xl p-2 shrink-0 border border-white/5 shadow-inner">
                    @if($pair->left_image)
                        <img src="{{ '/files/' . $pair->left_image }}" class="h-10 w-10 sm:h-14 sm:w-14 object-contain rounded-lg shadow-sm bg-dark/50 p-1">
                    @endif
                    @if($pair->left_text)
                        <span class="text-xs sm:text-sm">{{ $pair->left_text }}</span>
                    @endif
                </div>

                {{-- Drop Zone --}}
                <div class="flex-1 drop-zone bg-dark/60 rounded-xl border-2 border-dashed border-white/20 flex flex-col items-center justify-center transition-all relative overflow-hidden group hover:border-primary/50 min-h-[80px] sm:min-h-[96px]" 
                     ondragover="allowDrop(event)" 
                     ondrop="drop(event)"
                     data-pair-id="{{ $pair->id }}">
                    
                    <div class="drop-hint flex flex-col items-center justify-center text-gray-500 pointer-events-none gap-1 sm:gap-2 group-hover:text-gray-400 group-hover:scale-105 transition-all w-full h-full p-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span class="text-xs sm:text-sm font-medium">{{ app()->getLocale() == 'ar' ? 'اسحب وأفلت هنا' : 'Drop here' }}</span>
                    </div>
                    
                    {{-- Hidden input to store answer --}}
                    <input type="hidden" name="answers[{{ $question->id }}][{{ $pair->id }}]" class="answer-input" value="">
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<style>
.drop-zone.drag-over {
    border-color: var(--color-primary, #3b82f6);
    background-color: rgba(var(--color-primary-rgb, 59, 130, 246), 0.15);
}
.draggable-item.dragging {
    opacity: 0.6;
    transform: scale(0.95);
    box-shadow: 0 0 15px rgba(255,255,255,0.1);
}
.drop-zone .draggable-item {
    width: 100%;
    margin: 0;
    max-width: none;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: none;
    box-shadow: none;
    background: transparent;
    transform: none !important;
}
.drop-zone .draggable-item:hover {
    background: transparent;
    border: none;
}
.drop-zone .draggable-item img {
    max-height: 50px;
    margin-bottom: 0.25rem;
    margin-top: auto;
}
@media (min-width: 640px) {
    .drop-zone .draggable-item img {
        max-height: 60px;
    }
}
.drop-zone .draggable-item span {
    margin-bottom: auto;
}
</style>
<script>
if (typeof window.dragDropInitialized === 'undefined') {
    window.dragDropInitialized = true;

    window.allowDrop = function(ev) {
        ev.preventDefault();
        let target = ev.target;
        while(target && !target.classList.contains('drop-zone') && !target.id.startsWith('source-zone')) {
            target = target.parentElement;
        }
        if (target) {
            target.classList.add('drag-over');
        }
    };

    document.addEventListener('dragleave', function(ev) {
        let target = ev.target;
        if (target.classList && (target.classList.contains('drop-zone') || target.id.startsWith('source-zone'))) {
            target.classList.remove('drag-over');
        }
    });

    window.drag = function(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        ev.target.classList.add('dragging');
    };

    document.addEventListener('dragend', function(ev) {
        if (ev.target.classList && ev.target.classList.contains('draggable-item')) {
            ev.target.classList.remove('dragging');
        }
        document.querySelectorAll('.drag-over').forEach(el => el.classList.remove('drag-over'));
    });

    window.drop = function(ev) {
        ev.preventDefault();
        
        let target = ev.target;
        while(target && !target.classList.contains('drop-zone') && !target.id.startsWith('source-zone')) {
            target = target.parentElement;
        }
        
        if (!target) return;
        target.classList.remove('drag-over');
        
        var data = ev.dataTransfer.getData("text");
        var draggedElement = document.getElementById(data);
        
        if (!draggedElement) return;

        if (target.classList.contains('drop-zone')) {
            // Move existing item back if any
            const existingItem = target.querySelector('.draggable-item');
            const sourceZone = document.getElementById(`source-zone-${target.closest('.drag-drop-container').dataset.questionId}`);
            
            if (existingItem) {
                sourceZone.appendChild(existingItem);
            }
            
            target.appendChild(draggedElement);
            const hint = target.querySelector('.drop-hint');
            if (hint) hint.style.display = 'none';
            
            // Update hidden input
            const input = target.querySelector('.answer-input');
            if (input) {
                input.value = draggedElement.dataset.id;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Check if source zone is empty
            const sourceItems = sourceZone.querySelectorAll('.draggable-item');
            const emptyHint = sourceZone.querySelector('.source-empty-hint');
            if (emptyHint) {
                emptyHint.style.display = sourceItems.length === 0 ? 'block' : 'none';
            }
            
        } else if (target.id.startsWith('source-zone')) {
            target.appendChild(draggedElement);
            
            // Check if source zone is empty
            const sourceItems = target.querySelectorAll('.draggable-item');
            const emptyHint = target.querySelector('.source-empty-hint');
            if (emptyHint) {
                emptyHint.style.display = sourceItems.length === 0 ? 'block' : 'none';
            }
            
            // Handle clearing old drop zone
            document.querySelectorAll('.drop-zone').forEach(zone => {
                if (!zone.querySelector('.draggable-item')) {
                    const hint = zone.querySelector('.drop-hint');
                    if (hint) hint.style.display = 'flex';
                    
                    const input = zone.querySelector('.answer-input');
                    if (input) {
                        input.value = '';
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            });
        }
    };
}
</script>
@endpush
