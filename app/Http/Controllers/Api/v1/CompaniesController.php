<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CompanyCollection(Company::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * For this application structure create method not needed.
         *
         */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        try {
            $company = Company::create($request->all());

            if ($request->hasFile('company_logo')) {
                $logoDir = storage_path('app/public/logo');
                if (!file_exists($logoDir)) {
                    mkdir($logoDir, 777);
                }
                $image = $request->file('company_logo');
                $filename = $company->id . '-' . \Str::slug($company->name) . "." . $image->getClientOriginalExtension();
                $location = $logoDir . DIRECTORY_SEPARATOR . $filename;
                if (file_exists($location)) {
                    unlink($location);
                }
                \Image::make($image)->save($location);
                $company->logo = '/logo/' . $filename;
                $company->save();
            }

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'errors' => $e->getMessage(),
                ],
            ], 422);

        }
        return response()->json([
            'data' => [
                'id' => $company->id,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        try {
            $company->update($request->all());

            if ($request->hasFile('company_logo')) {
                $logoDir = storage_path('app/public/logo');
                if (!file_exists($logoDir)) {
                    mkdir($logoDir, 777);
                }

                $image = $request->file('company_logo');
                $filename = $company->id . '-' . \Str::slug($company->name) . "." . $image->getClientOriginalExtension();
                $location = $logoDir . DIRECTORY_SEPARATOR . $filename;
                if (file_exists($location)) {
                    unlink($location);
                }
                \Image::make($image)->save($location);
                $company->logo = '/logo/' . $filename;
                $company->save();
            }

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'errors' => $e->getMessage(),
                ],
            ], 422);

        }
        return response()->json([
            'data' => [
                'id' => $company->id,
            ],
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            //delete all employees from employee table - belong to this company
            foreach ($company->employees as $employee) {
                $employee->delete();
            }

            //delete any assets from the storage belong to this company
            if (!empty($company->logo)) {
                $location = storage_path('app/public') . $company->logo;
                if (file_exists($location)) {
                    unlink($location);
                }
            }

            //finally delete the comapany
            $company->delete();

        } catch (\Exception $e) {
            return response()->json([
                'data' => [
                    'errors' => $e->getMessage(),
                ],
            ], 422);
        }
        return response()->json([], 204);
    }
}