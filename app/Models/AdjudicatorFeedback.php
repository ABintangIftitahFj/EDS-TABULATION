<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjudicatorFeedback extends Model
{
    use HasFactory;

    protected $table = 'adjudicator_feedback';

    protected $fillable = [
        'adjudicator_id', 'user_id', 'match_id', 'rating', 'comment'
    ];

    public function adjudicator()
    {
        return $this->belongsTo(Adjudicator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function match()
    {
        return $this->belongsTo('App\\Models\\DebateMatch');
    }
}
