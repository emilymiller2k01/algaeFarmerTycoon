<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Light extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'cost',
        'lux',
        'mw'
    ];

    public $timestamps = false;

    public function farms(){
        return $this->belongsToMany(Farm::class, 'farm_lights');
    }
}
