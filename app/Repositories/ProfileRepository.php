<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProfileRepositoryInterface;
use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function all()
    {
        return User::select('id', 'name')
            ->with('company:id,user_id,name')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->whereHas('company', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->paginate(User::PAGINATION);
    }

    public function findOne(int $id)
    {
        return User::select('id', 'name')
            ->with('company:id,user_id,name')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->whereHas('company', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            })
            ->findOrFail($id);
    }

}
