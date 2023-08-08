<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Game;
use App\Models\Light;
use App\Models\Refinery;
use App\Models\Tank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function addLight(Request $request, $farm_id, $game_id) {
        try {
            $lightType = $request->input('lightType');

            $selectedFarm = Farm::find($farm_id);
            $game = Game::findOrFail($game_id);
            // Get a light of the requested type
            $selectedLight = Light::where('type', $lightType)->first();

            //return [$selectedLight, $game];

            if ($game->money >= $selectedLight->cost && $game->mw >= $selectedLight->mw) {
                //return "hello";
                // Deduct the cost of the light from the game's money and MW
                $game->decrement('money', $selectedLight->cost);
                $game->decrement('mw', $selectedLight->mw);

                // Add the light's lux to the farm's lux
                $selectedFarm->increment('lux', $selectedLight->lux);

                // Save changes to the game and farm
                $game->save();
                $selectedFarm->save();

                // Associate the light with the selected farm
                $selectedFarm->lights()->attach($selectedLight->id);

                //TODO update this in the production window

                return response()->json([
                    'success' => true,
                    'message' => 'Light added successfully',
                    // any other data you want to return...
                ]);
            } else {
                // Not enough money or MW, handle this situation
                //TODO make a better else statment
                return response()->json([
                    'success' => false,
                    'message' => 'Light not added ',
                ]);
            }
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addRefinery(Request $request, $farm_id, $game_id){
        try {
            //TODO check if you can add a refinery

            // Find the farm using the provided ID.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Create a new refinery.
            $refinery = new Refinery;
            // Set any default or required values for your new refinery here.
            $refinery->produce = $request->input('produce');
            $refinery->mw = $request->input('mw');

            //return $refinery;

            //different mw depending on the product made

            // Attach the refinery to the farm.
            $farm->refineries()->save($refinery);

            //TODO show the refinery on the refinery widget in the farm

            return response()->json([
                'success' => true,
                'message' => 'Refinery added successfully',
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addFarm(Request $request, $game_id){
        try {

            //TODO add an if statment for money etc
            //need to figure out cost of a farm

            $game = Game::findOrFail($game_id);

            $newFarm = new Farm;
            $newFarm->game_id = $game_id;
            $newFarm->total_biomass = 0; // default value
            $newFarm->lux = 0; // default value
            $newFarm->temp = 20; // default value, you can adjust it as per your game logic
            $newFarm->mw = 0; // default value

            $game->farms()->save($newFarm);

            //TODO show the new farm listed on the far selection pane

            return response()->json([
                'success' => true,
                'message' => 'Farm created successfully',
                'farm' => $newFarm,
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addFarmNutrients(Request $request, $farm_id, $game_id){
        try {

            //TODO handle no money or already maxed nutrients

            // Fetch the farm by its ID.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;

            // Iterate over each tank and update its nutrient level.
            $tanks->each(function ($tank) {
                $tank->update(['nutrient_level' => 100]); // Assuming 100 is the maximum nutrient level
            });

            //TODO make sure this is updated on the production window

            return response()->json([
                'success' => true,
                'message' => 'Nutrients maximized successfully',
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addFarmCo2(Request $request, $farm_id, $game_id){
        try {// Fetch the farm by its ID.
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            // Fetch all tanks associated with the farm.
            $tanks = $farm->tanks;

            // Iterate over each tank and update its nutrient level.
            $tanks->each(function ($tank) {
                $tank->update(['co2_level' => 100]); // Assuming 100 is the maximum nutrient level
            });

            //TODO make sure this is updated on the production window

            return response()->json([
                'success' => true,
                'message' => 'CO2 maximized successfully',
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function addFarmTank(Request $request, $game_id, $farm_id)
    {

        try {// Retrieve the farm by its ID
            $farm = Farm::findOrFail($farm_id);
            $game = Game::findOrFail($game_id);

            //TODO check if max number of tanks is met already - max=8 should have this as an attribute?

            // Create a new Tank instance
            $newTank = new Tank;

            // Set properties of the tank from the request
            $newTank->farm_id = $farm_id;
            $newTank->nutrient_level = 0;//$request->input('nutrient_level');
            $newTank->co2_level = 0;//$request->input('co2_level');
            $newTank->biomass = 0;//$request->input('biomass');
            $newTank->mw = 0;//$request->input('mw');


            // Associate the new tank with the farm
            $newTank->save();

            //TODO show new tank in the farm

            return response()->json([
                'success' => true,
                'message' => 'Tank added to farm successfully',
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function harvestFarmAlgae(Request $request, $farm_id){
        try{
            $farm = Farm::findOrFail($farm_id);
            $tanks = $farm->tanks;

            $totalHarvestedAlgae = 0;
            $totalEarned = 0;

            foreach ($tanks as $tank) {
                $harvestedAlgae = $tank->biomass * 0.9; // 90% of the algae
                $totalHarvestedAlgae += $harvestedAlgae;

                // Convert grams to kilograms and calculate earnings
                $harvestedAlgaeInKg = $harvestedAlgae / 1000;
                $totalEarned += $harvestedAlgaeInKg * 30; // £30 per kg

                // Update tank biomass
                $tank->biomass *= 0.1; // Remaining 10%
                $tank->save();
            }

            // Add earnings to game money
            $game = $farm->game;
            $game->increment('money', $totalEarned);

            //TODO show algae decrease, money increase and update all tank sliders

            return response()->json([
                'success' => true,
                'message' => 'Algae harvested successfully',
                'totalHarvestedAlgae' => $totalHarvestedAlgae,
                'totalEarned' => $totalEarned,
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function incrementTemperature(Request $request, $farm_id, $game_id) {
        try{// Define the energy cost to increase the temperature
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

                //TODO get this to show on the production window

                return response()->json([
                    'newTemperature' => $farm->temp,
                    'remainingMW' => $game->mw
                ]);
            } else {
                return response()->json([
                    'error' => 'Not enough energy to increase temperature'
                ], 400);
            }
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }
    public function decrementTemperature(Request $request, $farm_id, $game_id) {
        try { // Energy regained by reducing the temperature
            $energyGain = 0.5; // gain in mw

            $game = Game::findOrFail($game_id);
            $farm = $game->farms->where('id', $farm_id)->first();
            $farm->temp -= 1; // increase by 1 degree, adjust as needed
            $farm->save();

            // Increase the available energy
            $game->mw += $energyGain;
            $game->save();

            //TODO get this to show on the production window

            return response()->json([
                'newTemperature' => $farm->temp,
                'remainingMW' => $game->mw
            ]);
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }
}
