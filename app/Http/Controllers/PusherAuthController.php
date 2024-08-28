<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class PusherAuthController extends Controller
{
    /**
     * Handle the incoming authentication request for private channels.
     */
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );

            // Mengambil data user
            $presence_data = ['name' => Auth::user()->name];

            // Menggabungkan channel data dengan presence data
            $auth = $pusher->socket_auth($request->channel_name, $request->socket_id, json_encode($presence_data));

            return response($auth);
        } else {
            return response('Forbidden', 403);
        }
    }

    /**
     * Determine if the user is authorized to join the channel.
     */
    protected function isAuthorized($user, $channelName)
    {
        // Example: Only allow users to join their own private channels
        if (preg_match('/private-chat\.(\d+)/', $channelName, $matches)) {
            return (int) $matches[1] === $user->id || $user->role_id === 1; // User or admin
        }

        return false;
    }
}
