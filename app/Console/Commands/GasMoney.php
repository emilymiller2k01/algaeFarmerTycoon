<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class GasMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gas:money {game_id}';

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
        while ($i <4)
        
        {
            $game_id = $this->argument('game_id');
            $game = Game::findOrFail($game_id);
            $powers = $game->getPowers();
            $num_gas = 0;
            foreach ($powers as $power){
                if ($power->type === 'gas'){
                    $num_gas += 1;
                }
            }
            
            $game->money -= ($num_gas * $game->mw_cost);
            Log::info('gas cost ' . ($num_gas * $game->mw_cost));
            $i++;
            sleep(15);

        }


        //get the amount of gas used in the game 
        //every 20 take £XX for every gas in the game 
    }
}
