<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmPower extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'power_id',
    ];
}
