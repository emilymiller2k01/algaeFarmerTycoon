<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageLog extends Controller
{

    public function showLastest(){
        $messages = MessageLog::where('cleared', 0)->get();
        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function addMessage(Request $request) {
        $message = new MessageLog;
        $message->text = $request->input('text');
        $message->action = $request->input('action');
        $message->cleared = 0;
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Message added successfully',
        ]);
    }

    public function clearAll() {
        MessageLog::where('cleared', 0)->update(['cleared' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Messages cleared successfully',
        ]);
    }

}
