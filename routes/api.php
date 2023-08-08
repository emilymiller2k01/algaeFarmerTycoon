<?php

use App\Http\Controllers\Api\AutomationController;
use App\Http\Controllers\Api\EnergyController;
use App\Http\Controllers\Api\Expansions;
use App\Http\Controllers\Api\ResearchTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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


