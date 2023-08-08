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


class AlgaeViewController extends Controller
{
    //TODO render the correct react view to the main view

    function index($farm_id)
    {

        try {
            $farm = Farm::findOrFail($farm_id);
            $research = ResearchTasks::all();
            $achievements = Achievement::all();
            $settings = Settings::all();

            $farmData = [
                'farm_id' => $farm->id,
                'tanks' => $farm->tanks()->get(), // Get related tanks
                'refineries' => $farm->refineries()->get(), // Get related refineries
                'lights' => $farm->lights()->get(), // Get related lights
                'powers' => $farm->powers()->get(), // Get related powers
            ];

            $completedAutomationResearch = ResearchTasks::where('automation', true)
                ->where('completed', true)
                ->get();

            dd([
                'farm' => $farmData,
                'research' => $research,
                'completedAutomationResearch' => $completedAutomationResearch,
                'achievements' => $achievements,
                'settings' => $settings,
            ]);

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

}
