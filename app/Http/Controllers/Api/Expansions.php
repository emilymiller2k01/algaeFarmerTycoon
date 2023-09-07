<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Game;
use App\Models\Light;
use App\Models\Refinery;
use App\Models\Tank;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class Expansions extends Controller
{
    public function index($game_id){
        try {
            $game = Game::findOrFail($game_id);

            $farms = $game->farms;

            //$game->save();

            dd($game);
        }
        catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addLight(Request $request, $game_id, $farm_id) {
        try {
            $lightType = $request->input('lightType');

            $selectedFarm = Farm::find($farm_id);
            $game = Game::findOrFail($game_id);
            // Get a light of the requested type
            $selectedLight = Light::where('type', $lightType)->first();

            if ($game->money >= $selectedLight->cost && $game->mw >= $selectedLight->mw) {
                //return "hello";
                // Deduct the cost of the light from the game's money and MW
                $game->money -= $selectedLight->cost;
                $game->mw = $game->mw - $selectedLight->mw;

                // Add the light's lux to the farm's lux
                $selectedFarm->increment('lux', $selectedLight->lux);

                // Save changes to the game and farm
                $game->save();
                $selectedFarm->save();

                // Associate the light with the selected farm
                $selectedFarm->lights()->attach($selectedLight->id);

            }
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addRefinery(Request $request, $game_id, $farm_id){
        try {
            // Find the farm and the game using the provided IDs.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Define the cost of a refinery
            $refineryCostMoney = 20;  // Example cost
            $refineryCostMW = 3;      // Example MW requirement

            if ($game->money < $refineryCostMoney && $game->mw < $refineryCostMW) {
                $game->money = $game->money;
            }

            // Deduct the cost of the refinery from the player's resources
            $game->money -= $refineryCostMoney;
            $game->mw -= $refineryCostMW;
            $game->save();

            // Create a new refinery.
            $refinery = new Refinery;
            $refinery->produce = 'food';
            $refinery->mw = 3;

            // Attach the refinery to the farm.
            $farm->refineries()->save($refinery);

            //return Inertia::location("/game/$game->id");

        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404
            ]);
        } catch (Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500
            ]);
        }
    }


    public function addFarm(Request $request, $game_id){
        try {
            $game = Game::findOrFail($game_id);
            $farms = $game->farms();

            $farmCostMoney = 100;
            $farmCostMW = 2;

            if($game->money < $farmCostMoney && $game->mw < $farmCostMW) {
                return Inertia::location("/game/$game->id");
            }

            $game->money -= $farmCostMoney;
            $game->mw -= $farmCostMW;

            $newFarm = new Farm;
            $newFarm->game_id = $game_id;

            $game->farms()->save($newFarm);
            $game->selected_farm_id = $newFarm->id;


        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addFarmNutrients(Request $request, $game_id, $farm_id){
        try {
            // Fetch the farm and game by their IDs.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Define cost to maximize nutrients for a tank
            $nutrientCost = 50; // Example value

            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;

            // Check if the player has enough money to add nutrients to all tanks and if all tanks are not already maxed.
            $totalCost = $nutrientCost * $tanks->where('nutrient_level', '<', 100)->count();
            if ($game->money < $totalCost) {
                $game->money = $game->money;
            }

            // If the player has enough money, deduct the cost.
            $game->money -= $totalCost;
            $game->save();

            // Iterate over each tank and update its nutrient level if it's not already maxed.
            $tanksToUpdate = $tanks->where('nutrient_level', '<', 100);
            $tanksToUpdate->each(function ($tank) {
                $tank->update(['nutrient_level' => 100]);
                $tank->save(); // Assuming 100 is the maximum nutrient level
            });


        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404
            ]);
        } catch (Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500
            ]);
        }
    }


    public function addFarmCo2(Request $request, $game_id, $farm_id){
        try {

            // Fetch the farm and game by their IDs.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);


            // Define cost to maximize CO2 for a tank.
            $co2Cost = 50; // Example value

            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;


            // Check if the player has enough money to add CO2 to all tanks and if all tanks are not already maxed.
            $totalCost = $co2Cost * $tanks->where('co2_level', '<', 100)->count();

            if ($game->money < $totalCost) {

                $game->money = $game->money;

            }

            // If the player has enough money, deduct the cost.
            $game->money -= $totalCost;
            $game->save();

            // Iterate over each tank and update its CO2 level if it's not already maxed.
            $tanksToUpdate = $tanks->where('co2_level', '<', 100);
            $tanksToUpdate->each(function ($tank) {
                $tank->update(['co2_level' => 100]); // Assuming 100 is the maximum CO2 level
            });

        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404
            ]);
        } catch (Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500
            ]);
        }
    }


    public function addFarmTank(Request $request, $game_id, $farm_id)
    {
        try {
            // Retrieve the farm by its ID
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Check if the farm already has the max number of tanks (8 in this case)
            $currentTankCount = $farm->tanks->count();
            if ($currentTankCount < 8) {
                // Create a new Tank instance
                $newTank = new Tank;

                // Set properties of the tank
                $newTank->farm_id = $farm_id;
                $newTank->nutrient_level = 100;
                $newTank->co2_level = 100;
                $newTank->biomass = 1;
                $newTank->mw = 0.5;

                // Associate the new tank with the farm and save
                $farm->tanks()->save($newTank);

                // Get the updated list of tanks for the farm to show in the view
            }

            $updatedTanks = $farm->tanks()->get();
            //$game->refresh();

            // Render the Inertia view with the updated tanks list
            //return Inertia::location("/game/$game->id");

        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404,
            ]);
        } catch (Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500,
            ]);
        }
    }

    public function harvestFarmAlgae(Request $request, $farm_id){
        try{
            $farm = Farm::findOrFail($farm_id);
            $tanks = $farm->tanks;

            $totalHarvestedAlgae = 0;
            $totalEarned = 0;

            // Collecting updated tanks to pass them to the front end
            $updatedTanks = [];

            foreach ($tanks as $tank) {
                $harvestedAlgae = $tank->biomass * 0.9; // 90% of the algae
                $totalHarvestedAlgae += $harvestedAlgae;

                // Convert grams to kilograms and calculate earnings
                $harvestedAlgaeInKg = $harvestedAlgae / 1000;
                $totalEarned += $harvestedAlgaeInKg * 30; // £30 per kg

                // Update tank biomass
                $tank->biomass *= 0.05; // Remaining 5%
                $tank->save();

                // Add updated tank to the list
                $updatedTanks[] = $tank;
            }

            // Add earnings to game money
            $game = $farm->game;
            $game->increment('money', $totalEarned);

            $farm->save();
            $game->save();

        } catch (ModelNotFoundException $e){
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404,
            ]);
        } catch (Exception $e){
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500,
            ]);
        }
    }


    public function incrementTemperature(Request $request, $farm_id, $game_id) {
        try{
            // Define the energy cost to increase the temperature
            $energyCost = 0.5; // cost in mw

            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();

            // Check if the game has enough energy to increase the temperature
            if ($game->mw >= $energyCost) {
                $farm->temp += 1; // increase by 1 degree, adjust as needed
                $farm->save();

                // Deduct the energy cost
                $game->mw -= $energyCost;
                $game->save();

            } else {
                return Inertia::render('Error', [
                    'message' => 'Not enough energy to increase temperature',
                    'status' => 400
                ]);
            }
        } catch (ModelNotFoundException $e){
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404,
            ]);
        } catch (Exception $e){
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500,
            ]);
        }
    }

    public function decrementTemperature(Request $request, $farm_id, $game_id) {
        try {
            // Energy regained by reducing the temperature
            $energyGain = 0.5; // gain in mw

            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $farm->temp -= 1; // decrease by 1 degree, adjust as needed
            $farm->save();

            // Increase the available energy
            $game->mw += $energyGain;
            $game->save();

        } catch (ModelNotFoundException $e) {
            return Inertia::render('Error', [
                'message' => 'Resource Not Found',
                'status' => 404
            ]);
        } catch (Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Internal Server Error',
                'status' => 500
            ]);
        }
    }

}
