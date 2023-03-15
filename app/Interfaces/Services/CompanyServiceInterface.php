<?php

namespace App\Interfaces\Services;

use App\Models\Company;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

interface CompanyServiceInterface
{
    public function create(Request $request): ApiResponse;
    public function update(Request $request, int $id): ApiResponse;
    public function delete(int $id): ApiResponse;
}
