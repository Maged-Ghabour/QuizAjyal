<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PassageSubQuestion extends Model
{
    protected $fillable = [
        'question_id',
        'sub_question_text',
        'type',
        'correct_answer',
        'points',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'points'     => 'integer',
            'sort_order' => 'integer',
            'is_correct' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(PassageSubQuestionOption::class, 'sub_question_id')->orderBy('sort_order');
    }
}
