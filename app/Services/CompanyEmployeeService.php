<?php

namespace App\Services;

use App\Interfaces\Services\CompanyEmployeeServiceInterface;
use App\Interfaces\Repositories\CompanyEmployeeRepositoryInterface;
use App\Models\CompanyEmployee;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyEmployeeService implements CompanyEmployeeServiceInterface
{
    public function __construct(
        private CompanyEmployeeRepositoryInterface $companyEmployeeRepository,
        private ValidatorService $validator
    )
    {
    }

    public function create(Request $request): ApiResponse
    {
        $validator = $this->validator->make($request->all(), [
            'passport_series_and_number' => 'required|string|unique:company_employees,passport_series_and_number',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'father_name' => 'required|string',
            'phone_number' => 'required|string|regex:/^\+998\d{9}$/',
            'address' => 'required|string',
            'position' => 'required|string',
            'company_id' => 'required|integer|exists:companies,id',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.employee-created-failed'), $validator->errors()->toArray(), 400);
        }

        CompanyEmployee::create($request->all());

        return ApiResponse::success(__('api-custom.employee-created-successfully'), [], 201);
    }

    public function update(Request $request, int $id): ApiResponse
    {
        $validator = $this->validator->make($request->all(), [
            'passport_series_and_number' => [
                'required',
                'string',
                Rule::unique('company_employees')->ignore($id),
            ],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'father_name' => 'required|string',
            'phone_number' => 'required|string|regex:/^\+998\d{9}$/',
            'address' => 'required|string',
            'position' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('api-custom.employee-updated-failed'), $validator->errors()->toArray(), 400);
        }

        $employee = $this->companyEmployeeRepository->findOne($id);

        $employee->update($request->all());

        return ApiResponse::success(__('api-custom.employee-updated-successfully'), [], 200);
    }

    public function delete(int $id): ApiResponse
    {
        $employee = $this->companyEmployeeRepository->findOne($id);

        $employee->delete();

        return ApiResponse::success(__('api-custom.employee-deleted-successfully'), [], 200);
    }
}
