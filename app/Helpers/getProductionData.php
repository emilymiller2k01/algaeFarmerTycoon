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

        $productionMetrics = calculateProductionMetrics($game);

        $averageAlgaeRate = $productionMetrics['algaeRate'];
        $biomass = $productionMetrics['biomass'];
        $nutrientsAmount = $productionMetrics['nutrientsAmount'];
        $nutrientsRate = $productionMetrics['nutrientsRate'];
        $co2Amount = $productionMetrics['co2Amount'];
        $co2Rate = $productionMetrics['co2Rate'];


        return [
            "currentMoney" => $game->money,
            "farmData" => $game->farms,
            "moneyRate" => $moneyRate,
            "algaeRate" => $averageAlgaeRate,
            "algaeMass" => $biomass,
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
        $metrics = [];
        foreach ($farms as $farm) {
            foreach ($farm->tanks as $tank) {
                if ($tank->farms()) {
                
                    $metrics += [$tank->calculateMetrics()];
                }
            }
        }
        return $metrics;
    }
}



if (!function_exists('calculateAlgaeGrowthRate')) {
    function calculateAlgaeGrowthRate($tank, $farm)
    {
        $percentageMassCapacity = ($tank->biomass / $tank->capacity) * 100;

        // Calculate algae growth rate based on factors
        $growthRate = ($tank->co2_level / 100) * ($tank->nutrient_level / 100) * (50 / $farm->lux) * (30 / $farm->temp);
        $growthRate = $growthRate * (1 - $percentageMassCapacity / 100);

        return $growthRate;
    }
}

if (!function_exists('calculateProductionMetrics')) {
    function calculateProductionMetrics($game)
    {
    //    foreach ($farms as $farm) {
    //         foreach ($farm->tanks as $tank) {
    //             $algaeRate = calculateAlgaeGrowthRate($tank, $farm);

    //             // Calculate nutrient amount and rate for each tank and accumulate
    //             $totalNutrientsAmount += $tank->nutrient_level * $algaeRate;
    //             $totalNutrientsRate += $algaeRate;

    //             // Calculate CO2 amount and rate for each tank and accumulate
    //             $totalCO2Amount += $tank->co2_level * $algaeRate;
    //             $totalCO2Rate += $algaeRate;

    //             // Accumulate algae rate
    //             $totalAlgaeRate += $algaeRate;

    //             $tankCount++;
    //         }
    //     }

        $tankCount = getTankCount($game);

        $tankMetrics = calculateTankMetrics($game->farms);

        $nutrientsAmount = 100;
        $nutrientsRate = 0;
        $co2Amount = 100;
        $co2Rate = 0;
        $algaeRate = 0;
        $biomass = 0;

        foreach($tankMetrics as $metric){
            $biomass -= $metric['biomass'];
            $nutrientsAmount -= $metric['nutrientLevel'];
            $nutrientsRate -= $metric['nutrientRate'];
            $co2Rate -= $metric['co2Level'];
            $co2Amount -= $metric['co2Rate'];
        }


        if ($tankCount === 0) {
            return [
                'nutrientsAmount' => 0,
                'nutrientsRate' => 0,
                'co2Amount' => 0,
                'co2Rate' => 0,
                'algaeRate' => 0,
                'biomass' => 0,
            ];
        }

        return [
            'nutrientsAmount' => $nutrientsAmount / $tankCount,
            'nutrientsRate' => $nutrientsRate / $tankCount,
            'co2Amount' => $co2Amount / $tankCount,
            'co2Rate' => $co2Rate / $tankCount,
            'algaeRate' => $co2Amount / $tankCount,
            'biomass' => $biomass,
        ];
    }
}
