<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateProductionData; // Import the custom command
use App\Models\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CheckAlgaeBiomass::class,
        \App\Console\Commands\CheckTankCO2::class, 
        \App\Console\Commands\CheckTankNutrients::class,
        \App\Console\Commands\GasMoney::class
        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $users = User::with('games')->get();

    // Iterate through each user
    foreach ($users as $user) {
        // Iterate through each user's game
        foreach ($user->games as $game) {
            $gameId = $game->id;
            $schedule->command('biomass:check', [$gameId])->everyMinute()->withoutOverlapping();  
            $schedule->command('tank:check-nutrients', [$gameId])->everyMinute()->withoutOverlapping();
            $schedule->command('tank:check-co2', [$gameId])->everyMinute()->withoutOverlapping();
            $schedule->command('gas:money', [$gameId])->everyMinute()->withoutOverlapping();
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
