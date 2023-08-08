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
    //

    function index($farm_id){

        try{
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

            $refineries = $farmData['refineries'];

            dd([
                'farm' => $farmData,
                'research' => $research,
                'completedAutomationResearch' => $completedAutomationResearch,
                'achievements' => $achievements,
                'settings' => $settings,
            ]);

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }


    public function updateRefineryProduct(Request $request, $refinery_id, $farm_id, $game_id) {
        try {
            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $refinery = $farm->refineries()->where('id', $refinery_id)->first();

            $product = $request->input('produce');
            $refinery->produce = $product;
            $refinery->save();

            return response()->json(['message' => 'Refinery updated successfully']);
        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function increaseMW($game_id) {
        try {
            $game = Game::findOrFail($game_id);

            $cost = $game->mw_cost;
            if ($game->money < $cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient funds'
                ]);
            }

            $game->money -= $cost;
            $game->mw += 1;  // You can change this value to adjust how much mw increases by
            $game->save();

            return response()->json([
                'success' => true,
                'game mw' => $game->mw,
                'message' => 'MW increased successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function decreaseMW($game_id) {
        try {
            $game = Game::findOrFail($game_id);

            $game->mw -= 1;  // You can adjust this value as well
            $game->money += $game->mw_cost; // Refund the cost (or a fraction if you wish)
            $game->save();

            return response()->json([
                'success' => true,
                'game mw' => $game->mw,
                'message' => 'MW decreased successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

//    type = {
//    farm: Farm[],
//    research: Research[],
//    Achi: Achi[],
//    settings : settings[],
//    }
//
//    Farm = {
//        Tanks
//        Power
//        Light
//        Refin
//    }
}
