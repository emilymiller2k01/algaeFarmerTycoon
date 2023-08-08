<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_size',
        'theme',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'user_settings');
    }
}
