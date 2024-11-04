<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class PropertyInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyParents = PropertyParent::with(['brand'])
            ->where('is_active', 1)
            ->where('deleted_at', null)
            ->whereHas('propertyChildren', function ($query) {
                $query->whereNotNull('inventory_date');
            })
            ->get();

        $propertyChildrenCount = PropertyChild::whereNotNull('inventory_date')
            ->where('is_active', 1)
            ->count();

        $subcategories = Subcategory::query()->select('id','name')->where('is_active', 1)->get();
        $brands = Brand::query()->select('id','name')->where('is_active', 1)->get();
        $conditions = Condition::query()->select('id','name')->where('is_active', 1)->get();
        $acquisitions = Acquisition::query()->select('id','name')->where('is_active', 1)->get();

        return view('pages.property-asset.inventory.overview-inventory', compact('brands','subcategories','conditions','acquisitions','propertyParents','propertyChildrenCount'));
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
    public function show(PropertyParent $propertyParent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyParent $propertyParent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyParent $propertyParent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyParent $propertyParent)
    {
        //
    }
}
