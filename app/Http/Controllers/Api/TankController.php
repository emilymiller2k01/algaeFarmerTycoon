<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Farm;
use App\Models\Tank;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;
use Illuminate\Http\Request;


class TankController extends Controller
{
    public function getValues(Request $request, $game_id ,$tank_id){
        try{ 
            $game = Game::findOrFail(intval($game_id));
            $t = Tank::findOrFail(intval($tank_id));
            
            $tank = [
                'biomass' => $t->biomass,
                'nutrient_level' => $t->nutrient_level,
                'co2_level' => $t->co2_level,
            ];
            
            return response([
                'tank' => $tank,

            ], 200);
            // Return the tank data as JSON response

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Tank not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }

    }
}
