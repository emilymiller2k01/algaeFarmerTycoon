<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $games = $user->games;

        $games->map(function ($game) {
            $game->length = $game->length;
        });

        return inertia('Dashboard', ['auth' => $user, 'games' => $games]);
    }
}
