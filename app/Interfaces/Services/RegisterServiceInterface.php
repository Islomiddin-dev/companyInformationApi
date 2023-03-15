<?php

namespace App\Interfaces\Services;

use App\Responses\ApiResponse;
use Illuminate\Http\Request;

interface RegisterServiceInterface
{
    public function register(Request $request): ApiResponse;
}
