<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAlgaeBiomass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-algae-biomass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }

    private function harvestAlgae($tank)
{
    $farm = Farm::find($tank->farm_id);
    $game = Game::find($farm->game_id);

    // Define the energy cost to perform the harvest
    $energyCost = 0.5; // Cost in mw

    // Check if the game has enough energy to perform the harvest
    if ($game->mw >= $energyCost) {
        $harvestedAlgae = $tank->biomass - ($tank->capacity * 0.1);

        if ($harvestedAlgae > 0) {
            // Begin a database transaction to ensure consistency
            DB::beginTransaction();

            try {
                // Update the tank's biomass and save it
                $tank->biomass = $tank->capacity * 0.1;
                $tank->save();

                // Calculate the earnings
                $harvestedAlgaeInKg = $harvestedAlgae / 1000;
                $totalEarned = $harvestedAlgaeInKg * $game->production->algae_cost;

                // Add the earnings to the game's money
                $game->money += $totalEarned;
                $game->save();

                // Deduct the energy cost
                $game->mw -= $energyCost;
                $game->save();

                // Commit the transaction if everything is successful
                DB::commit();

                $message = "Harvested $harvestedAlgaeInKg KGs of algae and earned $$totalEarned";
                $this->addMessageToLog($game->id, $message);

            } catch (\Exception $e) {
                // Handle any exceptions and rollback the transaction if an error occurs
                DB::rollBack();

                $this->error('An error occurred during the algae harvest: ' . $e->getMessage());
            }
        }
    }
}
}
