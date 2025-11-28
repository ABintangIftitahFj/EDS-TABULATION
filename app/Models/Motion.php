<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{
    use HasFactory;

    protected $fillable = [
        'round_id',
        'title',
        'detail',
        'category',
        'info_slide',
        'image',
        'is_released',
        'released_at',
    ];

    protected $casts = [
        'is_released' => 'boolean',
        'released_at' => 'datetime',
    ];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}
