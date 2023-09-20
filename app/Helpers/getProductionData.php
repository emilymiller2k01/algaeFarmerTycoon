<?php

use App\Models\Farm;
use App\Models\Game;

if (! function_exists('getProductionData')){
    function getProductionData(Game $game) {

    //only want to run this bit when the selected_farm_id of the game is changed ideally 

        $selectedFarmId = $game->selected_farm_id;
        $selectedFarm = Farm::findOrFail($selectedFarmId);
        $luxForSelectedFarm = $selectedFarm->lux;
        $tempForSelectedFarm = $selectedFarm->temp;

        //$algaeHarvest = 2;

        //$moneyRate = $algaeHarvest * 10;
        //$moneyRate = 1;

        $productionMetrics = calculateProductionMetrics($game);

        $averageAlgaeRate = $productionMetrics['algaeRate'];
        $biomass = $productionMetrics['biomass'];
        $nutrientsAmount =($productionMetrics['nutrientsAmount']);
        $nutrientsRate = $productionMetrics['nutrientsRate'];
        $co2Amount = $productionMetrics['co2Amount'];
        $co2Rate = $productionMetrics['co2Rate'];
        $gr = $productionMetrics['gr'];


        return [
            "moneyRate" => 1,
            "algaeRate" => $averageAlgaeRate,
            "algaeMass" => $biomass,
            "algaeHarvest" => 10,
            "gr" => $gr,
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

if (!function_exists('calculateProductionMetrics')) {
    function calculateProductionMetrics($game)
    {
        $tankCount = getTankCount($game);

        $tankMetrics = calculateTankMetrics($game->farms);

        $nutrientsAmount = 0;
        $nutrientsRate = 0;
        $co2Amount = 0;
        $co2Rate = 0;
        $algaeRate = 0;
        $biomass = 0;
        $gr = 0;

        foreach($tankMetrics as $metric){
            $biomass += $metric['biomass'];
            $algaeRate += $metric['algaeRate'];
            $nutrientsAmount += $metric['nutrientLevel'];
            $nutrientsRate += $metric['nutrientRate'];
            $co2Rate += $metric['co2Rate'];
            $co2Amount += $metric['co2Level'];
            $gr = $metric['gr'];
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
            'gr' => $gr,
            'nutrientsAmount' => $nutrientsAmount / $tankCount,
            'nutrientsRate' => $nutrientsRate / $tankCount,
            'co2Amount' => $co2Amount / $tankCount,
            'co2Rate' => $co2Rate / $tankCount,
            'algaeRate' => $algaeRate / $tankCount,
            'biomass' => $biomass,
        ];
    }
}
