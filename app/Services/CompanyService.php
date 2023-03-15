<?php

namespace App\Services;

use App\Interfaces\Services\CompanyServiceInterface;
use App\Interfaces\Repositories\CompanyRepositoryInterface;
use App\Models\Company;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
        private ValidatorService $validator
    )
    {
    }

    public function create(Request $request): ApiResponse
    {
        $validator = $this->validator->make($request->all(), [
            'name' => 'required|string',
            'leader_full_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|email|unique:companies',
            'website' => 'required|string|url',
            'phone_number' => 'required|string|regex:/^\+998\d{9}$/',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.company-created-failed'), $validator->errors()->toArray(), 400);
        }

        Company::create($request->all());

        return ApiResponse::success(__('api-custom.company-created-successfully'), [], 201);
    }

    public function update(Request $request, int $id): ApiResponse
    {
        $company = $this->companyRepository->findOne($id);

        $validator = $this->validator->make($request->all(), [
            'name' => 'required|string',
            'leader_full_name' => 'required|string',
            'address' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('companies')->ignore($company->id),
            ],
            'website' => 'required|string|url',
            'phone_number' => 'required|string|regex:/^\+998\d{9}$/',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.company-updated-failed'), $validator->errors()->toArray(), 400);
        }

        $company->update($request->all());

        return ApiResponse::success(__('api-custom.company-updated-successfully'), [], 200);
    }

    public function delete(int $id): ApiResponse
    {
        $company = $this->companyRepository->findOne($id);
        $company->delete();

        return ApiResponse::success(__('api-custom.company-deleted-successfully'), [], 200);
    }
}
