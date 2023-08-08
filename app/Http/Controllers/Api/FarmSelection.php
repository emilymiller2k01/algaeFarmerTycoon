<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FarmSelection extends Controller
{
    public function index($game_id){
        try {
            $game = Game::findOrFail($game_id);

            //get all the farms associated from this game

            $farms = $game->farms;

            return response()->json([
                'success' => true,
                'farms' => $farms,
            ]);
        }
        catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function selectFarm(Request $request, $game_id)
    {
        try {
            $farm_id = $request->input('farm_id');

            $game = Game::findOrFail($game_id);

            // Check if the farm belongs to this game
            if ($game->farms->contains('id', $farm_id)) {
                // Store the selected farm ID in the game record
                $game->selected_farm_id = $farm_id;
                $game->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Farm selected successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'This farm does not belong to the specified game',
                ], 400);
            }
        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e) {
            return response('Internal Server Error', 500);
        }
    }

}
