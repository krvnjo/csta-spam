<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class PropertyParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyParents = PropertyParent::with(['subcategory', 'brand'])
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->get();

        $subcategories = Subcategory::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $conditions = Condition::where('is_active', 1)->get();
        $acquisitions = Acquisition::where('is_active', 1)->get();

        return view('pages.property-asset.overview', compact('brands', 'subcategories', 'conditions', 'acquisitions', 'propertyParents'));
    }

    public function getSubcategoryBrands(Request $request)
    {
        $subcategoryId = $request->input('subcategory_id');
        $brands = Brand::whereHas('subcategories', function ($query) use ($subcategoryId) {
            $query->where('subcateg_id', $subcategoryId);
        })->where('is_active', 1)->get();

        return response()->json($brands);
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

            'category.required' => 'Please choose a category!',

            'brand.required' => 'Please choose a brand!',

            'quantity.required' => 'Please enter the quantity!',
            'quantity.min' => 'The quantity must be at least :min.',
            'quantity.integer' => 'The quantity must be a whole number',
            'quantity.max' => 'The quantity may not be greater than :max.',

            'description.regex' => 'The description may only contain letters, spaces, and hyphens.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',

            'acquiredType.required' => 'Please choose a acquisition type!',

            'acquiredDate.required' => 'Please choose date acquired!',
            'acquiredDate.before_or_equal' => 'The acquired date cannot be later than today.',
            'acquiredDate.after_or_equal' => 'The acquired date must be on or after January 1, 2007.',

            'condition.required' => 'Please choose a condition!',

            'warranty.after_or_equal' => 'The warranty date must be today or a future date.',
            'warranty.before_or_equal' => 'The warranty date cannot be later than December 31, 2100.'
        ];
        try {
            $propertyValidator = Validator::make($request->all(), [
                'propertyName' => [
                    'required',
                    'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$/',
                    'min:3',
                    'max:50',
                    'unique:property_parents,name'
                ],
                'category' => [
                    'required'
                ],
                'brand' => [
                    'required'
                ],
                'quantity' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:500'
                ],
                'description' => [
                    'nullable',
                    'regex:/^[A-Za-z0-9%,\- ×"]+$/',
                    'min:3',
                    'max:100'
                ],
                'acquiredType' => [
                    'required'
                ],
                'acquiredDate' => [
                    'required',
                    'date',
                    'after_or_equal:2007-01-01',
                    'before_or_equal:today'
                ],
                'warranty' => [
                    'nullable',
                    'date',
                    'after_or_equal:today',
                    'before_or_equal:2100-12-31'
                ],
                'condition' => [
                    'required'
                ],
            ], $propertValidationMessages);
            if ($propertyValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $propertyValidator->errors(),
                ]);
            } else {
                if ($request->hasFile('propertyImage')) {
                    $file = $request->file('propertyImage');
                    if ($file !== null && $file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('storage/img/prop-asset/'), $filename);
//                        $file->move(resource_path('img/uploads/prop-asset/'), $filename);
                        $imageFileName = $filename;
                    } else {
                        $imageFileName = 'default.jpg';
                    }
                } else {
                    $imageFileName = 'default.jpg';
                }

