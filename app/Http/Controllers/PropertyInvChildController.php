<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Status;
use Illuminate\Http\Request;

class PropertyInvChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PropertyParent $propertyParent)
    {
        $propertyParents = $propertyParent->load([
            'propertyChildren.acquisition',
            'propertyChildren.designation',
            'propertyChildren.department',
            'propertyChildren.condition',
            'propertyChildren.status',
            'propertyChildren.property'
        ]);

        $propertyChildren = $propertyParents->propertyChildren;

        $conditions = Condition::query()->select('id','name')->where('is_active', 1)->get();
        $acquisitions = Acquisition::query()->select('id','name')->where('is_active', 1)->get();

        $departments = Department::query()->select('id','name')->where('is_active', 1)->get();
        $designations = Designation::query()->select('id','name')->where('is_active', 1)->get();
        $statuses = Status::query()->select('id','name')->where('is_active', 1)->get();

        $propertyInInventory = $propertyChildren->whereNotNull('inventory_date')->where('is_active',1)->count();
        $propertyInactiveInventory = $propertyChildren->whereNotNull('inventory_date')->where('is_active',0)->count();
        $propertyActiveStock = $propertyChildren->whereNull('inventory_date')->where('is_active',1)->count();
        $propertyQuantity = $propertyChildren->where('is_active',1)->count();

        return view('pages.property-asset.inventory.children-inventory',
            compact('propertyChildren',
                'propertyParents',
                'propertyInInventory',
                'propertyActiveStock',
                'propertyInactiveInventory',
                'propertyQuantity',
                'conditions',
                'acquisitions',
                'designations',
                'statuses',
                'departments'));
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
    public function show(PropertyChild $propertyChild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyChild $propertyChild)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyChild $propertyChild)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyChild $propertyChild)
    {
        //
    }
}
