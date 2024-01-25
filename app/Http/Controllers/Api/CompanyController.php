<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCompany;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $repository;
    public function __construct(Company $model)
    {
        $this->repository = $model;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = $this->repository->getCompanies($request->get('filter', ''));

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCompany $request)
    {
        $company = $this->repository->create($request->validated());

        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();

        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCompany $request, string $uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();

        $company->update($request->validated());

        return response()->json(['message' => 'Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $company = $this->repository->where('uuid', $uuid)->firstOrFail();
        $company->delete();

        return response()->json([], 204);
    }
}
