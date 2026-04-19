<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'slug',
        'cover_image',
        'duration_minutes',
        'is_active',
        'show_results',
        'randomize_questions',
        'pass_percentage',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_results' => 'boolean',
            'randomize_questions' => 'boolean',
            'duration_minutes' => 'integer',
            'pass_percentage' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Quiz $quiz): void {
            if (empty($quiz->slug)) {
                $quiz->slug = Str::slug($quiz->title).'-'.Str::random(5);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<self> $query
     * @return \Illuminate\Database\Eloquent\Builder<self>
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getShareUrlAttribute(): string
    {
        return route('quiz.show', $this->slug);
    }

    public function getTotalPointsAttribute(): int
    {
        return $this->questions()->sum('points');
    }
}
