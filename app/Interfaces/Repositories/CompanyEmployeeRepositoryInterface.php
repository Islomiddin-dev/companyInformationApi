<?php

namespace App\Interfaces\Repositories;

interface CompanyEmployeeRepositoryInterface
{
    public function all();
    public function findOne(int $id);
}
