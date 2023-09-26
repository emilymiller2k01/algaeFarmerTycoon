<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Byproducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id', 
        'biofuel',
        'antioxidants',
        'food',
        'fertiliser',
    ];

    // Define an inverse one-to-one relationship with Game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
