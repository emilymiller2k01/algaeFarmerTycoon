<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchTasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'title',
        'task',
        'completed',
        'automation',
        'cost',
        'mw',
    ];

    public function games(){
        return $this->belongsTo(Game::class);
    }
}
