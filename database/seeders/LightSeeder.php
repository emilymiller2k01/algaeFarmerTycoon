<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('lights')->insert([
            ['type' => 'florescent', 'cost' => 10, 'mw' => 1, 'lux' => 30],
            ['type' => 'led', 'cost' => 20, 'mw' => 0.5 , 'lux' => 40],
            // ... add more light types as needed
        ]);
    }

}
