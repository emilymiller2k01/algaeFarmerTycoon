<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Farm;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class CheckAlgaeBiomass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biomass:check {game_id}';
    protected $description = 'Check algae biomass levels and trigger harvest if necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {  
        $gameId = $this->argument('game_id');
        $game = Game::findOrFail($gameId);
        $research_tasks = $game->researchTasks;

        $targetTask = null;
        foreach ($researchTasks as $task) {
            if ($task['title'] === 'Automated Harvesting System') {
                $targetTask = $task; // Store the task if it matches the criteria
                break; // Exit the loop once the task is found
            }
        }

        if ($targetTask['completed'] === true){
            $tanks = [];
            foreach ($game->farms as $farm) {
                $tanks = array_merge($tanks,( $farm->tanks)->all());
            }
            $i = 0;
            while ($i<12){
                $i = $i +1;
    
                foreach ($tanks as $tank) { //HERE
                    $this->harvestAlgae($tank, $game);
                }
                sleep(5);
            }
        }         
    }
    
    private function harvestAlgae($tank, $game)
    {    
        $biomassPercentage = ($tank->biomass / $tank->capacity) * 100;
        if ($biomassPercentage > 9) {
            // Begin a database transaction to ensure consistency
            //DB::beginTransaction();

            try {
                // Harvest algae by setting biomass to 10% of capacity
                $harvested_algae = ($tank->biomass * 0.9)/1000;

                $tank->biomass -= $harvested_algae;                
                $tank->save();
                $totalEarned = $harvested_algae * 40;

                $game->money += $totalEarned;

                $message = "Harvested $harvestedAlgaeInKg KGs of algae and earned $$totalEarned";
                $game->addMessageToLog($message);
                
                $game->save();
            } catch (\Exception $e) {
                // Handle any exceptions and rollback the transaction if an error occurs
                //DB::rollBack();

                // Log the error
                Log::error('An error occurred during the algae harvest in tank ' . $tank->id . ': ' . $e->getMessage());
            }
        }
    }
}
