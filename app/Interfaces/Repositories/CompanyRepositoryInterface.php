<?php

namespace App\Interfaces\Repositories;

interface CompanyRepositoryInterface
{
    public function all();
    public function findOne($id);
}
