<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\getProductionData; 
use App\Models\Game;
use Inertia\Inertia;

class ProductionDataController extends Controller
{
    public function index(Request $request, $game_id)
    {
        $game= Game::findOrFail(intval($game_id));
        // Call the helper function to get production data
        $productionData = getProductionData($game);

        //Need to send this and set the prod data to the front end 

        return response([
            'productionData' => $productionData,
            'initialGame' => $game,
        ], 200);
    }

    public function makeByProducts(Request $request, $game_id){

    }

    public function autoHarvest(Request $request, $game_id){

    }

    
}