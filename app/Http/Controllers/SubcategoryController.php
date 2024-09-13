<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->orderBy('name')->get();
        $categories = Category::query()->orderBy('name')->get();

        $totalSubcategories = $subcategories->count();
        $activeSubcategories = $subcategories->where('is_active', 1)->count();
        $inactiveSubcategories = $subcategories->where('is_active', 0)->count();

        $activePercentage = $totalSubcategories > 0 ? ($activeSubcategories / $totalSubcategories) * 100 : 0;
        $inactivePercentage = $totalSubcategories > 0 ? ($inactiveSubcategories / $totalSubcategories) * 100 : 0;

        return view('pages.file-maintenance.subcategory', compact('subcategories', 'categories', 'totalSubcategories', 'activeSubcategories', 'inactiveSubcategories', 'activePercentage', 'inactivePercentage'));
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
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        //
    }
}
