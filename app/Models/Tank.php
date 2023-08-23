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
        'capacity' => 1000, // Example capacity in grams
    ];

    public function farms()
    {
        return $this->belongsTo(Farm::class);
    }

    // Calculate and update tank metrics
    public function calculateMetrics()
    {
        // Access the associated farm to get lux and temperature values
        $farm = $this->farm;

        if (!$farm) {
            return; // Make sure the tank is associated with a farm
        }

        // Calculate percentage mass capacity
        $percentageMassCapacity = ($this->biomass / $this->capacity) * 100;

        // Calculate growth rate of algae using farm-specific lux and temperature
        $growthRate = ($this->co2_level * $this->nutrient_level * $farm->lux * $farm->temperature) / 1000;
        $growthRate = $growthRate * (1 - $percentageMassCapacity / 100);

        // Calculate total mass of algae in the tank
        $totalAlgaeMass = $this->biomass + $growthRate;

        // Calculate co2 reduction rate
        $co2ReductionRate = $growthRate * 0.2; // Example reduction rate

        // Update tank attributes
        $this->biomass = $totalAlgaeMass;
        $this->co2_level -= $co2ReductionRate;

        // Calculate co2 percentage in the tank
        $co2Percentage = ($this->co2_level / 100) * 100; // Assume co2_level is already in percentage

        // Calculate nutrient reduction rate
        $nutrientReductionRate = $growthRate * 0.1; // Example reduction rate

        // Update tank attributes
        $this->nutrient_level -= $nutrientReductionRate;

        // Calculate nutrient percentage in the tank
        $nutrientPercentage = ($this->nutrient_level / 100) * 100; // Assume nutrient_level is already in percentage

        // Save tank changes
        $this->save();
    }
}
