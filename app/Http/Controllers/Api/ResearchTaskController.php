<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;
use App\Models\Game;


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
            return response()->json(['message' => 'Research task already completed']);
        }


        // Call corresponding functions based on task ID
        switch ($task['title']) {
            case 'Automated Harvesting System':
                $this->completeAutomatedHarvestingSystem($game, $task);
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
        // need to be constantly be checking when any tank gets over 90% of its capacity 
        // if tank capacity is more than or equal to 90% remove algae leaving 10% in the tank 
        // for each 1% of algae is equal to 100g of biomass 
        // each kg of algae equals £30 
        // add money to the game 
        // remove the total biomass from the games biomass 
        try{

            if ($game->money >= $task->cost && $game->mw >= 0.5){
                $task->completed = true;
                $task->save();
                $game->decrement('money', $tank->cost);
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

            if ($game->money >= $task->cost && $game->mw >= $task->mw){
                $task->completed = true;
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

            $farms = $this->farms()->with('tanks')->get();
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
        //co2 cost reduces to 1£ per 1% 
        // increases biomass production by 7.5%
        //add pH to production screen 
        // ad controls for controlling the bubble rate - more bubbles ph reduces, less bubbles ph increses 
        // multiply the biomass output by 7.5% if this has been reserched 
        try{if ($game->money >= $task->cost && $game->mw >= $task->mw ){
            $task->completed = true;
            $task->save();
            $game->decrement('money', $task->cost);
            $game->decrement('mw', $task->mw);
            $game->save();
            //todo change this so it controls the pH increasing production
            //reduce the cost of co2 adding 
            // add ph to the production screen 
        }}catch (ModelNotFoundException $e){
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response($e, 500);
        }
    }

    public function completedCo2Management(Game $game, ResearchTasks $task)
    {
        //todo how to get this to run automatically 
        // needs to constantly monitor the co2 in the tanks to see if it gets lower than 90%
        //max it out to 100% 
        // calculate total sum of co2 required to amx out all nexessary tanks 
        // reduct that cost from the game's money 
        try{if ($game->money >= $task->cost && $game->mw >= $task->mw){
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

    public function completedSensorTechnology(Game $game, ResearchTasks $task)
    {
        //more accurate readings of the co2, nutrients reducing the cost of maintainence 
        // co2 and nutrient cost reduces by 15% 
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

    public function completedAlgaeByProducts(Game $game, ResearchTasks $task)
    {
        //add refineries management to the main screen 
        //add the settings icon to the refienries tab and then load a popup which allows you to assign refineries to make that product 
        //add the different products of algae to make 
        //send all the harvested algae to the refineries 
        
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
