<?php

namespace App\Interfaces\Services;

use Illuminate\Validation\Validator;

interface ValidatorServiceInterface
{
    public function make(array $inputs, array $rules): Validator;
}
