<?php

namespace App\Interfaces\Repositories;

interface ProfileRepositoryInterface
{
    public function all();
    public function findOne(int $id);
}
