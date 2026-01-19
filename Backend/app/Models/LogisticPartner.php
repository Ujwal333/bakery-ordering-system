<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticPartner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_person', 'phone', 'is_active'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
