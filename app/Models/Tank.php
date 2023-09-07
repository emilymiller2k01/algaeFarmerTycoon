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

    protected $attributes = [
        'capacity' => 1000,
        'nutrient_level' => 100,
        'co2_level' => 100,
        'biomass' => 0.1,
        'mw' => 1, 
    ];

    public function farms()
    {
        return $this->belongsTo(Farm::class);
    }

    // Calculate and update tank metrics
    public function calculateMetrics()
    {
        // Access the associated farm to get lux and temperature values
        $farm = Farm::findOrFail($this->farm_id);

        // Calculate percentage mass capacity
        $percentageMassCapacity = ($this->biomass / $this->capacity) * 100;

        // Calculate growth rate of algae using farm-specific lux and temperature
        $growthRate = (($farm->lux )/ 40) * (($farm->temp) / 40) * ($this->nutrient_level / 100) * ($this->co2_level);
        $growthRate = $growthRate * (1 - $percentageMassCapacity / 100);

        // Calculate total mass of algae in the tank
        $totalAlgaeMass = ($this->biomass + $growthRate);

        // Calculate co2 reduction rate
        $co2ReductionRate = -(($this->co2_level - ($this->biomass * 0.01 * $this->co2_level))/$this->co2_level); // Example reduction rate

        // Update tank attributes
        $this->biomass = $totalAlgaeMass;
        $this->co2_level += $co2ReductionRate;

        // Calculate nutrient reduction rate
        $nutrientReductionRate =  -($this->nutrient_level - ($this->nutrient_level *$this->biomass *0.01))/$this->nutrient_level; // Example reduction rate

        // Update tank attributes
        $this->nutrient_level += $nutrientReductionRate;

        

        // Save tank changes
        $this->save();

        return [
            'biomass' => $totalAlgaeMass,
            'co2Rate' => $co2ReductionRate,
            'co2Level' => $this->co2_level,
            'nutrientRate' => $nutrientReductionRate,
            'nutrientLevel' => $this->nutrient_level,
        ];
    }
}
