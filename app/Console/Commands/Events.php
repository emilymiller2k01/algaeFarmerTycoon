<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;

class Events extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:events {game_id} ';

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
        $events = [
        [
            'id' => 1,
            'task' => 'Winter has arrived and bought with it cooler temperatures and less sun, so energy prices increase and sunlight is less effective.'
        ],
        [
            'id' => 2,
            'task' => 'Summer has arrived and bought with it hotter temperatures and more sun, so energy prices have decreased and sunlight is more effective.'
        ],
        [
            'id' => 3,
            'task' => 'Algae Bloom: A sudden algae bloom has occurred in your farm, increasing your algae production by 20% temporarily.'
        ],
        [
            'id' => 4,
            'task' => 'Pest Infestation: Oh no! Your farm has been infested by algae-eating pests. Take immediate action to mitigate the damage and protect your crop!'
        ],
        [
            'id' => 5,
            'task' => 'Market Demand Surge: There is a high demand for algae-based products in the market! Algae is selling for an extra 15%!'
        ],
        [
            'id' => 6,
            'task' => 'Research Breakthrough: Congratulations! Your research team has made a breakthrough in algae strain development, leading to an increase in algae quality.'
        ],
        [
            'id' => 7,
            'task' => 'Industry Recognition: Your algae farm has been recognized as a leader in sustainable agriculture. Congratulations on your contribution to environmental stewardship!'
        ],
        [
            'id' => 8,
            'task' => 'Supply Shortage: Due to unforeseen circumstances, there is a temporary shortage of essential nutrients for your algae. Prices have increased temporarily.'
        ],
        [
            'id' => 9,
            'task' => 'Supply Shortage: Due to unforeseen circumstances, there is a temporary shortage of carbon dioxide for your algae. Prices have increased temporarily.'
        ],
        ];
        
        $game = Game::findOrFail($game_id);
        $message_log = $game->messageLog;

        $task = rand(1, 9);

        // get the task message 

        // add the task to the message log associated with the game 

        // run the coressponding method 

    }

    
    public function task1($game, $task) {
        $game->mw_cost += 5;
        $farms = $game->farms;
        $game->addMessageToLog($task);

        for ($farms as $farm)
        {
            $farm->temp -= 3;
            $farm->save();
        }
        $game->save();
        
        sleep(20);
        $game->mw_cost -= 5;
        for ($farms as $farm){
            $farm->temp += 3;
            $farm->save();
        }
        $game->save(); 
    }

    public function task2($game, $task){
        $game->mw_cost -= 5;
        $farms = $game->farms;
        $game->addMessageToLog($task)

        for ($farms as $farm){
            $farm->temp += 3;
            $farm->save();
        }
        $game->save();
        
        sleep(20);
        $game->mw_cost += 5;
        for ($farms as $farm){
            $farm->temp -= 3;
            $farm->save();
        }
        $game->save(); 
    }

    public function task3($game, $task){
        $game->addMessageToLog($task);
        $prod = $game->production;
        $prod->gr_multiplier = $prod->gr_multiplier * 1.2;
        $prod->save();
        $game->save();
        sleep(20);
        $prod->gr_multiplier = $prod->gr_multiplier / 1.2;
        $prod->save();
        $game->save();
    }

    public function task4($game, $task){
        $game->addMessageToLog($task);
        $prod = $game->production;
        $prod->gr_multiplier = $prod->gr_multiplier * 0.75;
        $prod->save();
        $game->save();
        sleep(15);
        $prod->gr_multiplier = $prod->gr_multiplier / 0.75;
        $prod->save();
        $game->save();
    }

    public function task5($game, $task){
        $game->addMessageToLog($task);
        $prod = $game->production;
        $prod->algae_cost = $prod->algae_cost * 1.15;
        $prod->save();
        $game->save();
        sleep(20);
        $prod->algae_cost = $prod->algae_cost / 1.15;
        $prod->save();
        $game->save();
    }

}
