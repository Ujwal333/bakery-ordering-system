<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CakeOption extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'name', 'price', 'stock', 'image_path', 'is_active'];
}
