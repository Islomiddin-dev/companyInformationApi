<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function all()
    {
        return Company::select('id', 'name', 'email', 'leader_full_name', 'address', 'phone_number', 'website')
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->paginate(Company::PAGINATION);
    }

    public function findOne($id)
    {
        return Company::select('id', 'name', 'email', 'leader_full_name', 'address', 'phone_number', 'website')
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->findOrFail($id);
    }
}
