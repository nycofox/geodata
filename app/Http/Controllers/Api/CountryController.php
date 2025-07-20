<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        // Fetch all countries with their cities
        $countries = \App\Models\Geo\Country::orderBy('cca3')->get();

        // Return the countries as a JSON response
        return response()->json($countries);
    }
}
