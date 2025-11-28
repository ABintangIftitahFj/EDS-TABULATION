<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdjudicatorReview extends Model
{
    protected $fillable = [
        'match_id',
        'adjudicator_id',
        'score_team_a',
        'score_team_b',
        'comment',
    ];

    protected $casts = [
        'score_team_a' => 'decimal:2',
        'score_team_b' => 'decimal:2',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(DebateMatch::class, 'match_id');
    }

    public function adjudicator(): BelongsTo
    {
        return $this->belongsTo(Adjudicator::class);
    }
}
