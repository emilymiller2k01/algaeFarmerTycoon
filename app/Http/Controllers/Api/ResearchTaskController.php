<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;

class ResearchTaskController extends Controller
{
    public function showCompletedTasks()
    {
        $completedTasks = ResearchTasks::where('completed', true)->get();

        return view('research-tasks.index', ['tasks' => $completedTasks]);
    }

    public function completeTask(Request $request, $taskId)
    {
        $task = ResearchTasks::findOrFail($taskId);

        $task->completed = true;
        $task->save();

        return redirect()->route('research-tasks.completed');
    }
}
