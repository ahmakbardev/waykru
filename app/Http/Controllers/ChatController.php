<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })->get();

        return view('chat.index', compact('messages'));
    }

    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Send the messages along with triggering Pusher in case of new messages
        $lastMessageId = $messages->last()?->id;

        return response()->json(['messages' => $messages, 'lastMessageId' => $lastMessageId]);
    }

    // Di Controller User
    public function sendMessage(Request $request)
    {
        $admin = User::where('role_id', 1)->first();

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $admin->id;
        $message->message = $request->message;
        $message->save();

        // Debugging
        Log::info('Broadcasting MessageSent event', ['message' => $message]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
