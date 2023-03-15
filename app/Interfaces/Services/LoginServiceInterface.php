<?php

namespace App\Interfaces\Services;

use App\Responses\ApiResponse;
use Illuminate\Http\Request;

interface LoginServiceInterface
{
    public function login(Request $request): ApiResponse;
}
