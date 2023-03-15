<?php

namespace App\Services;

use App\Interfaces\Services\RegisterServiceInterface;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private ValidatorService $validator
    )
    {
    }

    public function register(Request $request): ApiResponse
    {
        $validator = $this->validator->make($request->all(), [
            'name' => 'required|string',
            'login' => 'required|string|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.user-created-failed'), $validator->errors()->toArray(), 400);
        }

        DB::beginTransaction();
        try {
            $user = new User([
                'name' => $request->input('name'),
                'login' => $request->input('login'),
                'password' => bcrypt($request->input('password')),
            ]);

            $user->save();
            $user->assignRole('company');

            $token = $user->createToken('Personal Access Token');
            $token->token->save();

            DB::commit();

            return ApiResponse::success(__('api-custom.user-created'), ['token' => 'Bearer ' . $token->accessToken], 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return ApiResponse::error(__('api-custom.user-created-failed'), $e->getMessage(), 400);
        }
    }
}
