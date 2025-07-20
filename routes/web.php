<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/countries', [\App\Http\Controllers\Api\CountryController::class, 'index'])
    ->middleware(['auth:api'])
    ->name('api.countries.index');
