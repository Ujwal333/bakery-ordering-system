<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'full_name', 'email', 'phone', 
        'resume_path', 'message', 'status'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
