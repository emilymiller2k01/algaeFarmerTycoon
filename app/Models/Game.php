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

    public function researchTasks()
    {
        return $this->hasMany(ResearchTasks::class);
    }

    public function messageLog(){
        return $this->hasMany(MessageLog::class);
    }

    public function getFarms(){
        $farms = $this->farms;


        $this->farmIds = $farms->map(function ($farm){
            return $farm->only('id');
        });
    }

    public function byproducts()
    {
        return $this->hasOne(Byproducts::class);
    }

    public function addMessageToLog($message)
    {
        // Create a new message log entry
        $messageLog = new MessageLog([
            'game_id' => $this->id,
            'message' => $message,
            'cleared' => 0, 
            'action' => null,// Message is not cleared
        ]);

        $messageLog->save();

        return $messageLog;
    }

    public function getPowers(){
        $farms = $this->farms;
        $powers = [];
        foreach ($farms as $farm){
            $powers = array_merge($powers,( $farm->powers)->all());
        }
        return $powers;
    }

}
