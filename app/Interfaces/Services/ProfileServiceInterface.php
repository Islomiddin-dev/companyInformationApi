<?php

namespace App\Interfaces\Services;

use Illuminate\Http\Request;

interface ProfileServiceInterface
{
    public function update(Request $request, int $id);
    public function delete(int $id);
}
