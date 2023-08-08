<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'cleared',
    ];

    public function games(){
        return $this->belongsToMany(Game::class, 'game_message_log');
    }

    public function actions(){
        return $this->belongsToMany(Action::class, 'message_log_actions');
    }
}
