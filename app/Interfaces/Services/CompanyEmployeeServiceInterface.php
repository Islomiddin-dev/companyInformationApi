<?php

namespace App\Interfaces\Services;

use App\Responses\ApiResponse;
use Illuminate\Http\Request;

interface CompanyEmployeeServiceInterface
{
    public function create(Request $request): ApiResponse;

    public function update(Request $request, int $id): ApiResponse;

    public function delete(int $id): ApiResponse;
}
