@extends('layouts.admin')

@section('title', __('quiz.edit') . ': ' . $quiz->title)

@section('content')
<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('admin.quizzes.index') }}" class="p-2 rounded-lg hover:bg-white/5 text-gray-400 hover:text-white transition-colors">
        <svg class="w-5 h-5 back-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div class="flex-1">
        <h1 class="text-2xl font-bold text-white">{{ $quiz->title }}</h1>
        <p class="text-gray-400 text-sm mt-1">{{ __('quiz.edit_quiz_subtitle') }}</p>
    </div>
    <div class="flex items-center gap-2">
        {{-- Preview button --}}
        <a href="{{ route('admin.quizzes.preview', $quiz) }}" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 glass rounded-xl text-sm text-amber-300 hover:text-white hover:bg-amber-500/20 border border-amber-500/20 hover:border-amber-500/40 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            معاينة
        </a>

        <button onclick="copyToClipboard('{{ route('quiz.show', $quiz->slug) }}')"
                class="inline-flex items-center gap-2 px-4 py-2 glass rounded-xl text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            {{ __('quiz.share_link') }}
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left column: Quiz settings --}}
    <div class="lg:col-span-1">
        <div class="glass rounded-2xl p-6 sticky top-6">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('quiz.quiz_settings') }}</h2>

            <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label for="title" class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $quiz->title) }}" required
                           class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                </div>

                <div>
                    <label for="description" class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.description') }}</label>
                    <textarea name="description" id="description" rows="2"
                              class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all resize-none">{{ old('description', $quiz->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="duration_minutes" class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.duration_min') }}</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $quiz->duration_minutes) }}" min="1" max="300" required
                               class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                    </div>
                    <div>
                        <label for="pass_percentage" class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.pass_percentage') }}</label>
                        <input type="number" name="pass_percentage" id="pass_percentage" value="{{ old('pass_percentage', $quiz->pass_percentage) }}" min="0" max="100" required
                               class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                    </div>
                </div>

                <div>
                    <label for="max_attempts" class="block text-xs font-medium text-gray-400 mb-1">
                        الحد الأقصى للمحاولات
                        <span class="text-gray-600">(اتركه فارغاً = غير محدود)</span>
                    </label>
                    <input type="number" name="max_attempts" id="max_attempts"
                           value="{{ old('max_attempts', $quiz->max_attempts) }}"
                           min="1" max="99" placeholder="∞"
                           class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                </div>

                <div class="space-y-2 pt-1">
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}
                               class="w-4 h-4 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                        <span class="text-sm text-gray-300">{{ __('quiz.is_active') }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer">
                        <input type="checkbox" name="show_results" value="1" {{ $quiz->show_results ? 'checked' : '' }}
                               class="w-4 h-4 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                        <span class="text-sm text-gray-300">{{ __('quiz.show_results') }}</span>
                    </label>
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer">
                        <input type="checkbox" name="randomize_questions" value="1" {{ $quiz->randomize_questions ? 'checked' : '' }}
                               class="w-4 h-4 rounded bg-white/5 border-white/20 text-primary focus:ring-primary/50 focus:ring-offset-0">
                        <span class="text-sm text-gray-300">{{ __('quiz.randomize') }}</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-primary/20 hover:bg-primary/30 border border-primary/30 rounded-xl font-medium text-primary-light text-sm transition-all">
                    {{ __('quiz.save_settings') }}
                </button>
            </form>
        </div>
    </div>

    {{-- Right column: Questions --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Existing questions --}}
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white">{{ __('quiz.questions_header', ['count' => $quiz->questions->count()]) }}</h2>
            <span class="text-sm text-gray-500">{{ __('quiz.total_pts', ['points' => $quiz->questions->sum('points')]) }}</span>
        </div>

        @foreach($quiz->questions as $question)
            <div class="glass rounded-2xl p-5 group">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center justify-center w-7 h-7 bg-primary/20 text-primary-light rounded-lg text-xs font-bold">{{ $question->sort_order }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 bg-white/5 rounded-lg text-xs font-medium text-gray-400">
                            {{ __('quiz.type_' . $question->type) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $question->points }} {{ __('quiz.pts') }}</span>
                    </div>
                    <div class="flex items-center gap-1 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('admin.quizzes.questions.edit', [$quiz, $question]) }}" class="p-1.5 rounded-lg hover:bg-primary/10 text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('quiz.delete_question_confirm') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg hover:bg-danger/10 text-gray-500 hover:text-danger transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-white text-sm mb-2">{{ $question->question_text }}</p>

                @if($question->question_audio)
                    <div class="mt-2 mb-3">
                        <audio controls class="h-8 max-w-full">
                            <source src="{{ '/files/' . $question->question_audio }}">
                        </audio>
                    </div>
                @endif

                @if(in_array($question->type, ['mcq', 'image_choice']))
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($question->options as $option)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs {{ $option->is_correct ? 'bg-success/15 text-success border border-success/20' : 'bg-white/5 text-gray-400' }}">
                                @if($option->is_correct)
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @endif
                                @if($option->option_image)
                                    <img src="{{ '/files/' . $option->option_image }}" class="w-4 h-4 rounded object-cover">
                                @endif
                                {{ $option->label }}{{ $option->option_text ? ': '.$option->option_text : '' }}
                            </span>
                        @endforeach
                    </div>
                @elseif($question->type === 'drag_drop')
                    <div class="flex flex-col gap-2 mt-2">
                        @foreach($question->matchPairs as $pair)
                            <div class="flex items-center gap-3 px-3 py-2 bg-white/5 rounded-lg text-sm text-gray-300">
                                <span>{{ $pair->left_text }}</span>
                                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <span>{{ $pair->right_text }}</span>
                            </div>
                        @endforeach
                    </div>
                @elseif(in_array($question->type, ['fill_blank', 'true_false']))
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-success/10 rounded-lg text-xs text-success">
                            {{ __('quiz.correct_answer') }}: {{ $question->correct_answer }}
                        </span>
                    </div>
                @elseif($question->type === 'word_order')
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        @foreach(preg_split('/\s+/', trim($question->correct_answer ?? ''), -1, PREG_SPLIT_NO_EMPTY) as $w)
                            <span class="px-2.5 py-1 rounded-lg text-xs bg-primary/10 border border-primary/20 text-primary-light font-medium">{{ $w }}</span>
                        @endforeach
                    </div>
                @elseif($question->type === 'passage')
                    <div class="mt-2 space-y-1">
                        @foreach($question->passageSubQuestions as $sq)
                            <div class="flex items-start gap-2 px-3 py-1.5 bg-white/5 rounded-lg text-xs text-gray-400">
                                <span class="text-accent font-bold">{{ $loop->iteration }}.</span>
                                <span>{{ Str::limit($sq->sub_question_text, 60) }}</span>
                                <span class="ms-auto text-gray-500">{{ $sq->points }} {{ __('quiz.pts') }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Add question form --}}
        <div class="glass rounded-2xl p-6 border-2 border-dashed border-white/10 relative">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">{{ __('quiz.add_question') }}</h3>
                <button type="button" onclick="document.getElementById('ai-modal').classList.remove('hidden')" class="flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-400 hover:to-indigo-500 rounded-lg text-xs font-bold text-white shadow-lg shadow-purple-500/30 transition-all">
                    <span>🪄</span> {{ __('quiz.ai_generate') ?? 'AI Generate' }}
                </button>
            </div>

            <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}" enctype="multipart/form-data" id="add-question-form" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_type') }} *</label>
                        <select name="type" id="question-type" required onchange="toggleQuestionFields()"
                                class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all appearance-none cursor-pointer">
                            <option value="" class="bg-dark">{{ __('quiz.select_type') }}</option>
                            <option value="mcq" class="bg-dark" {{ old('type') == 'mcq' ? 'selected' : '' }}>{{ __('quiz.type_mcq') }}</option>
                            <option value="image_choice" class="bg-dark" {{ old('type') == 'image_choice' ? 'selected' : '' }}>{{ __('quiz.type_image_choice') }}</option>
                            <option value="fill_blank" class="bg-dark" {{ old('type') == 'fill_blank' ? 'selected' : '' }}>{{ __('quiz.type_fill_blank') }}</option>
                            <option value="drag_drop" class="bg-dark" {{ old('type') == 'drag_drop' ? 'selected' : '' }}>{{ __('quiz.type_drag_drop') }}</option>
                            <option value="true_false" class="bg-dark" {{ old('type') == 'true_false' ? 'selected' : '' }}>{{ __('quiz.type_true_false') }}</option>
                            <option value="passage" class="bg-dark" {{ old('type') == 'passage' ? 'selected' : '' }}>{{ __('quiz.type_passage') }}</option>
                            <option value="essay" class="bg-dark" {{ old('type') == 'essay' ? 'selected' : '' }}>{{ __('quiz.type_essay') }}</option>
                            <option value="word_order" class="bg-dark" {{ old('type') == 'word_order' ? 'selected' : '' }}>{{ __('quiz.type_word_order') }}</option>
                        </select>
                    </div>
                    <div id="points-wrapper">
                        <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.points') }} *</label>
                        <input type="number" name="points" id="question-points" value="{{ old('points', 2) }}" min="1"
                               class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_text') }}</label>
                    <textarea name="question_text" rows="2" dir="auto"
                              class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all resize-none"
                              placeholder="{{ __('quiz.question_text_placeholder') }}">{{ old('question_text') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_image') }}</label>
                    <input type="file" name="question_image" accept="image/*"
                           class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-primary/20 file:text-primary-light hover:file:bg-primary/30 file:cursor-pointer cursor-pointer">
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.question_audio') ?? 'Audio (optional)' }}</label>
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
                <div id="correct-answer-field" class="hidden">
                    <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.correct_answer') }} *</label>
                    <input type="text" name="correct_answer" value="{{ old('correct_answer') }}" dir="auto"
                           class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                           placeholder="{{ __('quiz.correct_answer_placeholder') }}">
                </div>

                {{-- MCQ Options --}}
                <div id="options-field" class="hidden space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-medium text-gray-400">{{ __('quiz.options') }}</label>
                        <button type="button" onclick="addOption()" class="text-xs text-primary-light hover:text-primary transition-colors">{{ __('quiz.add_option') }}</button>
                    </div>
                    <div id="options-container" class="space-y-2">
                        @for($i = 0; $i < 2; $i++)
                        <div class="flex flex-col gap-2 option-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
                            <div class="flex items-center gap-2">
                                <input type="text" name="options[{{ $i }}][label]" value="{{ chr(65 + $i) }}" class="w-12 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-primary/50">
                                <input type="text" name="options[{{ $i }}][option_text]" placeholder="{{ __('quiz.option_text_placeholder') }}" dir="auto" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                                <label class="flex items-center gap-1 text-xs text-gray-400 whitespace-nowrap cursor-pointer">
                                    <input type="checkbox" name="options[{{ $i }}][is_correct]" class="w-4 h-4 rounded bg-white/5 border-white/20 text-success focus:ring-success/50 focus:ring-offset-0">
                                    {{ __('quiz.correct') }}
                                </label>
                            </div>
                            <input type="file" name="options[{{ $i }}][option_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20 mt-1">
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- Drag & Drop Pairs --}}
                <div id="pairs-field" class="hidden space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-medium text-gray-400">{{ __('quiz.match_pairs') }}</label>
                        <button type="button" onclick="addPair()" class="text-xs text-primary-light hover:text-primary transition-colors">{{ __('quiz.add_pair') }}</button>
                    </div>
                    <div id="pairs-container" class="space-y-2">
                        @for($i = 0; $i < 2; $i++)
                        <div class="flex flex-col gap-2 pair-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
                            <div class="flex items-center gap-2">
                                <input type="text" name="pairs[{{ $i }}][left_text]" placeholder="{{ __('quiz.left_item') }}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                <input type="text" name="pairs[{{ $i }}][right_text]" placeholder="{{ __('quiz.right_item') }}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                            </div>
                            <div class="flex items-center gap-2 mr-6 rtl:ml-6 rtl:mr-0">
                                <div class="flex-1"><input type="file" name="pairs[{{ $i }}][left_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20"></div>
                                <div class="flex-1"><input type="file" name="pairs[{{ $i }}][right_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20"></div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- Passage: sub-questions --}}
                <div id="passage-field" class="hidden space-y-3">
                    <div class="rounded-xl bg-accent/10 border border-accent/20 p-3 text-xs text-accent">
                        {{ __('quiz.passage_hint') }}
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-medium text-gray-400">{{ __('quiz.sub_questions') }}</label>
                        <button type="button" onclick="addSubQuestion()" class="text-xs text-accent hover:text-accent/80 transition-colors">{{ __('quiz.add_sub_question') }}</button>
                    </div>
                    <div id="sub-questions-container" class="space-y-4"></div>
                </div>

                {{-- True/False selector --}}
                <div id="truefalse-field" class="hidden">
                    <label class="block text-xs font-medium text-gray-400 mb-2">{{ __('quiz.correct_answer') }} *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="option-card flex items-center justify-center py-3 cursor-pointer has-[:checked]:bg-success/15 has-[:checked]:border-success/40 text-center">
                            <input type="radio" name="correct_answer" value="true" class="sr-only">
                            <span class="text-sm font-medium text-gray-300">{{ __('quiz.true') }}</span>
                        </label>
                        <label class="option-card flex items-center justify-center py-3 cursor-pointer has-[:checked]:bg-danger/15 has-[:checked]:border-danger/40 text-center">
                            <input type="radio" name="correct_answer" value="false" class="sr-only">
                            <span class="text-sm font-medium text-gray-300">{{ __('quiz.false') }}</span>
                        </label>
                    </div>
                </div>

                {{-- Word Order field --}}
                <div id="word-order-field" class="hidden space-y-3">
                    <div class="rounded-xl bg-primary/10 border border-primary/20 p-3 text-xs text-primary-light flex items-start gap-2">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('quiz.word_order_hint') }}
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">{{ __('quiz.word_order_sentence') }} *</label>
                        <input type="text" name="correct_answer" id="word-order-sentence"
                               class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all"
                               placeholder="{{ __('quiz.word_order_sentence_placeholder') }}">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-success to-emerald-600 hover:from-emerald-500 hover:to-success rounded-xl font-medium text-white text-sm shadow-lg shadow-success/25 hover:shadow-success/40 transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    {{ __('quiz.add_question_btn') }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-6 {{ app()->getLocale() === "ar" ? "left-6" : "right-6" }} z-50 glass-strong rounded-xl px-6 py-3 text-sm font-medium text-success animate-slide-up';
        toast.textContent = '{{ __("quiz.link_copied") }}';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}

