<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'city', 'postal_code', 
        'status', 'role_id', 'profile_image', 'role', 'google_id', 'avatar', 'email_verified_at',
        'otp_code', 'otp_expires_at'
    ];
    
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime'
    ];
        
    public function orders() {
        return $this->hasMany(Order::class);
    }
    
    public function customCakes() {
        return $this->hasMany(CustomCake::class);
    }
    
    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function roleRelation() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        if ($this->roleRelation) {
            return $this->roleRelation->slug === $role;
        }
        return $this->role === $role;
    }

    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
