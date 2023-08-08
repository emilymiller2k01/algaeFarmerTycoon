<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refinery extends Model
{
    use HasFactory;

    protected $fillable = [
        'produce',
        'mw',
    ];

    public function farms(){
        return $this->belongsToMany(Farm::class, 'farm_refineries');
    }
}
