<?php

use App\Http\Controllers\Api\AutomationController;
use App\Http\Controllers\Api\EnergyController;
use App\Http\Controllers\Api\Expansions;
use App\Http\Controllers\Api\ResearchTaskController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return Inertia::render('Landing');
})->name('landing');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Game
    Route::get('/game', function () {
        return Inertia::render('Game', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });
    Route::get('/game', [GameController::class, 'create']);
    Route::get('/game/{game}', [GameController::class, 'show'])->name('games.show');
    Route::post('/game', [GameController::class, 'store']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/algae/{farm_id}', [\App\Http\Controllers\AlgaeViewController::class, 'index']);
Route::get('/game/{game_id}/production', [\App\Http\Controllers\Api\Production::class, 'index']);
Route::get('/game/{game_id}/farm/list', [\App\Http\Controllers\Api\FarmSelection::class, 'getFarms']);
Route::post('/game/{game_id}/farms', [Expansions::class, 'addFarm']);
Route::post('/game/{game_id}/farm/{farm_id}/addTank', [Expansions::class, 'addFarmTank']);
Route::post('/game/{game_id}/farm/{farm_id}/light', [Expansions::class, 'addLight']);
Route::post('/game/{game_id}/farm/{farm_id}/farmNutrients', [Expansions::class, 'addFarmNutrients']);
Route::post('/game/{game_id}/farm/{farm_id}/refinery', [Expansions::class, 'addRefinery']);
Route::get('/game/{game_id}/farm/{farm_id}/harvestAlgae', [Expansions::class, 'harvestFarmAlgae']);
Route::post('/game/{game_id}/farm/{farm_id}/farmCo2', [Expansions::class, 'addFarmCo2']);
Route::post('/game/{game_id}/farm/{farm_id}/tank/{tank_id}/harvestTank', [\App\Http\Controllers\Api\TankController::class, 'harvestAlgae']);
Route::post('/game/{game_id}/farm/{farm_id}/tank/{tank_id}/max-out-nutrients', [\App\Http\Controllers\Api\TankController::class, 'maxOutNutrients']);
Route::post('/game/{game_id}/farm/{farm_id}/tank/{tank_id}/max-out-co2', [\App\Http\Controllers\Api\TankController::class, 'maxOutCO2']);
Route::post('/game/{game_id}/select-farm', [App\Http\Controllers\Api\FarmSelection::class, 'selectFarm']);
Route::patch('/game/{game_id}/farm/{farm_id}/refinery/{refinery_id}/produce', [App\Http\Controllers\Api\RefineryController::class, 'updateRefineryProduct']);
Route::patch('/game/{game_id}/farm/{farm_id}/increaseTemp', [Expansions::class, 'incrementTemperature']);
Route::patch('/game/{game_id}/farm/{farm_id}/decreaseTemp', [Expansions::class, 'decrementTemperature']);
Route::post('/game/{game_id}/increase-mw', [App\Http\Controllers\Api\EnergyController::class, 'increaseMW']);
Route::post('/game/{game_id}/decrease-mw', [App\Http\Controllers\Api\EnergyController::class, 'decreaseMW']);
Route::post('/game/{game_id}/farm/{farm_id}/purchaseEnergy', [EnergyController::class, 'purchaseEnergy']);
Route::get('/research-tasks/completed', [ResearchTaskController::class, 'showCompletedTasks'])->name('research-tasks.completed');
Route::post('/research-tasks/{taskId}/complete', [ResearchTaskController::class, 'completeTask'])->name('research-tasks.complete');
Route::get('/research-tasks/automation/completed', [AutomationController::class, 'showCompletedAutomationTasks'])->name('research-tasks.automation.completed');


require __DIR__.'/auth.php';