function toggleQuestionFields() {
    const type = document.getElementById('question-type').value;
    const correctField   = document.getElementById('correct-answer-field');
    const optionsField   = document.getElementById('options-field');
    const pairsField     = document.getElementById('pairs-field');
    const trueFalseField = document.getElementById('truefalse-field');
    const passageField   = document.getElementById('passage-field');
    const wordOrderField = document.getElementById('word-order-field');
    const pointsWrapper  = document.getElementById('points-wrapper');
    const pointsInput    = document.getElementById('question-points');

    correctField.classList.add('hidden');
    optionsField.classList.add('hidden');
    pairsField.classList.add('hidden');
    trueFalseField.classList.add('hidden');
    passageField.classList.add('hidden');
    wordOrderField.classList.add('hidden');
    pointsWrapper.classList.remove('hidden');
    pointsInput.required = true;

    // Disable all correct_answer inputs so they don't submit and overwrite each other
    document.querySelectorAll('[name="correct_answer"]').forEach(el => el.disabled = true);

    if (type === 'mcq') {
        optionsField.classList.remove('hidden');
    } else if (type === 'image_choice') {
        optionsField.classList.remove('hidden'); // Uses the same options field container but frontend takes care of image input
    } else if (type === 'fill_blank') {
        correctField.classList.remove('hidden');
        correctField.querySelectorAll('[name="correct_answer"]').forEach(el => el.disabled = false);
    } else if (type === 'true_false') {
        trueFalseField.classList.remove('hidden');
        trueFalseField.querySelectorAll('[name="correct_answer"]').forEach(el => el.disabled = false);
    } else if (type === 'drag_drop') {
        pairsField.classList.remove('hidden');
    } else if (type === 'passage') {
        passageField.classList.remove('hidden');
        pointsWrapper.classList.add('hidden');   // auto-computed from sub-questions
        pointsInput.required = false;
        pointsInput.value = '';
        // initialise with one sub-question if empty
        if (document.getElementById('sub-questions-container').children.length === 0) {
            addSubQuestion();
        }
    } else if (type === 'essay') {
        // Essay only needs question text and points.
    } else if (type === 'word_order') {
        wordOrderField.classList.remove('hidden');
        wordOrderField.querySelectorAll('[name="correct_answer"]').forEach(el => el.disabled = false);
    }
}

