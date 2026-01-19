<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'activity_logs';
        protected $fillable = ['user_id', 'action', 'module', 'model', 'model_id', 'description', 'ip_address', 'user_agent'];
        protected $dates = ['created_at', 'updated_at', 'deleted_at'];
        
        public function user() {
        return $this->belongsTo(User::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
