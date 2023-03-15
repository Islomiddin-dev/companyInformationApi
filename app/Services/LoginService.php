<?php

namespace App\Services;

use App\Interfaces\Services\LoginServiceInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService implements LoginServiceInterface
{
    public function __construct(
        private ValidatorService $validator
    )
    {
    }

    public function login(Request $request): ApiResponse
    {
        $validator = $this->validator->make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.user-login-failed'), $validator->errors()->toArray(), 400);
        }

        $credentials = request(['login', 'password']);
        if (!Auth::attempt($credentials)) {
            return ApiResponse::error(__('api-custom.user-login-failed'), __('api-custom.login-or-password-incorrect'), 400);
        }

        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return ApiResponse::success(__('api-custom.user-login'), ['token' => 'Bearer ' . $tokenResult->accessToken], 200);
    }
}
