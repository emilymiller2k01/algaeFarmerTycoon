<?php

use App\Models\Farm;

if (!function_exists('automatedNutrientRegulator')){
    function automatedNutrientRegulator($game){
        $farms = $this->farms()->with('tanks')->get();

        foreach ($farms as $farm) {
            foreach ($farm->tanks as $tank) {
                $currentNutrientLevel = $tank->nutrient_level;
                $desiredNutrientLevel = 0.9; // 90% of tank capacity

                if ($currentNutrientLevel < $desiredNutrientLevel) {
                    // Calculate the amount of nutrients needed to reach desired level
                    $nutrientsToAdd = $desiredNutrientLevel - $currentNutrientLevel;

                    // Add nutrients to the tank
                    $tank->nutrient_level += $nutrientsToAdd;

                    // Ensure nutrient level doesn't exceed tank capacity
                    if ($tank->nutrient_level > 100) {
                        $tank->nutrient_level = 100;
                    }

                    $tank->save();
                }
            }
        }
    }
}

if (!function_exists('automatedCo2Regulator')){
    function automationCo2Regulator($game){
        $farms = $game->farms()->with('tanks')->get();

        foreach ($farms as $farm) {
            foreach ($farm->tanks as $tank) {
                $currentLevel = $tank->co2_level;
                $desiredLevel = 0.9; // 90% of tank capacity

                if ($currentLevel < $desiredLevel) {
                    // Calculate the amount of nutrients needed to reach desired level
                    $nutrientsToAdd = $desiredNutrientLevel - $currentNutrientLevel;

                    // Add nutrients to the tank
                    $tank->nutrient_level += $nutrientsToAdd;

                    // Ensure nutrient level doesn't exceed tank capacity
                    if ($tank->nutrient_level > 100) {
                        $tank->nutrient_level = 100;
                    }

                    $tank->save();
                }
            }
        }
    }
}

if (!function_exists('automatedHarvesting')){
    function automatedHarvesting($game){
        //todo figure out how to run this automatically every second 

        $tanks = $game->farms->flatMap(function ($farm) {
            return $farm->tanks;
        });

        foreach ($tanks as $tank) {
            $harvestedAlgae = $tank->biomass * 0.9; // 90% of the algae
            $totalHarvestedAlgae += $harvestedAlgae;

            // Convert grams to kilograms and calculate earnings
            $harvestedAlgaeInKg = $harvestedAlgae / 1000;
            $totalEarned += $harvestedAlgaeInKg * 30; // £30 per kg

            // Update tank biomass
            $tank->biomass *= 0.05; // Remaining 5%
            $tank->save();

            // Add updated tank to the list
            $updatedTanks[] = $tank;
        }

        // Add earnings to game money
        $game = $farm->game;
        $game->increment('money', $totalEarned);
    }
}