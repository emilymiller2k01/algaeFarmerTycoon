<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    //display a listing of the resource
    public function index($user_id) {
        $user = User::find($user_id);
        $games = $user->games;

        return Inertia::render('User/List', [
            'games' => $games,
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        if (!$user) {
            // Handle unauthenticated users, maybe redirect to the login page?
            return redirect()->route('login');
        }

        $games = $user->games;

        return inertia('Dashboard', ['games' => $games]);
    }


    //create a new game
    public function create(){
        return Inertia::render('Game/Create');
    }

    //store the newly created game
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        // Create the new game
        $game = new Game;
        $game->name = $validated['name'];
        $game->user_id = $validated['user_id'];
        $game->mw = 0;
        $game->save();

        // Return a response or redirect
        return redirect()->route('games.show', ['game' => $game->id]);
    }


    //show a game
    public function show(Game $game){
        $this->authorize('view', $game);
        return Inertia::render('Home', ['game' => $game]);
    }

    //show the form for editing the game name
    public function editName(Game $game){
        return Inertia::render('Game/Edit', ['game' => $game]);
    }

    //update the specific game in storage
    public function updateGame(Request $request, Game $game){
        $this->authorize('update', $game);
        $game->update(
            $request->validate(
                ['name' => ['required', 'max:12'],]
        ));
        return Redirect::back();
    }

    public function removeGame(Game $game){

        $this->authorize('delete', $game);
        $game->delete();

        return redirect::back();
    }

}