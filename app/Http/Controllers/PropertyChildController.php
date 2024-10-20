<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Condition;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PropertyChildController extends Controller
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
        $propertyInactiveStock = $propertyChildren->whereNull('inventory_date')->where('is_active',0)->count();
        $propertyActiveStock = $propertyChildren->whereNull('inventory_date')->where('is_active',1)->count();

        return view('pages.property-asset.stock.view-children',
            compact('propertyChildren',
                'propertyParents',
                'propertyInInventory',
                'propertyActiveStock',
                'propertyInactiveStock',
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
        $childValidationMessages = [
            'VarQuantity.required' => 'Please enter a quantity!',
            'VarQuantity.numeric' => 'The quantity must be a valid number.',
            'VarQuantity.min' => 'The quantity must be at least :min.',
            'VarQuantity.max' => 'The quantity may not be greater than :max.',
        ];

        try {
            $childValidator = Validator::make($request->all(), [
                'VarQuantity' => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:500',
                ],
            ], $childValidationMessages);

            if ($childValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $childValidator->errors(),
                ]);
            } else {
                $parentProperty = PropertyParent::findOrFail($request->parent_id);

                $newQuantity = $parentProperty->quantity + request('VarQuantity');
                $parentProperty->update(['quantity' => $newQuantity]);

                $propertyQuantity = request('VarQuantity');
                $currentYear = Carbon::now()->year;

                $lastCode = PropertyChild::query()
                    ->where('prop_code', 'LIKE', "{$currentYear}%")
                    ->orderBy('prop_code', 'desc')
                    ->value('prop_code');

                $nextNumber = $lastCode ? (int)substr($lastCode, 4) + 1 : 1;

                for ($i = 0; $i < $propertyQuantity; $i++) {
                    $code = $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                    $nextNumber++;
                    PropertyChild::create([
                        'prop_id' => $parentProperty->id,
                        'prop_code' => $code,
                        'type_id' => 1,
                        'acq_date' => now(),
                        'stock_date' => now(),
                        'warranty_date' => null,
                        'status_id' => 1,
                        'dept_id' => 1,
                        'desig_id' => 1,
                        'condi_id' => 1,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The item variants has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the items. Please try again later.',
            ], 500);
        }
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
