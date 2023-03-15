<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    const PAGINATION = 20;


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
