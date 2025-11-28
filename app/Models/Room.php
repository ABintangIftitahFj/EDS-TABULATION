<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'name', 'location', 'is_active', 'capacity'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function matches()
    {
        return $this->hasMany('App\\Models\\DebateMatch');
    }
}
