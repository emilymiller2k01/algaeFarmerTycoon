<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Game;
use App\Models\Power;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EnergyController extends Controller
{
    public function purchaseEnergy(Request $request, $game_id, $farm_id)
    {
        try {

            $energyType = $request->input('type'); // 'solar', 'wind', or 'gas'

            // Retrieve the energy details from the database
            $energy = Power::where('type', $energyType)->first();

            // Retrieve the game
            $game = Game::findOrFail($game_id);
            $farm = Farm::findOrFail($farm_id);

            // Check if the player has enough money for the startup cost
            if ($game->money >= $energy->startup_cost) {
                //Deduct the startup cost from the game's money
                $game->money -= $energy->startup_cost;
                $game->mw += $energy->mw;
                //Add the energy to the game's list of owned energies
                
                $farm->powers()->attach($energy);

            }

            $game->save();
            $farm->save();

            
            //TODO show this in the power widget


        } catch (ModelNotFoundException $e){
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

            //TODO show this in the production window

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

            //TODO show this in the production window

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
}
