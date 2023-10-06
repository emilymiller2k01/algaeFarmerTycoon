<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Farm;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class RefineryMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refinery-money {game_id}';

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
        $i = 0;
        while ($i<4){
            $game_id = $this->argument('game_id');
            $game = Game::findOrFail($game_id);
            $refineries = $game->getRefineries();
            $byproducts = $game->byProducts();

            $num_rs = count($refineries);
            
            $byproducts = $game->byproducts()
            ->selectRaw('SUM(biofuel) as biofuel_sum, SUM(antioxidants) as antioxidants_sum, SUM(food) as food_sum, SUM(fertiliser) as fertiliser_sum')
            ->groupBy('game_id')
            ->first();

            // Access the sums for each field
            $biofuelCount = $byproducts->biofuel_sum;
            $antioxidantsCount = $byproducts->antioxidants_sum;
            $foodCount = $byproducts->food_sum;
            $fertiliserCount = $byproducts->fertiliser_sum;
            
            $money = (15 * $num_rs) + ($biofuelCount * 10) + ($antioxidantsCount * 25) + ($foodCount * 5) + ($fertiliserCount * 15);
            $algae_use = (50 * $num_rs) + ($biofuelCount * 25) + ($antioxidantsCount * 100) + ($foodCount * 10) + ($fertiliserCount * 50);

            $farms = $game->farms;
            $farm_count = count($farms->all());

            $algae_per_farm = $algae_use / $farm_count;

            foreach ($farms as $farm){
                $farm->total_biomass -= $algae_per_farm;
                $farm->save();
            }

            $game->money -= $money;

            $game->save();
            $i++;
            sleep(15);
        }
    }
}
