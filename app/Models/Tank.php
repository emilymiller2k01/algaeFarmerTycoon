<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'nutrient_level',
        'co2_level',
        'biomass',
        'capacity',
        'mw'
    ];

    public function farms()
    {
        return $this->belongsTo(Farm::class);
    }

    // Calculate and update tank metrics
    public function calculateMetrics()
    {
        $this->nutrient_level = intval($this->nutrient_level);
        $this->co2_level = intval($this->co2_level);
        // Access the associated farm to get lux and temperature values
        $farm = Farm::findOrFail($this->farm_id);
        $game = $farm->game;
        $production = $game->production;
        //calculate temp growth rate 
        $temp_gr = (1 - (($farm->temp -25)^2)/7) *(exp(1))^(0.001*$farm->temp);
        //calculate nutrient growth rate 
        $nutrient_gr = ($this->nutrient_level)/((($this->nutrient_level)^2)*0.5 + ($this->nutrient_level) + 0.5);
        //calculate co2 growth rate 
        $co2_gr = ($this->co2_level)/((($this->co2_level)^2)*0.5 + $this->co2_level + 0.5);
        //calculate light growth rate 
        $light_gr = (0.9*($farm->lux)/100)/(0.5 + ($farm->lux)/100);
        //calculating average growth rate 
        $gr = ($production->gr_multiplier * ($temp_gr + $nutrient_gr + $co2_gr + $light_gr) *(($this->capacity - $this->biomass)/($this->capacity)))/40;
        //calculating capacity 
        $b_1 = (1+$gr) * ($this->biomass); //*(($this->capacity - $this->biomass)/($this->capacity));
        $algaeProductionRate = ((($b_1 - $this->biomass)/$b_1)*100);
        $this->biomass = $b_1;

        $co2ReductionRate = $this->co2_level != 0 ? -(($this->co2_level - ($this->co2_level - ($this->biomass * 0.001))) / $this->co2_level) : 0;
        $nutrientReductionRate = $this->nutrient_level != 0 ? -(($this->nutrient_level - ($this->nutrient_level - ($this->biomass * 0.002))) / $this->nutrient_level) : 0;

        $newNutrientLevel = $this->nutrient_level - ($this->biomass * 0.002);
        $newCo2Level = $this->co2_level - ($this->biomass * 0.001);
    
        // Check if the new values are negative, and if so, set them to zero
        $newNutrientLevel = max(0, $newNutrientLevel);
        $newCo2Level = max(0, $newCo2Level);
    
        // Update the nutrient_level and co2_level
        $this->nutrient_level = $newNutrientLevel;
        $this->co2_level = $newCo2Level;

        // Save tank changes
        $this->save();

        return [
            'gr' => $gr,
            'biomass' => $this->biomass,
            'algaeRate' => $algaeProductionRate,
            'co2Rate' => $co2ReductionRate,
            'co2Level' => $this->co2_level,
            'nutrientRate' => $nutrientReductionRate,
            'nutrientLevel' => $this->nutrient_level,
        ];
    }
}
