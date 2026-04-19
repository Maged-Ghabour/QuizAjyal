<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AiQuestionController extends Controller
{
    /**
     * Generate questions via OpenAI API and store them in the quiz.
     */
    public function generate(Request $request, Quiz $quiz): RedirectResponse
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'count' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            return back()->with('error', 'مفتاح Gemini API غير موجود في ملف .env. يرجى إضافة مفتاح GEMINI_API_KEY أولاً.');
        }

        $systemPrompt = "You are an expert E-learning Quiz Generator. Generate exactly {$request->count} multiple-choice questions in Arabic about the topic: '{$request->topic}'. 
        You MUST respond ONLY with a valid JSON array. Each object in the array must strictly match this format:
        [
            {
                \"question_text\": \"Question string here?\",
                \"options\": [
                    {\"text\": \"Option A\", \"is_correct\": false},
                    {\"text\": \"Option B\", \"is_correct\": true},
                    {\"text\": \"Option C\", \"is_correct\": false},
                    {\"text\": \"Option D\", \"is_correct\": false}
                ]
            }
        ]
        Ensure exactly 4 options per question, with exactly ONE option being correct. Return ONLY the raw JSON array without any markdown formatting, backticks, or extra text.";

        try {
            $response = Http::timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                    ]
                ]);

            if ($response->failed()) {
                Log::error('Gemini Error: ' . $response->body());
                return back()->with('error', __('quiz.ai_error') ?? 'Failed to connect to Google Gemini. Please try again.');
            }

            $content = trim($response->json('candidates.0.content.parts.0.text'));
            // Remove potential markdown code blocks if the AI includes them despite instructions
            $content = preg_replace('/```(?:json)?\s*(.*?)\s*```/s', '$1', $content);

            $questionsData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($questionsData)) {
                Log::error('Parse Error: Invalid JSON received -> ' . $content);
                return back()->with('error', __('quiz.ai_parse_error') ?? 'Received invalid format from AI. Please try again.');
            }

            // Begin transaction to ensure data integrity
            \DB::transaction(function () use ($quiz, $questionsData) {
                $maxSortOrder = $quiz->questions()->max('sort_order') ?? 0;

                foreach ($questionsData as $qData) {
                    $maxSortOrder++;
                    
                    $question = $quiz->questions()->create([
                        'type' => 'mcq',
                        'question_text' => $qData['question_text'],
                        'points' => 2,
                        'sort_order' => $maxSortOrder,
                    ]);

                    if (isset($qData['options']) && is_array($qData['options'])) {
                        foreach ($qData['options'] as $index => $opt) {
                            $question->options()->create([
                                'label' => chr(65 + $index), // A, B, C, D
                                'option_text' => $opt['text'],
                                'is_correct' => $opt['is_correct'] ?? false,
                                'sort_order' => $index,
                            ]);
                        }
                    }
                }
            });

            return back()->with('success', __('quiz.ai_success') ?? 'Questions generated and added successfully!');

        } catch (\Exception $e) {
            Log::error('AI Generation Exception: ' . $e->getMessage());
            return back()->with('error', __('quiz.ai_error') ?? 'An error occurred during generation.');
        }
    }
}
