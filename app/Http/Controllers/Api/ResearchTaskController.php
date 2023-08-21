<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;

class ResearchTaskController extends Controller
{
    public function showCompletedTasks($gameId)
    {
        $completedTasks = ResearchTasks::where('game_id', $gameId)
            ->where('completed', true)
            ->get();
        return response()->json($completedTasks);
    }

    public function showCompletedAutomationTasks($gameId)
    {
        // Fetch tasks that are completed and automated
        $completedAutomationTasks = ResearchTasks::where('game_id', $gameId)
            ->where('completed', true)
            ->where('automation', true)
            ->get();
        return response()->json($completedAutomationTasks);
    }



}
