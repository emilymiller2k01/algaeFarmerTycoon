<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'perc',
    ];

    public function message_logs(){
        return $this->belongsToMany(MessageLog::class, 'message_log_actions');
    }
}
