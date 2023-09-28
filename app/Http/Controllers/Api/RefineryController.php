<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RefineryController extends Controller
{
    public function updateAssignments(Request $request, $gameId){
        try {
        
            $game = Game::findOrFail($gameId);

            // Get the updated byproduct assignments from the request
            $assignments = $request->input('assignments');

            // Update the byproduct assignments for the game
            $byProducts = $game->byproducts;
            
            // Update the assignments
            $byProducts->update([
                'game_id' => $gameId,
                'biofuel' => $assignments['biofuel'],
                'antioxidants' => $assignments['antioxidants'],
                'food' => $assignments['food'],
                'fertiliser' => $assignments['fertiliser'],
            ]);
            
            // Save the changes to the database
            $byProducts->save();
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }
}
