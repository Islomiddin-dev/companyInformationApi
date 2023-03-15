<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\LoginServiceInterface;
use App\Interfaces\Services\RegisterServiceInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected RegisterServiceInterface $registerService,
        protected LoginServiceInterface $loginService
    )
    {
    }

    public function register(Request $request): JsonResponse
    {
        return $this->registerService->register($request)->toJson();
    }

    public function login(Request $request): JsonResponse
    {
        return $this->loginService->login($request)->toJson();
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return ApiResponse::success(__('api-custom.user-logout'), [], 200)->toJson();
    }
}
