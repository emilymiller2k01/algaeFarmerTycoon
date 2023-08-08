<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TankController extends Controller
{
    public function harvestAlgae($tank_id, $game_id, $farm_id){
        try {

            //TODO make sure this shows on the algae growth bar dynamically
            // Retrieve the tank by its ID
            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $tank = $farm->tanks->where('id', $tank_id)->first();


            // Calculate the amount of algae harvested. For simplicity, we'll assume all algae is harvested.
            $algaeHarvested = $tank->biomass;

            // Calculate the money earned from the harvested algae
            $moneyEarned = $algaeHarvested * 30; // Assuming £30 per kg

            // Increase the player's money
            $game->money += $moneyEarned;
            $game->save();

            // Reset the tank's algae level
            $tank->biomass = 0;
            $tank->save();

            return response()->json([
                'success' => true,
                'message' => 'Algae harvested successfully',
                'moneyEarned' => $moneyEarned
            ]);

        } catch (ModelNotFoundException $e){
            return response("Tank or Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function maxOutNutrients($tank_id, $game_id, $farm_id){
        try {
            // Retrieve the tank by its ID
            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $tank = $farm->tanks->where('id', $tank_id)->first();

            // Max out the nutrient level
            $tank->nutrient_level = 100;
            $tank->save();

            return response()->json([
                'success' => true,
                'message' => 'Nutrients maximized successfully'
            ]);

        } catch (ModelNotFoundException $e){
            return response("Tank Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function maxOutCO2($tank_id, $game_id, $farm_id){
        try {
            // Retrieve the tank by its ID
            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $tank = $farm->tanks->where('id', $tank_id)->first();

            // Max out the CO2 level
            $tank->co2_level = 100;
            $tank->save();

            return response()->json([
                'success' => true,
                'message' => 'CO2 maximized successfully'
            ]);

        } catch (ModelNotFoundException $e){
            return response("Tank Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }    }
}
