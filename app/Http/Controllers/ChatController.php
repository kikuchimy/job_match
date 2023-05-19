<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Models\Entry;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ChatController extends Controller
{
    //
    public function index(Entry $entry)
    {
        Gate::authorize('message', $entry);
        $messages = $entry->messages->load('user');
        return view('chat', compact(['messages', 'entry']));
    }

    public function store(Entry $entry, Request $request)
    {
        Gate::authorize('message', $entry);

        $message = new Message($request->all());
        $message->messageable_type = 'App\Models\Entry';
        $message->user_id = Auth::id();

        $message->save();
        // イベントを発火します
        event(new MessageSend($message));
        return response()->json(['message' => '投稿しました。']);
    }

    public function destroy(Entry $entry, Message $message)
    {
        Gate::authorize('message', $entry);
        $message->delete();
        return response()->json(['message' => '投稿しました。']);
    }
}
