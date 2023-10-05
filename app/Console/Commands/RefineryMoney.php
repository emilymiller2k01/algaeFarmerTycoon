<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefineryMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refinery-money';

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
        //get all the refineries associated to the game 
        //each refinery produces a base amount of money 
        //it is multiplied by the type of byproduct (if availible)
        //this happens every 15s
    }
}
