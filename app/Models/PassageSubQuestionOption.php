<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PassageSubQuestionOption extends Model
{
    protected $fillable = [
        'sub_question_id',
        'label',
        'option_text',
        'is_correct',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function subQuestion(): BelongsTo
    {
        return $this->belongsTo(PassageSubQuestion::class, 'sub_question_id');
    }
}
