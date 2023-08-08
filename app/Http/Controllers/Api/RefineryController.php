<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RefineryController extends Controller
{
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
}
