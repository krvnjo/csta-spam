<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\PropertyParent;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyParents = PropertyParent::with(['subcategory.category', 'brand'])->where('is_active', 1)->where('deleted_at', null)->get();

        $subcategories = Subcategory::query()->select('id','name')->where('is_active', 1)->get();
        $brands = Brand::query()->select('id','name')->where('is_active', 1)->get();
        $conditions = Condition::query()->select('id','name')->where('is_active', 1)->get();
        $acquisitions = Acquisition::query()->select('id','name')->where('is_active', 1)->get();

        return view('pages.property-asset.overview', compact('brands','subcategories','conditions','acquisitions','propertyParents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $propertValidationMessages = [
            'propertyName.required' => 'Please enter an item name!',
            'propertyName.regex' => 'The item name may only contain letters, spaces, and hyphens.',
            'propertyName.min' => 'The item name must be at least :min characters.',
            'propertyName.max' => 'The item name may not be greater than :max characters.',
            'propertyName.unique' => 'This item name already exists.',

            'serialNumber.regex' => 'Please enter an item name!',
            'serialNumber.max' => 'The serial number may not be greater than :max characters.',
            'serialNumber.unique' => 'This item name already exists.',

            'category.required' => 'Please choose a category!',

            'brand.required' => 'Please choose a brand!',

            'quantity.required' => 'Please choose a brand!',
            'quantity.min' => 'The quantity must be at least :min.',
            'quantity.minlength' => 'The quantity must be at least :min.',
            'quantity.max' => 'The quantity may not be greater than :max.',


            'description.regex' => 'The description may only contain letters, spaces, and hyphens.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',

            'acquiredType.required' => 'Please choose a acquisition type!',

            'condition.required' => 'Please choose a condition!',

            'remarks.regex' => 'The remarks may only contain letters, spaces, and hyphens.',
            'remarks.min' => 'The remarks must be at least :min characters.',
            'remarks.max' => 'The remarks may not be greater than :max characters.',
        ];

        $propertyValidator = Validator::make($request->all(), [
            'propertyName' => [
                'required',
                'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$/',
                'min:3',
                'max:50',
                'unique:property_parents,name'
            ],
            'serialNumber' => [
                'regex:/[A-Za-z0-9]*/',
                'max:70',
                'unique:property_child,serial_num'
            ],
            'category' => [
                'required'
            ],
            'brand' => [
                'required'
            ],
            'quantity' => [
                'required',
                'min:1',
                'minlength:1',
                'max:500'
            ],
            'description' => [
                'regex:/^(?!%+$|,+|-+|\s+$)[A-Za-z0-9%,\- ×"]+$/',
                'min:3',
                'max:100'
            ],
            'acquiredType' => [
                'required'
            ],
            'acquiredDate' => [
                'required'
            ],
            'condition' => [
                'required'
            ],
            'remarks' => [
                'regex:/^(?!%+$|,+|-+|\s+$)[A-Za-z0-9%,\- ×"]+$/',
                'min:3',
                'max:100'
            ],
        ], $propertValidationMessages);

        if ($propertyValidator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $propertyValidator->errors(),
            ]);
        } else {

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The acquisition has been added successfully!',
            ]);
        }
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
