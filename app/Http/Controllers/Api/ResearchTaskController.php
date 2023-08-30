<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResearchTasks;
use Illuminate\Http\Request;

class ResearchTaskController extends Controller
{
    public function showCompletedTasks($gameId)
    {
        $completedTasks = ResearchTasks::where('game_id', $gameId)
            ->where('completed', true)
            ->get();
        return response()->json($completedTasks);
    }

    public function completeResearch(Request $request, Game $gameId, Task $taskId)
    {
        $game = Game::findOrFail($gameId);
        $task = ResearchTask::findOrFail($taskId);
        
        if ($task->completed) {
            return response()->json(['message' => 'Research task already completed']);
        }

        // Call corresponding functions based on task ID
        switch ($taskId) {
            case 1:
                $this->completeAutomatedHarvestingSystem($game, $task);
                break;
            case 2:
                $this->completeAutomatedNutrientManagement($game, $task);
                break;
            case 3:
                $this->completedVerticalFarming($game, $task);
                break;
            case 4:
                $this->completedRenewableEnergies($game, $task);
                break;
            case 5:
                $this->completedBubbleTechnology($game, $task);
                break;
            case 6: 
                $this->completedCo2Management($game, $task);
                break;
            case 7:
                $this->completedSensorTechnology($game, $task);
                break;
            case 8:
                $this->completedAlgaeByProducts($game, $task);
                break;
            case 9:
                $this->completedAddingRefineries($game, $task);
                break;
        };

        return response()->json(['message' => 'Research task completed']);
    }

    public function completeAutomatedHarvesting(Game $game, Task $task)
    {
        if ($game->money >= 100 && $game->mw >= 0.5){
            $task->completed = true;
            $task->save();
            $game->decrement('money', 100);
        
        }

        
    }

    public function completedAutomatedNutrientManagement(Game $game, Task $task)
    {
        //TODO fix this function 
        //need to run this every second 
        //add checks for money and mw 
        if ($game->money >= 75 && $game->mw >= 0.5){
            $task->completed = true;
            $task->save();
            $game->decrement('money');
            
        }
    }


    public function completedVerticalFarming(Game $game, Task $task)
    {
       if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();

            $farms = $this->farms()->with('tanks')->get();
            foreach ($farms as $farm) {
                foreach ($farm->tanks as $tank) {
                    
                        $tank->capacity = $tank->capacity * 2;
                        $tank->save();
                }
            }
        }
    }


    public function completedRenewableEnergies(Game $game, Task $task)
    {
        if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
        }
        //complete research task 
        // partially reload the front end so that it shows the renewables 
    }


    public function completedBubbleTechnology(Game $game, Task $task)
    {
        if ($game->money >= $task->cost && $game->mw >= $task->mw ){
            //todo change this so it controls the pH increasing production
            //reduce the cost of co2 adding 
            // add ph to the production screen 
        }
    }

    public function completedCo2Management(Game $game, Task $task)
    {
        //todo how to get this to run automatically 
        if ($game->money >= $task->cost && $game->mw >= $task->mw){
            $task->completed = true;
            $task->save();
            
        }
    }

    public function completedSensorTechnology(Game $game, Task $task)
    {
        //more accurate readings of the co2, nutrients reducing the cost of maintainence 
        //increase algae readings by 5%
        if ($game->money >= $task->cost){
            $task->completed = true;
            $task->save();
        }

    }

    public function completedAlgaeByProducts(Game $game, Task $task)
    {
        //add refineries management to the main screen 
        //add the different products of algae to make 
        if ($game->money >= $task->cost){
            $task->complete = true;
            $task->save();
        }
        
    }

    public function completedAddingRefineries(Game $game, Task $task)
    {
        //add refineries to the main screen 
        //add the refinery button to the expansions screen 
        //partial relaod 
        if ($game->money >= $task->cost){
            $task->complete = true;
            $task->save();
        }
    }
}
