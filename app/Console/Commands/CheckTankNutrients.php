<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Farm;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class CheckTankNutrients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tank:check-nutrients {game_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tank nutrient levels and trigger addition if necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {  
        $gameId = $this->argument('game_id');
        $game = Game::findOrFail($gameId);
        
        $tanks = [];
        foreach ($game->farms as $farm) {
            $tanks = array_merge($tanks, ($farm->tanks)->all());
        }        
        $i = 0;
        while ($i<12){
            $i++;
            foreach ($tanks as $tank) {//HERE TODO 
                $this->addNutrients($tank, $game);
            }
            sleep(5);
        }
    }

    private function addNutrients($tank, $game)
    {
        if ($tank->nutrient_level < 10) {
            // Begin a database transaction to ensure consistency
           // DB::beginTransaction();

            try {
                // Harvest algae by setting biomass to 10% of capacity
                $tank->nutrient_level = 100;
                $tank->save();

                $game->money -= 50;

                // Commit the transaction if everything is successful
                //DB::commit();

                // Log the successful harvest
            } catch (\Exception $e) {
                // Handle any exceptions and rollback the transaction if an error occurs
                //DB::rollBack();

                // Log the error
                $this->error('An error occurred during nutrient management in tank ' . $tank->id . ': ' . $e->getMessage());
            }
        }
    }
}
