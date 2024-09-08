<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::query()->get();
        $totalBrands = $brands->count();
        $activeBrands = $brands->where('is_active', 1)->count();
        $inactiveBrands = $brands->where('is_active', 0)->count();

        $activePercentage = $totalBrands > 0 ? ($activeBrands / $totalBrands) * 100 : 0;
        $inactivePercentage = $totalBrands > 0 ? ($inactiveBrands / $totalBrands) * 100 : 0;

        return view('pages.file-maintenance.brand', compact('brands', 'totalBrands', 'activeBrands', 'inactiveBrands', 'activePercentage', 'inactivePercentage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
