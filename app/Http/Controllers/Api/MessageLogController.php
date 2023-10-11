<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\MessageLog; // Import the MessageLog model

class MessageLogController extends Controller
{
    public function showLatest()
    {
        $messages = MessageLog::where('cleared', 0)->latest()->get(); // Use latest() to get the newest messages first
        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function addMessage(Request $request)
    {
        // Validate the request data (you can customize the validation rules)
        $validatedData = $request->validate([
            'text' => 'required|string',
            'action' => 'required|string',
        ]);

        // Create a new message log entry
        $message = new MessageLog;
        $message->text = $validatedData['text'];
        $message->action = $validatedData['action'];
        $message->cleared = 0; // Message is not cleared
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message added successfully',
            'data' => $message, // Include the created message in the response
        ]);
    }


    public function clearAll($game_id)
    {
        $game = Game::findOrFail($game_id);
        MessageLog::where('game_id', $game_id)->where('cleared', 0)->update(['cleared' => 1]);
        $game->save();       
    }
}
