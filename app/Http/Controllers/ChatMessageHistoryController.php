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
        return $this->success([$this->userId()]);
    }

    public function show()
    {
        $chat = ChatService::startChat()->loadMissing('messages.user')
            ->where(Chat::CLIENT_IP, $this->userIp())
            ->first();

        return $this->success(new ChatResource($chat));
    }
}
