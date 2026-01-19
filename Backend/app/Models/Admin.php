<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    
    protected $fillable = ['name', 'email', 'username', 'password', 'role', 'status'];
        protected $hidden = ['password'];
        
        public function roleRelation() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
