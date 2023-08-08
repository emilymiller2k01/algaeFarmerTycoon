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
        'mw'
    ];

    public function farms(){
        return $this->belongsTo(Farm::class);
    }
}
