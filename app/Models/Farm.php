<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Game;
use App\Models\Tank;
use App\Models\Refinery;
use App\Models\Power;
use App\Models\Light;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'total_biomass',
        'lux',
        'temp',
        'mw'
    ];



    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function tanks(){
        return $this->hasMany(Tank::class);
    }

    public function refineries(){
        return $this->belongsToMany(Refinery::class, 'farm_refineries');
    }

    public function lights(){
        return $this->belongsToMany(Light::class, 'farm_lights');
    }

    public function powers(){
        return $this->belongsToMany(Power::class, 'farm_powers');
    }

    public function addGame(){
        $this->game = $this->game;
    }

    public function getTankIds(){
        $tanks = $this->tanks;

        $this->tankIds = $tanks->map(function($tank){
            return $tank->only('id');
        });
    }

    public function getRefineryIds(){
        $refineries = $this->refineries;

        $this->refineryIds = $refineries->map(function ($refinery){
            return $refinery->only('id');
        });
    }

    public function getLightIds(){
        $lights = $this->lights;


        $this->lightIds = $lights->map(function ($light){
            return $light->only('id');
        });
    }

    public function getPowerIds(){
        $powers = $this->powers;

        $this->powerIds = $powers->map(function ($power){
            return $power->only('id');
        });
    }

    protected static function booted()
    {
        static::created(function ($farm) {
            // Create a new tank when a farm is created
            $tank = new Tank([
            ]);
            $farm->tanks()->save($tank);
        });
    }

    public function getLightCounts()
    {
        $ledCount = $this->lights()->where('type', 'LED')->count();
        $fluorescentCount = $this->lights()->where('type', 'Fluorescent')->count();

        return [
            'led_count' => $ledCount,
            'fluorescent_count' => $fluorescentCount,
        ];
    }

}
