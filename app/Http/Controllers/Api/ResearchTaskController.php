<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Byproducts;
use Illuminate\Support\Facades\Artisan;



class ResearchTaskController extends Controller
{

    public function showCompletedTasks($gameId)
    {
        $completedTasks = ResearchTasks::where('game_id', $gameId)
            ->where('completed', true)
            ->get();
        return response()->json($completedTasks);
    }

    public function completeResearch(Request $request, $gameId, $taskId)
    {
        $game = Game::findOrFail(intval($gameId));
        
        $task = ResearchTasks::findOrFail(intval($taskId));
      
        
        if ($task->completed) {
            return;
        }


        // Call corresponding functions based on task ID
        switch ($task['title']) {
            case 'Automated Harvesting System':
                $this->completeAutomatedHarvesting($game, $task);
                break;
            case 'Automated Nutrient Management':
                $this->completedAutomatedNutrientManagement($game, $task);
                break;
            case 'Vertical Farming':
                $this->completedVerticalFarming($game, $task);
                break;
            case 'Renewable Energies':
                $this->completedRenewableEnergies($game, $task);
                break;
            case 'Bubble Technology':
                $this->completedBubbleTechnology($game, $task);
                break;
            case 'CO2 Management System': 
                $this->completedCo2Management($game, $task);
                break;
            case 'Sensor Technology':
                $this->completedSensorTechnology($game, $task);
                break;
            case 'Algae By-products':
                $this->completedAlgaeByProducts($game, $task);
                break;
            case 'Adding Refineries':
                $this->completedAddingRefineries($game, $task);
                break;
        };
    }

    public function completeAutomatedHarvesting(Game $game, ResearchTasks $task)
    {
        $tanks = [];
        $farms = $game->farms;
        foreach ($farms as $farm){
            $ts = ($farm->tanks);
            $tanks = array_merge($tanks, $ts->all());
        }
        try{
            
            if ($game->money >= $task->cost && $game->mw >= 0.5){
                
                Artisan::call('biomass:check', [
                    'game_id' => $game->id,
                ]);
                
                $task->completed = true;

                $task->save();
                $game->decrement('money', $task->cost);
                $game->save();

            }            
            else {

            }
        }
        catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
        
    }

    public function completedAutomatedNutrientManagement(Game $game, ResearchTasks $task)
    {
        //TODO fix this function 
        //need to check every tank is above 90% saturated if it is lower then max out the nutruents 
        //nutrients cost 2£ per 1% so need to know how much % is added at each cycle 
        //find out the average nutrient addition to all of the tanks and add that to the games nutrient variable
        //minus the amount of money needed to perform this from the game 
        // do not run this if there is not enough moeny and when the game has enough money run it again 
        try {
            $tanks = [];
            $farms = $game->farms;
            foreach ($farms as $farm){
                $ts = ($farm->tanks);
                $tanks = array_merge($tanks, $ts->all());
            }

            if ($game->money >= $task->cost && $game->mw >= $task->mw){
                $task->completed = true;
                Artisan::call('tank:check-nutrients', [
                    'tanks' => $tanks,
                ]);
                $task->save();
                $game->decrement('money', $task->cost);
                $game->decrement('mw', $task->mw);
                $game->save();
            }
        } catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }


    public function completedVerticalFarming(Game $game, ResearchTasks $task)
    {
       try{if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->save();

            $farms = $game->farms;

            foreach ($farms as $farm) {
                foreach ($farm->tanks as $tank) {
                    
                        $tank->capacity = $tank->capacity * 2;
                        $tank->save();
                }
            }
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }


    public function completedRenewableEnergies(Game $game, ResearchTasks $task)
    {
        try{if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->save();
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }


    public function completedBubbleTechnology(Game $game, ResearchTasks $task)
    {
        // increases biomass production by 7.5%
        $production = $game->production;
        $production->gr_multiplier = 1.15;
        $production->save();

        try{if ($game->money >= $task->cost && $game->mw >= $task->mw ){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->decrement('mw', $task->mw);
            $game->save();
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }

    public function completedCo2Management(Game $game, ResearchTasks $task)
    {
        $tanks = [];
        $farms = $game->farms;
        foreach ($farms as $farm){
            $ts = ($farm->tanks);
            $tanks = array_merge($tanks, $ts->all());
        }
        try{if ($game->money >= $task->cost && $game->mw >= $task->mw){
            $task->completed = true;
            Artisan::call('tank:check-co2', [
                'tanks' => $tanks,
            ]);
            $task->save();
            $game->decrement('money', $task->cost);
            $game->decrement('mw', $task->mw);
            $game->save();
            
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }

    public function completedSensorTechnology(Game $game, ResearchTasks $task)
    {
        //more accurate readings of the co2, nutrients reducing the cost of maintainence 
        // co2 and nutrient cost reduces by 15% 
        $production = $game->production;

        try{if ($game->money >= $task->cost){
            $production->co2_cost = $production->co2_cost * 0.85;
            $production->nutrient_cost = $production->nutrient_cost * 0.85;
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->save();
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }

    }

    public function completedAlgaeByProducts(Game $game, ResearchTasks $task)
    {
             
        try{if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->save();
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
        
    }

    public function completedAddingRefineries(Game $game, ResearchTasks $task)
    {
        
        try{if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->save();
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }
}
