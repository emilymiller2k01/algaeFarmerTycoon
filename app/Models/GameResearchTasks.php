<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResearchTasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'research_task_id',
    ];
}
