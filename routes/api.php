<?php

use App\Http\Controllers\Api\AnalysisController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/customers', [CustomerController::class, 'searchCustomers'])
    ->middleware('auth:sanctum');

Route::get('/analysis', [AnalysisController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('api.analysis');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
