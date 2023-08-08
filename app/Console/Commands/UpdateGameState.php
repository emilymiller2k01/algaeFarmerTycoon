<?php

namespace App\Console\Commands;

use App\Models\Farm;
use App\Models\Game;
use Illuminate\Console\Command;

class UpdateGameState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-game-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle($game_id)
    {
        // Fetch the game.
        $game = Game::findOrFail($game_id);

        // Fetch all the farms for this game.
        $farms = $game->farms;

        // Loop over each farm and update the state.
        foreach ($farms as $farm) {

            // Fetch all the tanks for this farm.
            $tanks = $farm->tanks;

            foreach ($tanks as $tank) {
                // Calculate the new algae growth based on the nutrient level, light, and temperature.
                // Please note that I'm using placeholder variable for light and temperature as you
                // haven't specified how you are storing these values.
                $algaeGrowth = $tank->nutrient_level * $farm->lux * $farm->temp;

                // Update the nutrient and CO2 levels based on the algae growth.
                $tank->nutrient_level -= ($algaeGrowth / $tanks->count());
                $tank->co2_level -= ($algaeGrowth / $tanks->count());

                // Save the updated tank.
                $tank->save();
            }

            // Calculate the new money based on the amount of algae harvested.
            // I'm assuming here that you have a method to calculate the total algae harvested.
            $algaeHarvested = $this->calculateAlgaeHarvested($farm);
            $farm->money += ($algaeHarvested * 30);

            // Save the updated farm.
            $farm->save();
        }

        // After all updates, broadcast an event for the frontend to pick up.
        event(new GameStateUpdated($game));
    }

}
