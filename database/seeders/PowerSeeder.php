<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('powers')->insert([
            ['type' => 'gas', 'startup_cost' => 0, 'ongoing_cost' => 1, 'mw' => 3],
            ['type' => 'solar', 'startup_cost' => 20, 'ongoing_cost' => 0, 'mw' => 5],
            ['type' => 'wind', 'startup_cost' => 20, 'ongoing_cost' => 0, 'mw' => 5], 
        ]);
    }

}
