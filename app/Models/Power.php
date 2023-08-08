<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'startup_cost',
        'ongoing_cost',
        'mw',
    ];

    public function farms(){
        return $this->belongsToMany(Farm::class, 'farm_powers');
    }
}
