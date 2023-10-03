<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Game;
use App\Models\Light;
use App\Models\Refinery;
use App\Models\Tank;
use App\Models\MessageLog;
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

                $message = "You just added a new $lightType!";
                $this->addMessageToLog($game_id, $message);

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
            $message = "You just added a new Refinery!";
            $this->addMessageToLog($game_id, $message);

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

            $message = "You just added a new farm!";
            $this->addMessageToLog($game_id, $message);

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
            $production = $game->production;

            // Define cost to maximize nutrients for a tank
            $nutrientCost = $production->nutrient_cost; // Example value

            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;

            // Check if the player has enough money to add nutrients to all tanks and if all tanks are not already maxed.
            $totalCost = $nutrientCost * $tanks->where('nutrient_level', '<', 90)->count();
            if ($game->money < $totalCost) {
                $game->money = $game->money;
            } else {
                // If the player has enough money, deduct the cost.
                $game->money -= $totalCost;
                $game->save();

                // Iterate over each tank and update its nutrient level if it's not already maxed.
                $tanksToUpdate = $tanks->where('nutrient_level', '<', 90);
                $tanksToUpdate->each(function ($tank) {
                    $tank->nutrient_level = 100;
                    $tank->save(); // Assuming 100 is the maximum nutrient level
                });
                $message = "Nutrients topped up!";
                $this->addMessageToLog($game_id, $message);
            }
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
            $production = $game->production;

            // Define cost to maximize CO2 for a tank.
            $co2Cost = $production->co2_cost; // Example value
            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;

            // Check if the player has enough money to add CO2 to all tanks and if all tanks are not already maxed.
            $totalCost = $co2Cost * $tanks->where('co2_level', '<', 90)->count();
            if ($game->money < $totalCost) {
                $game->money = $game->money;
            } else {
                // If the player has enough money, deduct the cost.
                $game->money -= $totalCost;
                $game->save();

                // Iterate over each tank and update its CO2 level if it's not already maxed.
                $tanksToUpdate = $tanks->where('co2_level', '<', 90);
                $tanksToUpdate->each(function ($tank) {
                    $tank->co2_level = 100; 
                    $tank->save();// Assuming 100 is the maximum CO2 level
                });
                $message = "CO2 topped up!";
                $this->addMessageToLog($game_id, $message);
            }
            

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
            $message = "You just added a new tank to the farm!";
            $this->addMessageToLog($game_id, $message);

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

    public function harvestFarmAlgae(Request $request, $game_id, $farm_id){
        try{
            $farm = Farm::findOrFail($farm_id);
            $tanks = $farm->tanks;
            $game = $farm->game;
            $production = $game->production;

            $totalHarvestedAlgae = 0;
            $totalEarned = 0;
            
            foreach ($tanks as $tank) {
                $harvestedAlgae = $tank->biomass - ($tank->capacity *0.1);
                if ($harvestedAlgae > 0){
                    $tank->biomass = $tank->capacity * 0.1;
                    $totalHarvestedAlgae += $harvestedAlgae;
                    // Convert grams to kilograms and calculate earnings
                    $harvestedAlgaeInKg = $harvestedAlgae / 1000;
                    $totalEarned += $harvestedAlgaeInKg * $production->algae_cost; 
                }
                $tank->save();
            }

            // Add earnings to game money
            $game->money += $totalEarned;

            $farm->save();
            $game->save();

            $message = "Harvested $harvestedAlgaeInKg KGs of algae and earned $$totalEarned";
            $this->addMessageToLog($game_id, $message);

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
                
                $message = "Temperature is {$farm->temp}" . html_entity_decode("&#176;") . "C";
                $this->addMessageToLog($game_id, $message);

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

            $message = "Temperature is {$farm->temp}" . html_entity_decode("&#176;") . "C";
            $this->addMessageToLog($game_id, $message);

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

    private function addMessageToLog($game_id, $message){
        $game = Game::find($game_id);
        $game->addMessageToLog($message);
    }

}
