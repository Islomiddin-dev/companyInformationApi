<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyEmployeeResource;
use App\Interfaces\Repositories\CompanyEmployeeRepositoryInterface;
use App\Interfaces\Services\CompanyEmployeeServiceInterface;
use Illuminate\Http\Request;

class CompanyEmployeeController extends Controller
{
    public function __construct(
        private CompanyEmployeeRepositoryInterface $companyEmployeeRepository,
        private CompanyEmployeeServiceInterface $companyEmployeeService
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
        return CompanyEmployeeResource::collection($this->companyEmployeeRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return $this->companyEmployeeService->create($request)->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CompanyEmployeeResource
     */
    public function show($id)
    {
        return new CompanyEmployeeResource($this->companyEmployeeRepository->findOne($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        return $this->companyEmployeeService->update($request, $id)->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->companyEmployeeService->delete($id)->toJson();
    }

}
