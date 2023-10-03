<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckTankCO2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tank:check-co2 {tanks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tank co2 levels and trigger addition if necessary';

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
                $this->addCO2($tank);
            }
            sleep(5);
        }
    }

    private function addCO2($tank)
    {
        if ($tank->co2_level < 10) {
            // Begin a database transaction to ensure consistency
           // DB::beginTransaction();

            try {
                // Harvest algae by setting biomass to 10% of capacity
                $tank->co2_level = 100;
                $tank->save();

                $game->money -= 50;

                // Commit the transaction if everything is successful
                //DB::commit();

                // Log the successful harvest
            } catch (\Exception $e) {
                // Handle any exceptions and rollback the transaction if an error occurs
                //DB::rollBack();

                // Log the error
                $this->error('An error occurred during co3 management in tank ' . $tank->id . ': ' . $e->getMessage());
            }
        }
    }
}
