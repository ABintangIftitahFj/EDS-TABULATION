<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ballot extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id', 'adjudicator_id', 'speaker_id', 'score', 'team_role', 'position', 'is_reply', 'feedback', 'is_consensus'
    ];

    protected $casts = [
        'is_reply' => 'boolean',
        'is_consensus' => 'boolean',
    ];

    public function match()
    {
        return $this->belongsTo('App\\Models\\DebateMatch');
    }

    public function adjudicator()
    {
        return $this->belongsTo(Adjudicator::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }
}