let optionCount = 2;
function addOption() {
    const container = document.getElementById('options-container');
    const label = String.fromCharCode(65 + optionCount);
    const correctText   = @json(__('quiz.correct'));
    const optPlaceholder = @json(__('quiz.option_text_placeholder'));
    const html = `
        <div class="flex flex-col gap-2 option-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
            <div class="flex items-center gap-2">
                <input type="text" name="options[${optionCount}][label]" value="${label}" class="w-12 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none focus:ring-1 focus:ring-primary/50">
                <input type="text" name="options[${optionCount}][option_text]" placeholder="${optPlaceholder}" dir="auto" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                <label class="flex items-center gap-1 text-xs text-gray-400 whitespace-nowrap cursor-pointer">
                    <input type="checkbox" name="options[${optionCount}][is_correct]" class="w-4 h-4 rounded bg-white/5 border-white/20 text-success focus:ring-success/50 focus:ring-offset-0">
                    ${correctText}
                </label>
                <button type="button" onclick="this.closest('.option-row').remove()" class="p-1 text-gray-500 hover:text-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <input type="file" name="options[${optionCount}][option_image]" accept="image/*" class="w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:bg-white/10 file:text-white hover:file:bg-white/20 mt-1">
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
    optionCount++;
}

let pairCount = 2;
function addPair() {
    const container = document.getElementById('pairs-container');
    const leftPh  = @json(__('quiz.left_item'));
    const rightPh = @json(__('quiz.right_item'));
    const html = `
        <div class="flex flex-col gap-2 pair-row bg-white/[0.02] p-3 rounded-lg border border-white/5">
            <div class="flex items-center gap-2">
                <input type="text" name="pairs[${pairCount}][left_text]" placeholder="${leftPh}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                <input type="text" name="pairs[${pairCount}][right_text]" placeholder="${rightPh}" class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-1 focus:ring-primary/50">
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

// ──────────────────────────────────────────
// Passage / Sub-questions
// ──────────────────────────────────────────
let subQCount = 0;
const sqTypes    = @json(['mcq' => __('quiz.type_mcq'), 'fill_blank' => __('quiz.type_fill_blank'), 'true_false' => __('quiz.type_true_false')]);
const sqCorrect   = @json(__('quiz.correct'));
const sqOptPh     = @json(__('quiz.option_text_placeholder'));
const sqTextPh    = @json(__('quiz.sub_question_text_placeholder'));
const sqAnswerPh  = @json(__('quiz.correct_answer_placeholder'));
const sqPtsLabel  = @json(__('quiz.points'));
const sqTrueLbl   = @json(__('quiz.true'));
const sqFalseLbl  = @json(__('quiz.false'));
const sqAddOpt    = @json(__('quiz.add_option'));
const sqSubQLabel = @json(__('quiz.sub_question'));
const sqQTextLbl  = @json(__('quiz.question_text'));
const sqQTypeLbl  = @json(__('quiz.question_type'));
const sqCorAnsLbl = @json(__('quiz.correct_answer'));
const sqOptionsLbl= @json(__('quiz.options'));

function buildTypeOptions(selectedType, idx) {
    return Object.entries(sqTypes).map(([val, lbl]) =>
        `<option value="${val}" ${val === selectedType ? 'selected' : ''} class="bg-dark">${lbl}</option>`
    ).join('');
}

function addSubQuestion(defaultType = 'mcq') {
    const container = document.getElementById('sub-questions-container');
    const idx = subQCount++;
    const html = `
    <div class="sub-q-card bg-white/[0.03] border border-white/10 rounded-xl p-5 space-y-4" data-sq-idx="${idx}">
        <div class="flex items-center justify-between pb-2 border-b border-white/10">
            <span class="text-sm font-bold text-accent">${sqSubQLabel} ${idx + 1}</span>
            <button type="button" onclick="this.closest('.sub-q-card').remove()" class="p-1 px-2 text-xs bg-danger/10 text-danger hover:bg-danger hover:text-white rounded transition-colors">
                حذف
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">${sqQTypeLbl} *</label>
                <select name="sub_questions[${idx}][type]" onchange="toggleSubQFields(this, ${idx})"
                        class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-1 focus:ring-accent/50 appearance-none cursor-pointer">
                    ${buildTypeOptions(defaultType, idx)}
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1">${sqPtsLabel} *</label>
                <input type="number" name="sub_questions[${idx}][points]" value="1" min="1" required
                       class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-1 focus:ring-accent/50">
            </div>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1">${sqQTextLbl} *</label>
            <textarea name="sub_questions[${idx}][sub_question_text]" rows="2" required
                      placeholder="${sqTextPh}"
                      class="w-full px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-1 focus:ring-accent/50 resize-none"></textarea>
        </div>
        
        <div class="sub-q-answer pt-2" data-sq="${idx}">
            ${buildSubQAnswer(idx, defaultType)}
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function buildSubQAnswer(idx, type) {
    if (type === 'mcq') {
        return `<div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">${sqOptionsLbl}</span>
                <button type="button" onclick="addSubQOption(${idx})" class="text-xs text-accent hover:opacity-80">${sqAddOpt}</button>
            </div>
            <div id="sub-q-opts-${idx}" class="space-y-2">
                ${[0,1,2,3].map(j => `
                <div class="flex items-center gap-2 sub-q-opt-row">
                    <input type="text" name="sub_questions[${idx}][options][${j}][label]" value="${String.fromCharCode(65+j)}"
                           class="w-10 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none">
                    <input type="text" name="sub_questions[${idx}][options][${j}][option_text]" placeholder="${sqOptPh}"
                           class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none">
                    <label class="flex items-center gap-1.5 text-xs text-gray-400 whitespace-nowrap cursor-pointer px-1">
                        <input type="checkbox" name="sub_questions[${idx}][options][${j}][is_correct]"
                               class="w-4 h-4 rounded bg-white/5 border-white/20 text-success">
                        ${sqCorrect}
                    </label>
                </div>`).join('')}
            </div>
        </div>`;
    } else if (type === 'fill_blank') {
        return `<div>
            <label class="block text-xs font-medium text-gray-400 mb-1">${sqCorAnsLbl} *</label>
            <input type="text" name="sub_questions[${idx}][correct_answer]" placeholder="${sqAnswerPh}"
                   class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-1 focus:ring-accent/50">
        </div>`;
    } else if (type === 'true_false') {
        return `<div>
            <label class="block text-xs font-medium text-gray-400 mb-2">${sqCorAnsLbl} *</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center justify-center py-2.5 border border-white/10 rounded-xl text-sm text-gray-300 cursor-pointer has-[:checked]:bg-success/15 has-[:checked]:border-success/40 transition-colors">
                    <input type="radio" name="sub_questions[${idx}][correct_answer]" value="true" class="sr-only"> ${sqTrueLbl}
                </label>
                <label class="flex items-center justify-center py-2.5 border border-white/10 rounded-xl text-sm text-gray-300 cursor-pointer has-[:checked]:bg-danger/15 has-[:checked]:border-danger/40 transition-colors">
                    <input type="radio" name="sub_questions[${idx}][correct_answer]" value="false" class="sr-only"> ${sqFalseLbl}
                </label>
            </div>
        </div>`;
    }
    return '';
}

let subQOptCounts = {};
function addSubQOption(idx) {
    if (!subQOptCounts[idx]) subQOptCounts[idx] = 4;
    const j = subQOptCounts[idx]++;
    const container = document.getElementById(`sub-q-opts-${idx}`);
    const html = `
    <div class="flex items-center gap-2 sub-q-opt-row">
        <input type="text" name="sub_questions[${idx}][options][${j}][label]" value="${String.fromCharCode(65+j)}"
               class="w-10 px-2 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm text-center focus:outline-none">
        <input type="text" name="sub_questions[${idx}][options][${j}][option_text]" placeholder="${sqOptPh}"
               class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none">
        <label class="flex items-center gap-1.5 text-xs text-gray-400 whitespace-nowrap cursor-pointer px-1">
            <input type="checkbox" name="sub_questions[${idx}][options][${j}][is_correct]"
                   class="w-4 h-4 rounded bg-white/5 border-white/20 text-success">
            ${sqCorrect}
        </label>
        <button type="button" onclick="this.closest('.sub-q-opt-row').remove()" class="p-1 text-gray-500 hover:text-danger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function toggleSubQFields(select, idx) {
    const type = select.value;
    const answerDiv = document.querySelector(`.sub-q-answer[data-sq="${idx}"]`);
    answerDiv.innerHTML = buildSubQAnswer(idx, type);
}

document.addEventListener('DOMContentLoaded', toggleQuestionFields);

function showAILoading() {
    document.getElementById('ai-submit-container').classList.add('hidden');
    document.getElementById('ai-loading-container').classList.remove('hidden');
}
</script>

{{-- AI Generator Modal --}}
<div id="ai-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('ai-modal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="glass-strong rounded-2xl p-6 border border-white/10 shadow-2xl relative">
            
            {{-- Close button --}}
            <button type="button" onclick="document.getElementById('ai-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <h3 class="text-xl font-bold bg-gradient-to-r from-purple-400 to-indigo-400 bg-clip-text text-transparent mb-1">
                🪄 {{ __('quiz.ai_generate') ?? 'Generate AI Questions' }}
            </h3>
            <p class="text-xs text-gray-400 mb-6">{{ __('quiz.ai_generate_subtitle') ?? 'Let OpenAI write the questions for you automatically.' }}</p>

            <form method="POST" action="{{ route('admin.quizzes.ai.generate', $quiz) }}" id="ai-form" onsubmit="showAILoading()">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-1">{{ __('quiz.ai_topic') ?? 'Topic / Subject' }} *</label>
                        <input type="text" name="topic" required placeholder="{{ __('quiz.ai_topic_placeholder') ?? 'e.g. Solar System History' }}"
                               class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-1">{{ __('quiz.ai_count') ?? 'Number of Questions (Max 10)' }} *</label>
                        <input type="number" name="count" min="1" max="10" value="5" required
                               class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/50">
                    </div>
                </div>

                <div id="ai-submit-container" class="mt-6">
                    <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-400 hover:to-indigo-500 rounded-xl text-sm font-bold text-white shadow-lg shadow-purple-500/25 transition-all">
                        {{ __('quiz.ai_generate_btn') ?? 'Generate Now' }}
                    </button>
                </div>

                <div id="ai-loading-container" class="mt-6 hidden text-center py-2">
                    <svg class="animate-spin h-6 w-6 text-purple-400 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-xs text-purple-300 font-medium animate-pulse">{{ __('quiz.ai_loading') ?? 'AI is thinking... this might take 10 seconds.' }}</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
                        <button type="button" class="absolute -top-1.5 -right-1.5 bg-danger text-white rounded-full p-0.5 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-all transform scale-90 hover:scale-110 shadow-md" onclick="removeImagePreview(this)">
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

// Audio Recording & Preview Logic
document.addEventListener('change', function(e) {
    if (e.target.matches('input[type="file"][accept="audio/*"]')) {
        const file = e.target.files[0];
        const input = e.target;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                let previewContainer = input.parentElement.querySelector('.live-audio-preview');
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'live-audio-preview mb-2 mt-2 inline-flex flex-col sm:flex-row items-center gap-2 w-full';
                    input.parentElement.insertBefore(previewContainer, input);
                }
                previewContainer.innerHTML = `
                    <div class="relative group flex-1 items-center bg-white/5 rounded-xl p-2 border border-white/10 flex gap-2">
                        <audio controls class="h-8 flex-1 outline-none custom-audio min-w-[200px]" src="${evt.target.result}"></audio>
                        <button type="button" class="px-2 py-1 bg-danger/10 text-danger hover:bg-danger hover:text-white rounded text-xs transition-colors shrink-0" onclick="removeAudioPreview(this)">حذف المقطع</button>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    }
});

window.removeAudioPreview = function(btn) {
    const container = btn.closest('.live-audio-preview');
    const input = container.parentElement.querySelector('input[type="file"]');
    if (input) input.value = '';
    container.remove();
}

let mediaRecorder = null;
let audioChunks = [];
let recordTimer = null;
let recordSeconds = 0;

document.addEventListener('click', async function(e) {
    if (e.target.closest('.start-record-btn')) {
        const btn = e.target.closest('.start-record-btn');
        const container = btn.parentElement;
        const recordingUi = container.querySelector('.recording-ui');
        const timeDisplay = container.querySelector('.record-time');
        const fileInput = container.closest('.space-y-2').querySelector('input[type="file"][accept="audio/*"]');

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];
            
            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                const file = new File([audioBlob], "recorded_audio.webm", { type: 'audio/webm' });
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                
                if (fileInput) {
                    fileInput.files = dataTransfer.files;
                    fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                }

                stream.getTracks().forEach(track => track.stop());
                
                recordingUi.classList.add('hidden');
                btn.classList.remove('hidden');
                clearInterval(recordTimer);
            };

            mediaRecorder.start();
            btn.classList.add('hidden');
            recordingUi.classList.remove('hidden');
            
            recordSeconds = 0;
            timeDisplay.textContent = '00:00';
            recordTimer = setInterval(() => {
                recordSeconds++;
                const mins = String(Math.floor(recordSeconds / 60)).padStart(2, '0');
                const secs = String(recordSeconds % 60).padStart(2, '0');
                timeDisplay.textContent = `${mins}:${secs}`;
            }, 1000);

        } catch (err) {
            alert('لم نتمكن من الوصول للميكروفون، يرجى منح الصلاحية من متصفحك.');
            console.error('Mic error:', err);
        }
    }

    if (e.target.closest('.stop-record-btn')) {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
    }
});
</script>
@endsection

