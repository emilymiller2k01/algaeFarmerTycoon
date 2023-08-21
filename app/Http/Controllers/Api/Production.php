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
            $currentMoney = $game->money;

            $farms = $game->farms()->withCount('tanks')->get();

            $farmData = $farms->map(function ($farm) {
                return [
                    'lux' => $farm->lux,
                    'temperature' => $farm->temperature, // Assuming each farm has a temperature
                    'mw' => $farm->mw,
                    'tanks_count' => $farm->tanks->count(),
                    'total_lux' => $farm->lights->sum('lux'),
                ];
            });

            $totalFarms = $game->farms()->count();
            $totalTanks = $farms->sum('tanks_count');
            $totalLux = $farms->sum(function ($farm) {
                return $farm->lights->sum('lux');
            });

            $moneyPerSecond = $this->getMoneyPerSecond($farms);
            $algaeProduction = $this->getAlgaeHarvestPerSecond($farms);
            $nutrientLoss = $this->getNutrientLoss($farms);
            $temperature = $this->calculateTemperature($farms);

            return response()->json([
                'success' => true,
                'currentMoney' => $currentMoney,
                'moneyPerSecond' => $moneyPerSecond,
                'farmData' => $farmData,
                'totalFarms' => $totalFarms,
                'totalTanks' => $totalTanks,
                'totalLux' => $totalLux,
                'algaeProduction' => $algaeProduction,
                'nutrientLoss' => $nutrientLoss,
                'temperature' => $temperature
            ]);

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

        private function getMoneyPerSecond($farms) {
            // Assuming each farm produces a fixed amount of money.
            $moneyFromFarms = $farms->count() * 10; // 10 is a placeholder value
            return $moneyFromFarms;
        }

        private function getAlgaeHarvestPerSecond($farms){
            // Assuming each farm produces a fixed amount of algae.
            $algaeFromFarms = $farms->count() * 5; // 5 is a placeholder value
            return $algaeFromFarms;
        }

        private function getNutrientLoss($farms){
            // Assuming each farm uses a fixed amount of nutrients.
            $nutrientLossFromFarms = $farms->count() * 3; // 3 is a placeholder value
            return $nutrientLossFromFarms;
        }

        private function calculateTemperature($farms) {
            // Assuming temperature increases with the number of farms.
            return 20 + ($farms->count() * 2); // 20 is a base temperature, 2 is a placeholder increment value
        }
}
