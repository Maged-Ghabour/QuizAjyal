<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    public const TYPE_MCQ = 'mcq';

    public const TYPE_FILL_BLANK = 'fill_blank';

    public const TYPE_DRAG_DROP = 'drag_drop';

    public const TYPE_TRUE_FALSE = 'true_false';

    public const TYPE_PASSAGE = 'passage';

    public const TYPES = [
        self::TYPE_MCQ        => 'Multiple Choice',
        self::TYPE_FILL_BLANK => 'Fill in the Blank',
        self::TYPE_DRAG_DROP  => 'Drag & Drop',
        self::TYPE_TRUE_FALSE => 'True / False',
        self::TYPE_PASSAGE    => 'Passage',
    ];

    protected $fillable = [
        'quiz_id',
        'type',
        'question_text',
        'question_image',
        'question_audio',
        'correct_answer',
        'points',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('sort_order');
    }

    public function matchPairs(): HasMany
    {
        return $this->hasMany(QuestionMatchPair::class)->orderBy('sort_order');
    }

    public function passageSubQuestions(): HasMany
    {
        return $this->hasMany(PassageSubQuestion::class)->orderBy('sort_order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
