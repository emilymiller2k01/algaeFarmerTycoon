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
        //need to run this every second 
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
        //complete research task 
        // partially reload the front end so that it shows the renewables 
    }


    public function completedBubbleTechnology(Game $game, ResearchTasks $task)
    {
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
        //increase algae readings by 5%
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
        //add the different products of algae to make 
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
        //add refineries to the main screen 
        //add the refinery button to the expansions screen 
        //partial relaod 
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
