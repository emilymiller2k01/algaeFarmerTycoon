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

        return inertia('Dashboard', ['auth' => $user, 'games' => $games]);
    }
}
