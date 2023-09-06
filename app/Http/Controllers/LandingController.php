<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return inertia('Landing', ['auth' => null, 'games' => []]);
        }
    
        $games = $user->games->toArray();

        if (!$games) {
            return inertia('Landing', ['auth' => $user, 'games' => []]);
        }
        $games = $user->games;

        $games->map(function ($game) {
            $game->length = $game->length;
        });

        return inertia('Landing', ['auth' => $user, 'games' => $games]);
    }
}
