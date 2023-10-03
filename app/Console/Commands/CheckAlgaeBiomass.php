<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Farm;
use App\Models\Game;

class CheckAlgaeBiomass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biomass:check {tanks}';
    protected $description = 'Check algae biomass levels and trigger harvest if necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {  
        $tanks = $this->argument('tanks');
        $i = 0;
        while ($i<12){
            $i++;
            foreach ($tanks as $tank) {
                $this->harvestAlgae($tank);
            }
            Log::info('Code is running. Iteration ' . $i);
            sleep(5);
        }
    }

    private function harvestAlgae($tank)
    {       
        $farm = Farm::findOrFail($tank->farm);
        $game = Game::findOrFail($farm->game);
        $biomassPercentage = ($tank->biomass / $tank->capacity) * 100;

        if ($biomassPercentage > 90) {
            // Begin a database transaction to ensure consistency
            //DB::beginTransaction();

            try {
                // Harvest algae by setting biomass to 10% of capacity
                $harvested_algae = $tank->biomass - (($tank->biomass) - ($tank->capacity * 0.9));

                $tank->biomass = ($tank->biomass) - ($tank->capacity * 0.9);
                $tank->save();

                $game->money += ($harvested_algae * 40);

                $game->save();

                // Commit the transaction if everything is successful
                //DB::commit();

                // Log the successful harvest
                Log::info('Successfully harvested algae in tank ' . $tank->id);
                Log::info("Bosh");

            } catch (\Exception $e) {
                // Handle any exceptions and rollback the transaction if an error occurs
                //DB::rollBack();

                // Log the error
                Log::error('An error occurred during the algae harvest in tank ' . $tank->id . ': ' . $e->getMessage());
            }
        }
    }
}
