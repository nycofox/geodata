<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/countries', [\App\Http\Controllers\Api\CountryController::class, 'index'])
    ->middleware('auth:sanctum')
    ->name('api.countries.index');
