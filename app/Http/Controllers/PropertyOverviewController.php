<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PropertyChild;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PropertyOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $propertyChildren = PropertyChild::with(['property', 'department', 'designation', 'condition', 'status'])
            ->where('is_active', 1)
            ->get();

        $totalItems = $propertyChildren->count();
        $itemsInStock = $propertyChildren->filter(function ($item) {
            return is_null($item->inventory_date);
        })->count();
        $itemsAssigned = $propertyChildren->filter(function ($item) {
            return !is_null($item->inventory_date);
        })->count();
        $lowStockConsumables = $propertyChildren->filter(function ($item) {
            return $item->property->is_consumable && $item->property->quantity < 5;
        })->count();

        $designations = Designation::get();
        $departments = Department::get();
        $statuses = Status::with('color')->get();
        $conditions = Condition::with('color')->get();

        return view('pages.property-asset.overview.item-overview', compact(
            'totalItems', 'itemsInStock', 'itemsAssigned', 'lowStockConsumables', 'propertyChildren',
            'designations', 'departments', 'statuses', 'conditions'
        ));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
