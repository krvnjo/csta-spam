<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->orderBy('name')->get();
        $totalCategories = $categories->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $inactiveCategories = $categories->where('is_active', 0)->count();

        $activePercentage = $totalCategories > 0 ? ($activeCategories / $totalCategories) * 100 : 0;
        $inactivePercentage = $totalCategories > 0 ? ($inactiveCategories / $totalCategories) * 100 : 0;

        return view('pages.file-maintenance.category', compact('categories', 'totalCategories', 'activeCategories', 'inactiveCategories', 'activePercentage', 'inactivePercentage'));
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
