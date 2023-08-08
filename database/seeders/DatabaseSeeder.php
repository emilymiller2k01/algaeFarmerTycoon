<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = \App\Models\User::create([
            'name' => 'Em Miller',
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $game = \App\Models\Game::create([
            'name' => 'game1',
            'mw' => 10,
            'mw_cost' => 10,
            'money' => 1000,
            'user_id' => $user->id,
        ]);

        $farm = \App\Models\Farm::create([
            'game_id' => $game->id,
            'total_biomass' => 100,
            'lux' => 30,
            'temp' => 20,
            'mw' => 2,
        ]);

        $achievement = \App\Models\Achievement::create([
            'achievement' => 'congrats',
        ]);

        \App\Models\UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
        ]);

        $light1 = \App\Models\Light::create([
            'type' => 'led',
            'cost' => 10,
            'mw' => 2,
            'lux' => 20
        ]);

        $light2 = \App\Models\Light::create([
            'type' => 'florescent',
            'cost' => 5,
            'mw' => 4,
            'lux'=> 10
        ]);

        \App\Models\FarmLight::create([
            'farm_id'=>$farm->id,
            'light_id'=>$light1->id
        ]);

        \App\Models\FarmLight::create([
            'farm_id'=>$farm->id,
            'light_id'=>$light2->id
        ]);

        $action = \App\Models\Action::create([
            'type' => 'mw',
            'perc' => 0.5,
        ]);

        $messageLog = \App\Models\MessageLog::create([
            'message' => 'photosynthesis'
        ]);

        \App\Models\MessageLogActions::create([
            'message_id'=>$messageLog->id,
            'action_id'=>$action->id,
        ]);

        \App\Models\GameMessageLog::create([
            'game_id'=>$game->id,
            'message_id'=>$messageLog->id,
        ]);

        $tank =\App\Models\Tank::create([
            'farm_id'=>$farm->id,
            'nutrient_level'=>0,
            'co2_level'=>0,
            'biomass'=>0,
            'mw'=>1,
        ]);

        $tank2 =\App\Models\Tank::create([
            'farm_id'=>$farm->id,
            'nutrient_level'=>0,
            'co2_level'=>0,
            'biomass'=>0,
            'mw'=>1,
        ]);

        $researchTasks = \App\Models\ResearchTasks::create([
            'task' => 'grow',
            'completed' => false,
            'automation' => false,
            'mw' => 0,
        ]);

        \App\Models\GameResearchTasks::create([
            'game_id'=>$game->id,
            'research_tasks_id'=>$researchTasks->id,
        ]);

        $settings = \App\Models\Settings::create([
            'text_size'=>'small',
            'theme'=>'dark'
        ]);

        \App\Models\UserSettings::create([
            'user_id'=>$user->id,
            'settings_id'=>$settings->id,
        ]);

        $refinery1 = \App\Models\Refinery::create([
            'produce' => 'biofuel',
            'mw'=>2,
        ]);

        \App\Models\FarmRefinery::create([
            'farm_id' => $farm->id,
            'refinery_id' =>$refinery1->id,
        ]);

        $refinery2 = \App\Models\Refinery::create([
            'produce' => 'food',
            'mw'=>1,
        ]);

        \App\Models\FarmRefinery::create([
            'farm_id' => $farm->id,
            'refinery_id' =>$refinery2->id,
        ]);

        $refinery3 = \App\Models\Refinery::create([
            'produce' => 'fertiliser',
            'mw'=>3,
        ]);

        \App\Models\FarmRefinery::create([
            'farm_id' => $farm->id,
            'refinery_id' =>$refinery3->id,
        ]);

        $refinery4 = \App\Models\Refinery::create([
            'produce' => 'antioxidants',
            'mw'=>5,
        ]);

        \App\Models\FarmRefinery::create([
            'farm_id' => $farm->id,
            'refinery_id' =>$refinery4->id,
        ]);


        $solar = \App\Models\Power::create([
            'type' => 'solar',
            'startup_cost' => 1000,  // your desired startup cost for solar
            'mw' => 5,  // your desired MW for solar
        ]);

        $wind = \App\Models\Power::create([
            'type' => 'wind',
            'startup_cost' => 1500,  // your desired startup cost for wind
            'mw' => 10,  // your desired MW for wind
        ]);

        $gas = \App\Models\Power::create([
            'type' => 'gas',
            'ongoing_cost' => 10,  // your desired ongoing cost for gas
            'mw' => 15,  // your desired MW for gas
        ]);

        \App\Models\FarmPower::create([
            'farm_id'=>$farm->id,
            'power_id'=>$solar->id,
        ]);

        \App\Models\FarmPower::create([
            'farm_id'=>$farm->id,
            'power_id'=>$wind->id,
        ]);

        \App\Models\FarmPower::create([
            'farm_id'=>$farm->id,
            'power_id'=>$gas->id,
        ]);
    }
}
