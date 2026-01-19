<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'event_date', 'image_path', 'is_active'];

    protected $casts = [
        'event_date' => 'datetime',
        'is_active' => 'boolean',
    ];
}
