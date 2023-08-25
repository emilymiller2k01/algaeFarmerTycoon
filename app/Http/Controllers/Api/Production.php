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
use App\Events\GameStateUpdated;


class Production extends Controller
{
    public function index($game_id)
    {
        try {
            $game = Game::findOrFail($game_id);
            $currentMoney = $game->money;

            $farms = $game->farms()->with(['tanks', 'lights'])->get();

            $algaeMass = 1;
            $algaeRate = 0;
            $nutrientLoss = 0;

            $farms->each(function ($farm) use ($game, &$algaeMass, &$algaeRate, &$nutrientLoss) {
                // Calculate algae mass and rate for each farm
                $algaeMass += $farm->algaeMass; // Assuming each farm has algaeMass attribute
                $algaeRate += $this->calculateAlgaeRate($farm);

                // Calculate nutrient loss for each farm
                $nutrientLoss += $this->getNutrientLoss($farm);

                // Harvest algae for tanks which are more than 90% full
                $farm->tanks->each(function ($tank) use ($game) {
                    if ($tank->algaePercentage > 90) {
                        // Adjust game money based on harvested algae
                        $harvestAmount = $tank->algaeMass * 0.95;
                        $game->money += $harvestAmount;
                        $tank->algaeMass *= 0.05;
                        $tank->save();
                    }
                });
            });

            // ... [rest of the calculations]

            $moneyPerSecond = $this->getMoneyPerSecond($farms);

            broadcast(new GameStateUpdated($game));

            return response()->json([
                'success' => true,
                'currentMoney' => $currentMoney,
                'moneyPerSecond' => $moneyPerSecond,
                'algaeMass' => $algaeMass,
                'algaeRate' => $algaeRate,
                'nutrientLoss' => $nutrientLoss,
                // ... [rest of the data]
            ]);

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

    private function calculateAlgaeRate($farm)
    {
        // This is a hypothetical formula for the rate of growth of algae
        // which is influenced by light (lux), temperature, nutrients, and CO2.
        return ($farm->lux * $farm->temperature * $farm->nutrients * $farm->co2) / 1000;
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
