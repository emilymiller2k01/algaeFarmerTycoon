<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Game;
use App\Models\Light;
use App\Models\Tank;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Production extends Controller
{
    //

    public function index($game_id){


        try {
            $game = Game::findOrFail($game_id);

            //TODO make sure this dynamically shows on the window
            $currentMoney = $game->money;

            //TODO make sure this dynamically shows on the production window
            $farms = $game->farms()->withCount('tanks')->get();

            //TODO make sure this dynamically shows on the window
            $farmData = $farms->map(function ($farm) {
                return [
                    'lux' => $farm->lux,
                    'temperature' => $farm->temperature,
                    'mw' => $farm->mw,
                    'tanks_count' => $farm->tanks->count(),
                    'total_lux' => $farm->lights->sum('lux'),
                ];
            });

            //TODO make sure this dynamically shows on the window
            // Get the total number of farms associated with this game
            $totalFarms = $game->farms()->count();

            //TODO make sure this dynamically shows on the window
            // Get the total number of tanks associated with all farms in this game
            $totalTanks = $farms->sum('tanks_count');

            //TODO make sure this dynamically shows on the window
            // Get the total lux across all farms in this game
            $totalLux = $farms->sum(function ($farm) {
                return $farm->lights->sum('lux');
            });

            //TODO make sure this dynamically shows on the window
            $moneyPerSecond = $this->getAlgaeHarvestPerSecond($farms) *30;

            return response()->json([
                'success' => true,
                'currentMoney' => $currentMoney,
                'moneyPerSecond' => $moneyPerSecond,
                'farmData' => $farmData,
                'totalFarms' => $totalFarms,
                'totalTanks' => $totalTanks,
                'totalLux' => $totalLux,
            ]);

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }

        //need to calculate how money is calculated here (variable)

        //need to calculate how much algae is being produced (sum up all tank production)

        //need to calculate nutrient loss (sum up all tank useage, need to be able to add to the things)

        //need to calculate temperature (variable)

        //return collection that will be converted to a json for react
    }

    //TODO make methods for all of these to show production per second
    private function getAlgaeHarvestPerSecond($farms){
        return 1;
    }
}
