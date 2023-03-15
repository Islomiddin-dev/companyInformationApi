<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Interfaces\Repositories\CompanyRepositoryInterface;
use App\Interfaces\Services\CompanyServiceInterface;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService,
        private CompanyRepositoryInterface $companyRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CompanyResource::collection($this->companyRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->companyService->create($request)->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CompanyResource
     */
    public function show(int $id): CompanyResource
    {
        return new CompanyResource($this->companyRepository->findOne($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        return $this->companyService->update($request, $id)->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        return $this->companyService->delete($id)->toJson();
    }
}