//                $subcateg = Subcategory::query()->find(request('category'));
//                $categ_id = $subcateg->categ_id;

                $parentProperty = PropertyParent::query()->create([
                    'name' => ucwords(strtolower(trim(request('propertyName')))),
                    'image' => $imageFileName,
                    'brand_id' => (int)request('brand'),
                    'subcateg_id' => (int)request('category'),
                    'description' => trim(request('description')),
                    'quantity' => request('quantity'),
//                    'categ_id' => $categ_id,
                ]);

                $propertyQuantity = $request->input('quantity');
                $currentYear = Carbon::now()->year;

                $lastCode = PropertyChild::query()
                    ->where('prop_code', 'LIKE', "$currentYear%")
                    ->orderBy('prop_code', 'desc')
                    ->value('prop_code');

                $nextNumber = $lastCode ? (int)substr($lastCode, 4) + 1 : 1;

                for ($i = 0; $i < $propertyQuantity; $i++) {
                    $code = $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                    $nextNumber++;

                    try {
                        PropertyChild::query()->create([
                            'prop_id' => $parentProperty->id,
                            'prop_code' => $code,
                            'type_id' => (int)request('acquiredType'),
                            'acq_date' => Carbon::parse(request('dateAcquired')),
                            'warranty_date' => Carbon::parse(request('warranty')),
                            'stock_date' => now(),
                            'status_id' => 1,
                            'dept_id' => 1,
                            'desig_id' => 1,
                            'condi_id' => 1,
                        ]);
                    } catch (\Exception) {
                        return response()->json([
                            'success' => false,
                            'title' => 'Oops! Something went wrong.',
                            'text' => 'An error occurred while adding item. Please try again later.',
                        ], 500);

                    }
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The item has been added successfully!'
                ]);


            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding item. Please try again later.',
            ], 500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $propertyParent = PropertyParent::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $propertyChildren = $propertyParent->propertyChildren;

            $propertyInStock = $propertyChildren->whereNull('inventory_date')->where('is_active',1)->count();
            $propertyInInventory = $propertyChildren->whereNotNull('inventory_date')->where('is_active',1)->count();
            $propertyTotal = $propertyChildren->where('is_active',1)->count();
            return response()->json([
                'success' => true,
                'name' => $propertyParent->name,
                'description' => $propertyParent->description,
                'brand' => $propertyParent->brand->name,
                'category' => $propertyParent->subcategory->categories->pluck('name')->join(', '),
                'subcategory' => $propertyParent->subcategory->name,
                'status' => $propertyParent->is_active,
                'inStock' => $propertyInStock,
                'inventory' => $propertyInInventory,
                'quantity' => $propertyTotal,
                'created' => $propertyParent->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $propertyParent->updated_at->format('D, F d, Y | h:i:s A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the item.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $propertyParent = PropertyParent::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'image' => $propertyParent->image,
                'name' => $propertyParent->name,
                'brand_id' => $propertyParent->brand_id,
                'subcateg_id' => $propertyParent->subcateg_id,
                'description' => $propertyParent->description,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the property item.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $property = PropertyParent::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $propertyValidationMessages = [
                'propertyName.required' => 'Please enter an item name!',
                'propertyName.regex' => 'The item name may only contain letters, numbers, spaces, and hyphens.',
                'propertyName.min' => 'The item name must be at least :min characters.',
                'propertyName.max' => 'The item name may not be greater than :max characters.',
                'propertyName.unique' => 'This item name already exists.',
                'category.required' => 'Please choose a category!',
                'brand.required' => 'Please choose a brand!',
                'description.regex' => 'The description may only contain letters, numbers, spaces, and some special characters.',
                'description.min' => 'The description must be at least :min characters.',
                'description.max' => 'The description may not be greater than :max characters.',
            ];

            $propertyValidator = Validator::make($request->all(), [
                'propertyName' => [
                    'required',
                    'regex:/^[A-Za-z0-9\- ]+$/',
                    'min:3',
                    'max:50',
                    'unique:property_parents,name,' . $property->id,
                ],
                'category' => ['required'],
                'brand' => ['required'],
                'description' => [
                    'nullable',
                    'regex:/^[A-Za-z0-9%,\- ×"]+$/',
                    'min:3',
                    'max:100',
                ],
            ], $propertyValidationMessages);

            if ($propertyValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $propertyValidator->errors(),
                ]);
            } else {
                $property->name = $this->formatInput($request->input('propertyName'));
                $property->subcateg_id = $request->input('category');
                $property->brand_id = $request->input('brand');
                $property->description = $request->input('description');
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                if ($file !== null && $file->isValid()) {
                    if ($property->image && $property->image !== 'default.jpg') {
                        $oldImagePath = public_path('storage/img/prop-asset/' . $property->image);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('storage/img/prop-asset/'), $filename);
                    $property->image = $filename;
                }
            } else {
                if (!$property->image || $property->image === 'default.jpg') {
                    $property->image = 'default.jpg';
                }
            }


            $property->updated_at = now();
            $property->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The property has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the property.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyParent $propertyParent)
    {
        //
    }
}
