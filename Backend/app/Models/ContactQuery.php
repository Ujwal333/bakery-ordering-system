<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactQuery extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'contact_queries';
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'admin_note'];
}
