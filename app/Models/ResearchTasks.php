<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchTasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'task',
        'completed',
        'automation',
        'cost',
        'mw',
    ];

    public function games(){
        return $this->belongsToMany(Game::class, 'game_research_tasks');
    }
}
