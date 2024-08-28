<?php

namespace App\Http\Controllers;

use App\Events\AdminReplySent;
use App\Events\MessageSent;
use App\Models\Information;
use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        return view('admin.index');
    }

    public function chatMenu()
    {
        $topics = Topic::all();
        $informations = Information::all();
        return view('admin.chat-menu.index', compact(['topics', 'informations']));
    }
    /**
     * Display the chat interface for admin.
     */
    public function chatIndex()
    {
        $adminId = Auth::id();

        // Mengambil semua user yang terlibat percakapan dengan admin
        $users = User::whereHas('sentMessages', function ($query) use ($adminId) {
            $query->where('receiver_id', $adminId);
        })->orWhereHas('receivedMessages', function ($query) use ($adminId) {
            $query->where('sender_id', $adminId);
        })->get();

        return view('admin.chat.index', compact('users'));
    }

    public function chatDetail($userId)
    {
        $adminId = Auth::id();

        // Mengambil user berdasarkan ID
        $user = User::findOrFail($userId);

        // Mengambil semua pesan antara admin dan user
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        return view('admin.chat.detail', compact('user', 'messages'));
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

    public function getNewMessages(Request $request)
    {
        $lastMessageId = $request->last_message_id;

        $messages = Message::where('id', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendReplyMessage(Request $request)
    {
        $adminId = Auth::id();

        $message = Message::create([
            'sender_id' => $adminId,
            'receiver_id' => $request->user_id,
            'message' => $request->message,
        ]);

        // Broadcast event to others
        broadcast(new AdminReplySent($message, $request->user_id))->toOthers();

        return response()->json(['message' => $message]);
    }
}
