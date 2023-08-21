<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Game;
use App\Models\Refinery;
use App\Models\ResearchTasks;
use App\Models\Settings;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Farm;
use App\Models\Tank;
use Inertia\Inertia;


class AlgaeViewController extends Controller
{
    function index($farm_id)
    {
        try {
            $farm = Farm::findOrFail($farm_id);
            $research = ResearchTasks::all();
            $achievements = Achievement::all();
            $settings = Settings::all();

            $farmData = [
                'farm_id' => $farm->id,
                'tanks' => $farm->tanks()->get(),
                'refineries' => $farm->refineries()->get(),
                'lights' => $farm->lights()->get(),
                'powers' => $farm->powers()->get(),
            ];

            $completedAutomationResearch = ResearchTasks::where('automation', true)
                ->where('completed', true)
                ->get();

            // Render the appropriate React component with data
            return Inertia::render('MultiSection', [
                'farm' => $farmData,
                'research' => $research,
                'completedAutomationResearch' => $completedAutomationResearch,
                'achievements' => $achievements,
                'settings' => $settings,
            ]);

        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', ['message' => 'Farm Not Found'])->setStatusCode(404);
        } catch (Exception $e) {
            return Inertia::render('Error', ['message' => 'Internal Server Error'])->setStatusCode(500);
        }
    }
}
