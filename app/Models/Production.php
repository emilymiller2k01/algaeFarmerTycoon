<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'co2_cost',
        'nutrient_cost',
        'algae_cost',
        'gr_multiplier',
    ];

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
