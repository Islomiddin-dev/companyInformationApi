<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CompanyEmployeeRepositoryInterface;
use App\Models\CompanyEmployee;

class CompanyEmployeeRepository implements CompanyEmployeeRepositoryInterface
{
    public function all()
    {
        return CompanyEmployee::select('id', 'passport_series_and_number', 'first_name', 'last_name', 'father_name', 'phone_number', 'address', 'position', 'company_id')
            ->with(['company:id,name'])
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->where('company_id', auth()->user()->company->id);
            })
            ->paginate(CompanyEmployee::PAGINATION);
    }

    public function findOne(int $id)
    {
        return CompanyEmployee::select('id', 'passport_series_and_number', 'first_name', 'last_name', 'father_name', 'phone_number', 'address', 'position', 'company_id')
            ->with(['company:id,name'])
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->where('company_id', auth()->user()->company->id);
            })
            ->findOrFail($id);
    }
}
