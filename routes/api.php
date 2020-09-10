<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::model('companies', 'Company');
Route::model('employees', 'Employee');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1', 'middleware' => ['auth:sanctum']], function () {
    Route::resource('companies', 'CompaniesController', ['except' => ['create']]);
    Route::group(['prefix' => 'companies/{company}'], function () {
        Route::resource('employees', 'EmployeesController', ['except' => ['create']]);
    });
});