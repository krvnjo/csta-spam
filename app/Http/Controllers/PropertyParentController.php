<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Unit;
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
        $propertyParents = PropertyParent::with(['subcategory', 'brand', 'propertyChildren'])
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($property) {
                if ($property->purchase_price && $property->useful_life && isset($property->residual_value)) {
                    $annualDepreciation = ($property->purchase_price - $property->residual_value) / $property->useful_life;
                    $property->annualDepreciation = round($annualDepreciation, 2);

                    $property->depreciationRate = round(($annualDepreciation / $property->purchase_price) * 100, 2);

                    $currentValue = $property->purchase_price;
                    $totalDepreciationSoFar = 0;
                    $depreciatedValueThisYear = $property->purchase_price;

                    for ($i = 1; $i <= $property->current_year; $i++) {
                        $totalDepreciationSoFar += $annualDepreciation;
                        $currentValue -= $annualDepreciation;
                    }

                    $depreciatedValueThisYear = round($currentValue, 2);
                    $property->depreciatedValueThisYear = $depreciatedValueThisYear;
                    $property->totalDepreciationSoFar = $totalDepreciationSoFar;
                    $property->combinedDepreciationPercentage = round(($totalDepreciationSoFar / $property->purchase_price) * 100, 2);

                } else {
                    $property->depreciatedValueThisYear = $property->purchase_price;
                    $property->totalDepreciationSoFar = 0;
                    $property->annualDepreciation = 0;
                    $property->depreciationRate = 0;
                    $property->combinedDepreciationPercentage = 0;
                }
                return $property;
            });


        $categories = Category::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        $conditions = Condition::where('is_active', 1)->get();
        $acquisitions = Acquisition::where('is_active', 1)->get();
        $units = Unit::where('is_active', 1)->get();

        return view('pages.property-asset.overview', compact('brands', 'categories', 'conditions', 'acquisitions', 'propertyParents', 'units'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $rules = [
            'propertyName' => [
                'required',
                'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$/',
                'min:3',
                'max:50',
                'unique:property_parents,name',
            ],
            'itemType' => ['required'],
            'quantity' => ['required', 'integer', 'min:1', 'max:500'],
            'unit' => ['required'],
            'specification' => ['required', 'regex:/^[A-Za-z0-9%,\- ×"]+$/', 'min:3', 'max:100'],
            'description' => ['nullable', 'regex:/^[A-Za-z0-9%,\- ×"]+$/', 'min:3', 'max:100'],
            'purchasePrice' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1'],
        ];

        $propertyValidationMessages = [
            'propertyName.required' => 'Please enter an item name!',
            'propertyName.regex' => 'The item name may only contain letters, spaces, and hyphens.',
            'propertyName.min' => 'The item name must be at least :min characters.',
            'propertyName.max' => 'The item name may not be greater than :max characters.',
            'propertyName.unique' => 'This item name already exists.',
            'itemType.required' => 'Please choose an item type!',
            'quantity.required' => 'Please enter the quantity!',
            'quantity.min' => 'The quantity must be at least :min.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.max' => 'The quantity may not be greater than :max.',
            'unit.required' => 'Please choose a unit type!',
            'specification.required' => 'Please enter a specification!',
            'specification.regex' => 'The specification may only contain letters, spaces, and hyphens.',
            'specification.min' => 'The specification must be at least :min characters.',
            'specification.max' => 'The specification may not be greater than :max characters.',
            'description.regex' => 'The description may only contain letters, spaces, and hyphens.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'purchasePrice.required' => 'Please enter the purchase price!',
            'purchasePrice.numeric' => 'The purchase price must be a number.',
            'purchasePrice.min' => 'The purchase price must be at least :min.',
        ];

        if ($request->itemType !== 'consumable') {
            $rules = array_merge($rules, [
                'category' => ['required'],
                'brand' => ['required'],
                'acquiredType' => ['required'],
                'acquiredDate' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:2007-01-01'],
                'condition' => ['required'],
                'residualValue' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
                'usefulLife' => ['required', 'integer', 'min:1', 'max:500'],
            ]);

            $propertyValidationMessages = array_merge($propertyValidationMessages, [
                'category.required' => 'Please choose a category!',
                'brand.required' => 'Please choose a brand!',
                'acquiredType.required' => 'Please choose an acquisition type!',
                'acquiredDate.required' => 'Please choose the acquired date!',
                'acquiredDate.before_or_equal' => 'The acquired date cannot be later than today.',
                'acquiredDate.after_or_equal' => 'The acquired date must be on or after January 1, 2007.',
                'condition.required' => 'Please choose a condition!',
                'residualValue.required' => 'Please enter the residual value!',
                'residualValue.numeric' => 'The residual value must be a number.',
                'usefulLife.required' => 'Please enter the useful life!',
                'usefulLife.min' => 'The useful life must be at least :min.',
                'usefulLife.integer' => 'The useful life must be a whole number.',
            ]);
        }

        $propertyValidator = Validator::make($request->all(), $rules, $propertyValidationMessages);

        if ($propertyValidator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $propertyValidator->errors(),
            ]);
        }

        $imageFileName = 'default.jpg';
        if ($request->hasFile('propertyImage')) {
            $file = $request->file('propertyImage');
            if ($file !== null && $file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/img/prop-asset/'), $filename);
                $imageFileName = $filename;
            }
        }

        try {
            if ($request->itemType === 'consumable') {
                $parentProperty = PropertyParent::query()->create([
                    'name' => ucwords(strtolower(trim($request->input('propertyName')))),
                    'image' => $imageFileName,
                    'specification' => ucwords(strtolower(trim($request->input('specification')))),
                    'description' => ucwords(strtolower(trim($request->input('description')))),
                    'quantity' => $request->input('quantity'),
                    'unit_id' => (int)$request->input('unit'),
                    'purchase_price' => (float)$request->input('purchasePrice'),
                    'is_consumable' => 1,
                ]);

                $currentYear = Carbon::now()->year;
                $lastCode = PropertyChild::query()
                    ->where('prop_code', 'LIKE', "$currentYear%")
                    ->orderBy('prop_code', 'desc')
                    ->value('prop_code');

                $nextNumber = $lastCode ? (int)substr($lastCode, 4) + 1 : 1;

                $code = $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                PropertyChild::create([
                    'prop_id' => $parentProperty->id,
                    'prop_code' => $code,
                    'stock_date' => now(),
                    'type_id' => 1,
                    'dept_id' => 1,
                    'acq_date' => now(),
                    'desig_id' => 1,
                    'condi_id' => 1,
                ]);
            } else {
                $parentProperty = PropertyParent::query()->create([
                    'name' => ucwords(strtolower(trim($request->input('propertyName')))),
                    'image' => $imageFileName,
                    'unit_id' => (int)$request->input('unit'),
                    'brand_id' => (int)$request->input('brand'),
                    'categ_id' => (int)$request->input('category'),
                    'specification' => ucwords(strtolower(trim($request->input('specification')))),
                    'description' => ucwords(strtolower(trim($request->input('description')))),
                    'quantity' => $request->input('quantity'),
                    'purchase_price' => (float)$request->input('purchasePrice'),
                    'residual_value' => (float)$request->input('residualValue'),
                    'useful_life' => (int)$request->input('usefulLife'),
                    'is_consumable' => 0,
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

                    PropertyChild::query()->create([
                        'prop_id' => $parentProperty->id,
                        'prop_code' => $code,
                        'type_id' => (int)$request->input('acquiredType'),
                        'acq_date' => Carbon::parse($request->input('acquiredDate')),
                        'warranty_date' => $request->input('warranty') ? Carbon::parse($request->input('warranty')) : null,
                        'stock_date' => now(),
                        'status_id' => 1,
                        'dept_id' => 1,
                        'desig_id' => 1,
                        'condi_id' => 1,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The item has been added successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the item. Please try again later.',
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
                'categ_id' => $propertyParent->categ_id,
                'description' => $propertyParent->description,
                'purchase_price' => $propertyParent->purchase_price,
                'residual_value' => $propertyParent->residual_value,
                'useful_life' => $propertyParent->useful_life,
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

                'purchasePrice.required' => 'Please enter the purchase price!',
                'purchasePrice.min' => 'The purchase price must be at least :min.',
                'purchasePrice.numeric' => 'The purchase price must be a number.',
                'purchasePrice.regex' => 'The purchase price can only have up to 2 decimal places.',

                'residualValue.required' => 'Please enter the residual value!',
                'residualValue.numeric' => 'The residual value must be a number.',
                'residualValue.regex' => 'The residual value can only have up to 2 decimal places.',

                'usefulLife.required' => 'Please enter the useful life!',
                'usefulLife.min' => 'The useful life must be at least :min.',
                'usefulLife.integer' => 'The useful life must be a whole number.',
                'usefulLife.max' => 'The useful life may not be greater than :max.',
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
                'purchasePrice' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    'min:1'
                ],
                'residualValue' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/'
                ],
                'usefulLife' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:500'
                ],
            ], $propertyValidationMessages);

            if ($propertyValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $propertyValidator->errors(),
                ]);
            } else {
                $property->name = $this->formatInput($request->input('propertyName'));
                $property->categ_id = $request->input('category');
                $property->brand_id = $request->input('brand');
                $property->description = $request->input('description');
                $property->purchase_price = floatval($request->input('purchasePrice'));
                $property->residual_value = floatval($request->input('residualValue'));
                $property->useful_life = intval($request->input('usefulLife'));
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
