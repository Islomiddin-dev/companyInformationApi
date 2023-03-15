<?php

namespace App\Services;

use App\Interfaces\Services\ProfileServiceInterface;
use App\Interfaces\Repositories\ProfileRepositoryInterface;
use App\Responses\ApiResponse;
use Illuminate\Validation\Rule;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ValidatorService $validatorService
    )
    {
    }

    public function update($request, int $id): ApiResponse
    {
        $profile = $this->profileRepository->findOne($id);
        $validator = $this->validatorService->make($request->all(), [
            'name' => 'string|max:255',
            'login' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($profile->id),
            ],
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.validation-failed'), $validator->errors());
        }

        $data = $request->except('password_confirmation');
        $data['password'] = bcrypt($data['password']);

        $profile->update($data);

        return ApiResponse::success(__('api-custom.profile-updated'), $profile->toArray());
    }

    public function delete(int $id): ApiResponse
    {
        $profile = $this->profileRepository->findOne($id);
        $profile->delete();

        return ApiResponse::success(__('api-custom.profile-deleted'), []);
    }
}
