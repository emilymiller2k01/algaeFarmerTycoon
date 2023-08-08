<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public function showCompletedAutomationTasks()
    {
        // Fetch tasks that are completed and automated
        $completedAutomationTasks = ResearchTasks::where([
            ['completed', true],
            ['automation', true]
        ])->get();

        return view('research-tasks.automation', ['tasks' => $completedAutomationTasks]);
    }

}
