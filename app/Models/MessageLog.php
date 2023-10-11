<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'message',
        'action',
        'cleared',
    ];

    protected $table = 'message_log';

    public function games(){
        return $this->belongsTo(Game::class);
    }
}
