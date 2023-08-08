<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function completeAchievement($user_id, $achievement_id){
        try {
            $user = User::findOrFail($user_id);
            $achievement = Achievement::findOrFail($achievement_id);

            //TODO check if achievment is not completed
            //TODO check if achievment hasnt been achieved by the user
            //TODO update the view to show the achievement

        } catch (ModelNotFoundException $e) {
            return response("Game Not Found", 404);
        } catch (Exception $e){
            return response('Internal Server Error', 500);
        }
    }

    public function showAchievements($user_id){
        $user = User::with('achievements')->findOrFail($user_id);
        return view('achievements.index', ['user' => $user]);
    }
}
