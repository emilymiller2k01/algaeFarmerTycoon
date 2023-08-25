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

        // Mark the task as completed
        $task->update(['completed' => true]);

        // Call corresponding functions based on task ID
        switch ($taskId) {
            case 1:
                $this->completeAutomatedHarvestingSystem($game, $task);
                break;
            case 2:
                $this->completeAutomatedNutrientManagement();
                break;
            case 3:
                $this->completedVerticalFarming();
                break;
            case 4:
                $this->completedRenewableEnergies();
                break;
            case 5:
                $this->completedBubbleTechnology();
                break;
            case 6: 
                $this->completedCo2Management();
                break;
            case 7:
                $this->completedSensorTechnology();
                break;
            case 8:
                $this->completedAlgaeByProducts();
                break;
            case 9:
                $this->completedAddingRefineries();
                break;
        };

        return response()->json(['message' => 'Research task completed']);
    }

    public function completeAutomatedHarvesting(Game $game, Task $task)
    {
        $game->decrement('money', 100);
        
        $tanks = $game->farms->flatMap(function ($farm) {
            return $farm->tanks;
        });

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
    }

    public function completedAutomatedNutrientManagement()
    {

    }

    public function completedVerticalFarming()
    {

    }

    public function completedRenewableEnergies()
    {

    }

    public function completedBubbleTechnology()
    {

    }

    public function completedCo2Management()
    {

    }

    public function completedSensorTechnology()
    {

    }

    public function completedAlgaeByProducts()
    {

    }

    public function completedAddingRefineries()
    {

    }
}
