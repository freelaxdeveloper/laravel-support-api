<?php

namespace App\Services;

use App\Chat;
use Illuminate\Support\Facades\Auth;

/**
 * Class ChatService
 * @package App\Service
 */
class ChatService
{
    /**
     * @return Chat model
     */
    public static function startChat()
    {
        return Chat::firstOrCreate([
           Chat::CLIENT_ID => customer()->id,
        ]);
    }
}
