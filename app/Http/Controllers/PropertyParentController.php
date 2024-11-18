<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Condition;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Unit;
use App\Observers\PropertyParentObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;

#[ObservedBy([PropertyParentObserver::class])]
class PropertyParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyParents = PropertyParent::with(['category', 'brand', 'propertyChildren'])
            ->where('is_active', 1)
            ->get()
            ->map(function ($property) {
                if ($property->purchase_price && $property->useful_life && isset($property->residual_value)) {
                    $annualDepreciation = ($property->purchase_price - $property->residual_value) / $property->useful_life;

                    $acquisitionDate = $property->propertyChildren->first()->acq_date ?? null;

                    $yearsInUse = $acquisitionDate
                        ? round(Carbon::parse($acquisitionDate)->diffInMonths(Carbon::now()) / 12, 2)
                        : 0;

                    $totalDepreciationSoFar = $annualDepreciation * $yearsInUse;

                    $currentValue = max($property->purchase_price - $totalDepreciationSoFar, $property->residual_value);

                    $property->depreciatedValueThisYear = round($currentValue, 2);
                    $property->totalDepreciationSoFar = round($totalDepreciationSoFar, 2);
                    $property->depreciationRate = round(($annualDepreciation / $property->purchase_price) * 100, 2);
                    $property->combinedDepreciationPercentage = round(($totalDepreciationSoFar / $property->purchase_price) * 100, 2);

//                    $debug = [
//                        'purchase_price' => $property->purchase_price,
//                        'residual_value' => $property->residual_value,
//                        'useful_life' => $property->useful_life,
//                        'acquisition_date' => $acquisitionDate,
//                        'years_in_use' => $yearsInUse,
//                        'annual_depreciation' => $annualDepreciation,
//                        'total_depreciation' => $totalDepreciationSoFar,
//                        'current_value' => $currentValue,
//                        'depreciation_percentage' => $property->combinedDepreciationPercentage
//                    ];
//                    dd($debug);
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
            'specification' => ['required', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
            'description' => ['nullable', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
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
            'specification.regex' => 'The specification may only contain letters, spaces, periods, and hyphens.',
            'specification.min' => 'The specification must be at least :min characters.',
            'specification.max' => 'The specification may not be greater than :max characters.',
            'description.regex' => 'The description may only contain letters, spaces, periods, and hyphens.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'purchasePrice.required' => 'Please enter the purchase price!',
            'purchasePrice.numeric' => 'The purchase price must be a number.',
            'purchasePrice.min' => 'The purchase price must be at least :min.',
            'purchasePrice.regex' => 'The purchase price can only have up to 2 decimal places.',
        ];

        if ($request->itemType !== 'consumable') {
            $purchasePrice = $request->input('purchasePrice');
            $rules = array_merge($rules, [
                'category' => ['required'],
                'brand' => ['required'],
                'acquiredType' => ['required'],
                'acquiredDate' => ['required', 'date', 'before_or_equal:today', 'after_or_equal:2007-01-01'],
                'condition' => ['required'],
                'residualValue' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1', 'max:' . $purchasePrice],
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
                'residualValue.min' => 'The residual value must be at least :min.',
                'residualValue.regex' => 'The residual value can only have up to 2 decimal places.',
                'residualValue.max' => 'The residual value may not be greater than the purchase price.',
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

            $propertyInStock = $propertyChildren->whereNull('inventory_date')->where('is_active', 1)->count();
            $propertyInInventory = $propertyChildren->whereNotNull('inventory_date')->where('is_active', 1)->count();
            $propertyTotal = $propertyChildren->where('is_active', 1)->count();
            return response()->json([
                'success' => true,
                'name' => $propertyParent->name,
                'description' => $propertyParent->description ?? 'No description provided',
                'specification' => $propertyParent->specification ?? 'No specification',
                'unit' => $propertyParent->unit->name ? $propertyParent->unit->name : 'No unit type provided',
                'brand' => $propertyParent->brand ? $propertyParent->brand->name : 'Consumable Item',
                'category' => $propertyParent->category ? $propertyParent->category->name : 'Consumable Item',
                'purchasePrice' => $propertyParent->purchase_price ?? 'No price provided',
                'residualValue' => $propertyParent->residual_value
                    ? '₱' . $propertyParent->residual_value
                    : ($propertyParent->is_consumable == 1 ? 'Consumable Item' : 'No residual value provided'),
                'usefulLife' => $propertyParent->useful_life
                    ? $propertyParent->useful_life
                    : ($propertyParent->is_consumable == 1 ? 'Consumable Item' : 'No useful life provided'),
                'inStock' => $propertyInStock,
                'inventory' => $propertyInInventory,
                'quantity' => $propertyTotal,
                'created' => $propertyParent->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $propertyParent->updated_at->format('D, F d, Y | h:i:s A'),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the item.' . $e->getMessage(),
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

            $responseData = [
                'success' => true,
                'id' => $propertyParent->id,
                'name' => $propertyParent->name,
                'description' => $propertyParent->description,
                'specification' => $propertyParent->specification,
                'quantity' => $propertyParent->quantity,
                'unit_id' => $propertyParent->unit_id,
                'purchase_price' => $propertyParent->purchase_price,
                'item_type' => $propertyParent->is_consumable ? 'consumable' : 'non-consumable',
            ];

            if (!$propertyParent->is_consumable) {
                $responseData = array_merge($responseData, [
                    'categ_id' => $propertyParent->categ_id,
                    'brand_id' => $propertyParent->brand_id,
                    'residual_value' => $propertyParent->residual_value,
                    'useful_life' => $propertyParent->useful_life,
                ]);
            }

            return response()->json($responseData);

        } catch (Throwable $e) {
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
            $property = PropertyParent::findOrFail($request->input('id'));

            $purchasePrice = $request->input('price');
            $propertyEditValidationMessages = [
                'property.required' => 'Please enter an item name!',
                'property.regex' => 'The item name may only contain letters, numbers, spaces, and hyphens.',
                'property.min' => 'The item name must be at least :min characters.',
                'property.max' => 'The item name may not be greater than :max characters.',
                'property.unique' => 'This item name already exists.',

                'description.regex' => 'The description may only contain letters, numbers, spaces, and some special characters.',
                'description.min' => 'The description must be at least :min characters.',
                'description.max' => 'The description may not be greater than :max characters.',

                'price.required' => 'Please enter the purchase price!',
                'price.min' => 'The purchase price must be at least :min.',
                'price.numeric' => 'The purchase price must be a number.',
                'price.regex' => 'The purchase price can only have up to 2 decimal places.',

                'residual.required' => 'Please enter the residual value!',
                'residual.numeric' => 'The residual value must be a number.',
                'residual.regex' => 'The residual value can only have up to 2 decimal places.',
                'residual.min' => 'The residual value must be at least :min.',
                'residual.max' => 'The residual value may not be greater than the purchase price.',

                'useful.required' => 'Please enter the useful life!',
                'useful.min' => 'The useful life must be at least :min.',
                'useful.integer' => 'The useful life must be a whole number.',
                'useful.max' => 'The useful life may not be greater than :max.',

                'unit.required' => 'Please choose a unit type!',

                'specification.required' => 'Please enter a specification!',
                'specification.regex' => 'The specification may only contain letters, spaces, periods, and hyphens.',
                'specification.min' => 'The specification must be at least :min characters.',
                'specification.max' => 'The specification may not be greater than :max characters.',

                'category.required' => 'Please choose a category!',

                'brand.required' => 'Please choose a brand!',
            ];

            $propertyEditValidator = Validator::make($request->all(), [
                'property' => [
                    'required',
                    'regex:/^[A-Za-z0-9\- ]+$/',
                    'min:3',
                    'max:50',
                    'unique:property_parents,name,' . $property->id,
                ],
                'price' => [
                    'required',
                    'numeric',
                    'regex:/^\d+(\.\d{1,2})?$/',
                    'min:1'
                ],
                'specification' => [
                    'required',
                    'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/',
                    'min:3',
                    'max:100'
                ],
                'description' => ['nullable', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
                'category' => $property->is_consumable ? 'nullable' : 'required',
                'brand' => $property->is_consumable ? 'nullable' : 'required',
                'residual' => $property->is_consumable ? 'nullable' : ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:1', 'max:' . $purchasePrice],
                'useful' => $property->is_consumable ? 'nullable' : ['required', 'integer', 'min:1', 'max:500'],

            ], $propertyEditValidationMessages);

            if ($propertyEditValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $propertyEditValidator->errors(),
                ]);
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

            if (!$property->is_consumable) {
                $property->update([
                    'name' => ucwords(strtolower(trim($request->input('property')))),
                    'specification' => ucwords(strtolower(trim($request->input('specification')))),
                    'purchase_price' => $request->input('price'),
                    'unit_id' => $request->input('unit'),
                    'description' => ucwords(strtolower(trim($request->input('description')))),
                    'categ_id' => $request->input('category'),
                    'brand_id' => $request->input('brand'),
                    'residual_value' => $request->input('residual'),
                    'useful_life' => $request->input('useful'),
                ]);
            } elseif ($property->is_consumable) {
                $property->update([
                    'name' => ucwords(strtolower(trim($request->input('property')))),
                    'specification' => ucwords(strtolower(trim($request->input('specification')))),
                    'purchase_price' => $request->input('price'),
                    'unit_id' => $request->input('unit'),
                    'description' => ucwords(strtolower(trim($request->input('description')))),
                ]);
            }

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
