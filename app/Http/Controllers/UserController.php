<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function token()
    {
        return $this->success(['token' => customer()->token]);
    }

    /**
     * @return JsonResponse
     */
    public function myinfo()
    {
        return $this->success(customer()->guest);
    }
}
