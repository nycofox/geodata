<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Geo\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::query();

        // Search functionality (by name, code, region)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_common', 'LIKE', "%{$search}%")
                    ->orWhere('name_official', 'LIKE', "%{$search}%")
                    ->orWhere('cca2', 'LIKE', "%{$search}%")
                    ->orWhere('cca3', 'LIKE', "%{$search}%")
                    ->orWhere('region', 'LIKE', "%{$search}%")
                    ->orWhere('subregion', 'LIKE', "%{$search}%");
            });
        }

        // Filter by region
        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        // Filter by subregion
        if ($subregion = $request->input('subregion')) {
            $query->where('subregion', $subregion);
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'name_common');
        $sortOrder = $request->input('sort_order', 'asc');

        // Validate sort fields
        $allowedSortFields = ['name_common', 'name_official', 'cca2', 'cca3', 'region', 'subregion', 'population', 'area_km2'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        // Pagination
        $perPage = $request->input('per_page', 15);
        $perPage = min(max((int) $perPage, 1), 100); // Between 1 and 100

        return $query->paginate($perPage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Try to find by ID first, then by cca2, then by cca3
        $country = Country::where('id', $id)
            ->orWhere('cca2', strtoupper($id))
            ->orWhere('cca3', strtoupper($id))
            ->first();

        if (! $country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

        return $country;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
