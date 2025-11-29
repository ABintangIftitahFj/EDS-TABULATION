<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'file_name',
        'entity_type',
        'line_number',
        'raw_row',
        'status',
        'message',
    ];

    protected $casts = [
        'raw_row' => 'array',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeError($query)
    {
        return $query->where('status', 'error');
    }

    public function scopeForEntity($query, $entityType)
    {
        return $query->where('entity_type', $entityType);
    }
}