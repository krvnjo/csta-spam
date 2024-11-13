<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
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
            ->whereHas('propertyChildren', function ($query) {
                $query->whereNotNull('inventory_date');
            })
            ->get()
            ->map(function ($property) {
                if ($property->purchase_price && $property->useful_life && isset($property->residual_value)) {
                    $annualDepreciation = ($property->residual_value - $property->purchase_price) / $property->useful_life;
                    $property->annualDepreciation = round($annualDepreciation, 2);

                    $property->depreciationRate = round(($annualDepreciation / $property->purchase_price) * 100, 2);

                    $depreciationValues = [];
                    $currentValue = $property->purchase_price;

                    for ($i = 0; $i <= $property->useful_life; $i++) {
                        $depreciationValues[] = round($currentValue, 2);
                        $currentValue += $annualDepreciation;
                    }

                    $property->depreciationValues = $depreciationValues;
                } else {
                    $property->depreciationValues = [];
                    $property->annualDepreciation = 0;
                    $property->depreciationRate = 0;
                }
                return $property;
            });

        $propertyChildrenCount = PropertyChild::whereNotNull('inventory_date')
            ->where('is_active', 1)
            ->count();

        $categories = Category::query()->select('id','name')->where('is_active', 1)->get();
        $brands = Brand::query()->select('id','name')->where('is_active', 1)->get();
        $conditions = Condition::query()->select('id','name')->where('is_active', 1)->get();
        $acquisitions = Acquisition::query()->select('id','name')->where('is_active', 1)->get();

        return view('pages.property-asset.inventory.overview-inventory', compact('brands','categories','conditions','acquisitions','propertyParents','propertyChildrenCount'));
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
