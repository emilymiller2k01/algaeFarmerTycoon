<?php

use App\Models\Game;
use App\Models\ResearchTasks;

if (! function_exists('createAndAssignResearchTasks')){
    function createAndAssignResearchTasks(Game $game)
    {
        $researchTasks = [
            [
                'title' => 'Automated Harvesting System',
                'task' => 'By successfully implementing an automated harvesting system, you can now enjoy increased efficiency in your farm operations. This advanced technology streamlines the harvesting process, saving you valuable time and resources.',
                'completed' => false,
                'automation' => true,
                'cost' => 75,
                'mw' => 0.5,
            ],
            [
                'title' => 'Automated Nutrient Management',
                'task' => 'With the successful implementation of automated nutrient management, you can experience enhanced efficiency in your farm operations. This technology ensures optimal nutrient levels for your algae, leading to improved growth and higher yields.',
                'completed' => false,
                'automation' => true,
                'cost' => 75,
                'mw' => 0.5,
            ],
            [
                'title' => 'Heaters',
                'task' => 'With implementation of heaters you can consistently keep the tank temperature constant. This technology increases algae growth, however it requires electricity to be able to work.',
                'completed' => false,
                'automation' => true,
                'cost' => 25,
                'mw' => 0.5,
            ],
            [
                'title' => 'Vertical Farming',
                'task' => 'Unlock the potential of vertical farming, a groundbreaking innovation that allows you to double the tank capacity of each farm. This expansion enables you to cultivate a greater quantity of algae and increase your overall production capabilities.',
                'completed' => false,
                'automation' => false,
                'cost' => 200,
                'mw' => 0,
            ],
            [
                'title' => 'Renewable Energies',
                'task' => "Embrace renewable energy sources such as solar and wind power to fuel your farm operations. By harnessing these sustainable energy options, you can reduce your environmental impact and enhance your farm's sustainability.",
                'completed' => false,
                'automation' => false,
                'cost' => 25,
                'mw' => 0,
            ],
            [
                'title' => 'Bubble Technology',
                'task' =>"Introduce bubble technology to your farm, optimising gas supply and creating an ideal environment for algae growth. This innovation enhances productivity and supports the health and vitality of your algae culture.",
                'completed' => false,
                'automation' => false,
                'cost' => 45,
                'mw' => 0.5,
            ],
            [
                'title' => 'CO2 Management System',
                'task' =>"Implement an advanced CO2 management system to regulate and optimise carbon dioxide levels in your algae farm. This technology allows for precise control over CO2 supplementation, ensuring that your algae receive the ideal amount for maximum growth and productivity.",
                'completed' => false,
                'automation' => true,
                'cost' => 75,
                'mw' => 0.5,
            ],
            [
                'title' => 'Sensor Technology',
                'task' =>"Implement sensors into your tanks for accurate measurements of algae concentration, nutrients and CO2, reducing wastage of nutrients and CO2.",
                'completed' => false,
                'automation' => false,
                'cost' => 100,
                'mw' => 0,
            ],
            [
                'title' => 'Algae By-products',
                'task' =>"Learn how to refine and produce different algae by-products for increased revenue.",
                'completed' => false,
                'automation' => false,
                'cost' => 100,
                'mw' => 0,
            ],
            [
                'title' => 'Adding Refineries',
                'task' =>"Upgrade your farm to incorporate refineries to make algae by-products.",
                'completed' => false,
                'automation' => false,
                'cost' => 150,
                'mw' => 0,
            ],
            ];

        foreach ($researchTasks as $taskData) {
            $researchTask = new ResearchTasks;
            $researchTask->game_id = $game->id;
            $researchTask->fill($taskData);
            $researchTask->save();
        }
    }
}
