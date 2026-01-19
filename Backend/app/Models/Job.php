<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'type', 'department', 'location', 
        'description', 'requirements', 'salary_range', 
        'is_active', 'deadline'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
