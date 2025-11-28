<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjudicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'user_id', 'name', 'institution', 'is_available', 'level', 'rating'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }
}
