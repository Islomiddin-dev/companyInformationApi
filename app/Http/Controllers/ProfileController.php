<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Interfaces\Repositories\ProfileRepositoryInterface;
use App\Interfaces\Services\ProfileServiceInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ProfileServiceInterface $profileService
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
        return ProfileResource::collection($this->profileRepository->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProfileResource
     */
    public function show($id)
    {
        return new ProfileResource($this->profileRepository->findOne($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->profileService->update($request, $id)->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->profileService->delete($id)->toJson();
    }
}
