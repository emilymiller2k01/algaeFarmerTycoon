<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'achievement',
        'completed',
    ];

    public function game(){
        return $this->belongsToMany(User::class, 'user_achievements')->withTimestamps();
    }
}
