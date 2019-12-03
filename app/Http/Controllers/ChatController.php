<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Resources\Chat as ChatResource;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $chat = ChatService::startChat()->loadMissing('messages.guest');

        return $this->success(new ChatResource($chat));
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     */
    public function show(Chat $chat)
    {
        $chat->loadMissing('messages.guest');

        return $this->success(new ChatResource($chat));
    }
}
