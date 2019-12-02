<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Chat, User, Message};
use App\Http\Resources\Chat as ChatResource;
use App\Services\ChatService;

class ChatMessageHistoryController extends Controller
{
    public function index()
    {
        $chat = ChatService::startChat()->loadMissing('messages.guest');

        return $this->success(new ChatResource($chat));
    }

    public function show(Chat $chat)
    {
        $chat->loadMissing('messages.guest');

        return $this->success(new ChatResource($chat));
    }
}
