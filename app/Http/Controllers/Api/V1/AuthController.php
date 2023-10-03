<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponseFoundation;

class AuthController extends ApiController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return Auth::attempt($request->validated()) ?
            $this->getUserTokenResponse() : $this->failedResponse();
    }

    /**
     * @return JsonResponse
     */
    private function getUserTokenResponse(): JsonResponse
    {
        return $this->success(trans('auth.login'), [
            'user'  => Auth::user(),
            'token' => Auth::user()->createToken('login')->accessToken
        ]);
    }

    /**
     * @return JsonResponse
     */
    private function failedResponse(): JsonResponse
    {
        return $this->fail(trans('auth.failed'),
            HttpResponseFoundation::HTTP_NOT_FOUND);
    }
}
