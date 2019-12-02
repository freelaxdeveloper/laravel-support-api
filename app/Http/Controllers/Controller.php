<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function success($data = null)
    {
        return $this->done('Success', $data);
    }

    /**
     * @param string $message
     * @param mixed $data
     * @return JsonResponse
     */
    public function done(string $message, $data = null)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * @param string $message
     * @param null $data
     * @return JsonResponse
     */
    public function fail(string $message = 'Error', $data = null)
    {
        return response()->json(compact('message', 'data'), 400);
    }

    /**
     * @return Authenticatable|null
     */
    public function user()
    {
       return Auth::user();
    }

    /**
     * @return int
     */
    public function userId(): int
    {
       return customer()->id;
    }
    /**
     * @return string
     */
    public function userIp(): string
    {
        return customer()->ip;
    }

    /**
     * @param bool $boolean
     * @return JsonResponse
     */
    public function responseIf(bool $boolean)
    {
        return $boolean ? $this->success() : $this->fail();
    }
}
