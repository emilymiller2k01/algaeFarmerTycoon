<?php

use App\Models\Farm;

if (! function_exists('getProductionData')){
    function getProductionData($game) {

    //only want to run this bit when the selected_farm_id of the game is changed ideally 
        $selectedFarmId = $game->selected_farm_id;
        $selectedFarm = Farm::findOrFail($selectedFarmId);
        $luxForSelectedFarm = $selectedFarm->lux;
        $tempForSelectedFarm = $selectedFarm->temp;

        $algaeHarvest = 2;

        $moneyRate = $algaeHarvest * 10;

        calculateTankMetrics($game->farms);

        $productionMetrics = calculateProductionMetrics($game->farms);

        $averageAlgaeRate = $productionMetrics['algaeRate'];
        $nutrientsAmount = $productionMetrics['nutrientsAmount'];
        $nutrientsRate = $productionMetrics['nutrientsRate'];
        $co2Amount = $productionMetrics['co2Amount'];
        $co2Rate = $productionMetrics['co2Rate'];


        return [
            "currentMoney" => $game->money,
            "farmData" => $game->farms,
            "powerOutput" => 10,
            "moneyRate" => $moneyRate,
            "algaeRate" => $averageAlgaeRate,
            "algaeMass" => $game->farms->sum('total_biomass'),
            "algaeHarvest" => 10,
            "tanks" => getTankCount($game),
            "farms" => $game->farms->count(),
            "nutrientsAmount" => $nutrientsAmount,
            "nutrientsRate" => $nutrientsRate,
            "co2Amount" => $co2Amount,
            "co2Rate" => $co2Rate,
            "temperature" => $tempForSelectedFarm,
            "lux" => $luxForSelectedFarm,
        ];
    }
};
    
if (! function_exists('getTanksCount')) {
    function getTankCount($game){

        $tanksCount = 0;
        
        foreach ($game->farms as $farm) {
            $tanksCount += $farm->tanks->count();
        }

        return $tanksCount;
    }
};

if (! function_exists('calculateTankMetrics')){
    function calculateTankMetrics($farms) {
        foreach ($farms as $farm) {
            foreach ($farm->tanks as $tank) {
                $tank->calculateMetrics();
            }
        }
    }
}

if (!function_exists('calculateProductionMetrics')) {
    function calculateProductionMetrics($farms)
    {
        $totalNutrientsAmount = 0;
        $totalNutrientsRate = 0;
        $totalCO2Amount = 0;
        $totalCO2Rate = 0;
        $totalAlgaeRate = 0;
        $tankCount = 0;

        

        foreach ($farms as $farm) {
            foreach ($farm->tanks as $tank) {
                $tank->calculateMetrics(); // Update tank metrics first

                $percentageMassCapacity = ($tank->biomass / $tank->capacity) * 100;
                $growthRate = ($tank->co2_level * $tank->nutrient_level * $farm->lux * $farm->temperature) / 1000;
                $growthRate = $growthRate * (1 - $percentageMassCapacity / 100);

                // Calculate algae rate
                $algaeRate = $growthRate; // Modify this calculation as needed

                // Calculate nutrient amount and rate for each tank and accumulate
                $totalNutrientsAmount += $tank->nutrient_level * $algaeRate;
                $totalNutrientsRate += $algaeRate;

                // Calculate CO2 amount and rate for each tank and accumulate
                $totalCO2Amount += $tank->co2_level * $algaeRate;
                $totalCO2Rate += $algaeRate;

                // Accumulate algae rate
                $totalAlgaeRate += $algaeRate;

                $tankCount++;
            }
        }

        if ($tankCount === 0) {
            return [
                'nutrientsAmount' => 0,
                'nutrientsRate' => 0,
                'co2Amount' => 0,
                'co2Rate' => 0,
            ];
        }

        return [
            'nutrientsAmount' => $totalNutrientsAmount / $tankCount,
            'nutrientsRate' => $totalNutrientsRate / $tankCount,
            'co2Amount' => $totalCO2Amount / $tankCount,
            'co2Rate' => $totalCO2Rate / $tankCount,
            'algaeRate' => $totalAlgaeRate / $tankCount,
        ];
    }
}
