<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function getCached()
    {
        return \Illuminate\Support\Facades\Cache::remember('site_settings', 60*24, function() {
            return self::pluck('value', 'key');
        });
    }
}
