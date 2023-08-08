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
            if ($game->money < $energy->startup_cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient funds',
                ]);
            }

            // Deduct the startup cost from the game's money
            $game->money -= $energy->startup_cost;
            $game->save();

            // Add the energy to the game's list of owned energies
            // Assuming you have a pivot table or related table for this.
            $farm->powers()->attach($energy);


            return response()->json(['message' => 'Energy source purchased successfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Game or Farm Not Found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
