<?php

namespace App\Services;

use App\Interfaces\Services\ValidatorServiceInterface;
use Illuminate\Support\Facades\Validator;

class ValidatorService implements ValidatorServiceInterface
{
    public function make(array $inputs, array $rules): \Illuminate\Validation\Validator
    {
        return Validator::make($inputs, $rules);
    }
}
