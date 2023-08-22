<?php

namespace App\Console\Commands;

use App\Events\FrequentGameUpdate;  // Import the event
use App\Models\Farm;
use App\Models\Game;
use App\Models\GameResearchTasks;
use Illuminate\Console\Command;

class UpdateGameState extends Command
{
    protected $signature = 'app:update-game-state {game_id}';  // Add the argument in the signature

    protected $description = 'Command description';

    public function handle()
    {
        // Fetch the game.
        $game_id = $this->argument('game_id');  // Retrieve the game_id argument
        $game = Game::findOrFail($game_id);

        // Check if automated harvesting is researched for this game.
        $automatedHarvesting = $game->researches()->where('name', 'automated_harvesting')->exists();

        // Fetch all the farms for this game.
        $farms = $game->farms;

        // Loop over each farm and update the state.
        foreach ($farms as $farm) {
            // Fetch all the tanks for this farm.
            $tanks = $farm->tanks;

            foreach ($tanks as $tank) {
                // If automated harvesting is researched, check each tank to see if it needs harvesting.
                if ($automatedHarvesting && $tank->current_algae >= ($tank->max_algae_capacity * 0.90)) {
                    // Harvest the tank down to 10% of its max capacity.
                    $tank->current_algae = $tank->max_algae_capacity * 0.10;
                    $tank->save();
                }

                // Calculate the new algae growth based on the nutrient level, light, and temperature.
                $algaeGrowth = $tank->nutrient_level * $farm->lux * $farm->temp;

                // Update the nutrient and CO2 levels based on the algae growth.
                $tank->nutrient_level -= ($algaeGrowth / $tanks->count());
                $tank->co2_level -= ($algaeGrowth / $tanks->count());

                // Save the updated tank.
                $tank->save();
            }

            // Calculate the new money based on the amount of algae harvested.
            $algaeHarvested = $this->calculateAlgaeHarvested($farm, $automatedHarvesting);
            $farm->money += ($algaeHarvested * 30);

            // Save the updated farm.
            $farm->save();
        }

        // After all updates, broadcast the frequent updates event.
        event(new FrequentGameUpdate($game));
    }

    protected function calculateAlgaeHarvested(Farm $farm, $automatedHarvesting)
    {
        $totalHarvested = 0;

        if ($automatedHarvesting) {
            foreach ($farm->tanks as $tank) {
                if ($tank->current_algae >= ($tank->max_algae_capacity * 0.90)) {
                    $harvestAmount = $tank->current_algae - ($tank->max_algae_capacity * 0.10);
                    $totalHarvested += $harvestAmount;
                }
            }
        }

        return $totalHarvested;
    }
}
