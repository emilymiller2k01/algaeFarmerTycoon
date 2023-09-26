<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Game;
use App\Models\Tank;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Helpers\getProductionData;
use App\Models\ResearchTasks;
use App\Events\ProductionDataUpdated;
use Illuminate\Support\Facades\Artisan;
use App\Models\Production;
use App\Models\Byproducts;


class GameController extends Controller
{

    
    //display a listing of the resource
    public function index($user_id) {
        $user = User::find($user_id);
        $games = $user->games;

        $games->map(function ($game) {
            $game->length = $game->length;
        });

        return Inertia::render('User/List', [
            'games' => $games,
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        if (!$user) {
            // Handle unauthenticated users by redirecting to the landing page
            return redirect()->route('landing');
        }

        $games = $user->games->toArray();

        return inertia('Landing', ['auth' => auth()->user(), 'games' => $games]);
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

        $researchTasks = [
        [
            'title' => 'Automated Harvesting System',
            'task' => 'By successfully implementing an automated harvesting system, you can now enjoy increased efficiency in your farm operations. This advanced technology streamlines the harvesting process, saving you valuable time and resources.',
            'completed' => false,
            'automation' => true,
            'cost' => 75,
            'mw' => 0.5,
        ],
        [
            'title' => 'Automated Nutrient Management',
            'task' => 'With the successful implementation of automated nutrient management, you can experience enhanced efficiency in your farm operations. This technology ensures optimal nutrient levels for your algae, leading to improved growth and higher yields.',
            'completed' => false,
            'automation' => true,
            'cost' => 75,
            'mw' => 0.5,
        ],
        [
            'title' => 'Heaters',
            'task' => 'With implementation of heaters you can consistently keep the tank temperature constant. This technology increases algae growth, however it requires electricity to be able to work.',
            'completed' => false,
            'automation' => true,
            'cost' => 25,
            'mw' => 0.5,
        ],
        [
            'title' => 'Vertical Farming',
            'task' => 'Unlock the potential of vertical farming, a groundbreaking innovation that allows you to double the tank capacity of each farm. This expansion enables you to cultivate a greater quantity of algae and increase your overall production capabilities.',
            'completed' => false,
            'automation' => false,
            'cost' => 200,
            'mw' => 0,
        ],
        [
            'title' => 'Renewable Energies',
            'task' => "Embrace renewable energy sources such as solar and wind power to fuel your farm operations. By harnessing these sustainable energy options, you can reduce your environmental impact and enhance your farm's sustainability.",
            'completed' => false,
            'automation' => false,
            'cost' => 25,
            'mw' => 0,
        ],
        [
            'title' => 'Bubble Technology',
            'task' =>"Introduce bubble technology to your farm, optimising gas supply and creating an ideal environment for algae growth. This innovation enhances productivity and supports the health and vitality of your algae culture.",
            'completed' => false,
            'automation' => false,
            'cost' => 45,
            'mw' => 0.5,
        ],
        [
            'title' => 'CO2 Management System',
            'task' =>"Implement an advanced CO2 management system to regulate and optimise carbon dioxide levels in your algae farm. This technology allows for precise control over CO2 supplementation, ensuring that your algae receive the ideal amount for maximum growth and productivity.",
            'completed' => false,
            'automation' => true,
            'cost' => 75,
            'mw' => 0.5,
        ],
        [
            'title' => 'Sensor Technology',
            'task' =>"Implement sensors into your tanks for accurate measurements of algae concentration, nutrients and CO2, reducing wastage of nutrients and CO2.",
            'completed' => false,
            'automation' => false,
            'cost' => 100,
            'mw' => 0,
        ],
        [
            'title' => 'Algae By-products',
            'task' =>"Learn how to refine and produce different algae by-products for increased revenue.",
            'completed' => false,
            'automation' => false,
            'cost' => 100,
            'mw' => 0,
        ],
        [
            'title' => 'Adding Refineries',
            'task' =>"Upgrade your farm to incorporate refineries to make algae by-products.",
            'completed' => false,
            'automation' => false,
            'cost' => 150,
            'mw' => 0,
        ],
        ];

        // Create the new game
        $game = new Game;
        $game->name = $validated['name'];
        $game->user_id = $validated['user_id'];
        $game->mw = 0;
        $game->save();

        $farm = new Farm;
        $farm->game_id = $game->id;
        $farm->save();

        // Set the newly created farm as the selected_farm_id for the game
        $game->selected_farm_id = $farm->id;
        $selectedFarm = Farm::findOrFail($game->selected_farm_id);
// Access the lux property of the selected farm
        $luxValue = $selectedFarm->lux;

        $production = new Production;
        $production->game_id = $game->id;

        foreach ($researchTasks as $taskData) {
            $researchTask = new ResearchTasks;
            $researchTask->game_id = $game->id;
            $researchTask->fill($taskData);
            $researchTask->save();
        }

        $byproducts = new Byproducts;
        $byproducts->game_id = $game->id;

        $byproducts->save();

        $production->save();

        $farm->save();
        
        $game->save();
        // Return a response or redirect
        return redirect()->route('games.show', ['game' => $game->id]);
    }

    //show a game
    public function show(Game $game)
    {
        dd("James like lesbians");
        $this->authorize('view', $game);
        $refineries = [];
        $powers = [];
        foreach ($game->farms as $farm) {
            $refineries = array_merge($refineries, $farm->refineries->toArray());
            $powers = array_merge($powers, $farm->powers->toArray());
        }
        
        // Call the helper function to get production data
        $productionData = getProductionData($game);

        dd($game->byproducts);

        return Inertia::render('Game', [
            'initialGame' => $game,
            'tanks' => $game->selectedFarm ? $game->selectedFarm->tanks : [],
            'farms' => $game->farms,
            'productionData' => $productionData,
            'researchTasks' => $game->researchTasks,
            'refineries' => $refineries,
            'powers' => $powers,
            'byProductAssignments' => $game->byproducts,
        ]);

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

    private function createAndAssignResearchTasks(Game $game)
    {
       

        foreach ($researchTasks as $taskData) {
            $researchTask = new ResearchTasks;
            $researchTask->game_id = $game->id;
            $researchTask->fill($taskData);
            $researchTask->save();
        }
    }
}
