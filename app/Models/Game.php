<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mw',
        'money',
        'mw_cost',
        'user_id',
        'selected_farm_id',


    ];

    public function farms(){
        return $this->hasMany(Farm::class);
    }

    public function production(){
        return $this->hasOne(Production::class);
    }

    public function selectedFarm()
    {
        return $this->belongsTo(Farm::class, 'selected_farm_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function researchTasks(){
        return $this->belongsToMany(ResearchTasks::class, 'game_research_tasks');
    }

    public function messageLog(){
        return $this->belongsToMany(MessageLog::class, 'game_message_log');
    }

    public function getFarms(){
        $farms = $this->farms;


        $this->farmIds = $farms->map(function ($farm){
            return $farm->only('id');
        });
    }


}
