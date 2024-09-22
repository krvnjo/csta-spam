<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandSubcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::with('subcategories')->whereNull('deleted_at')->get();
        $categories = Category::with(['subcategories' => function ($query) {
            $query->whereNull('deleted_at')->where('is_active', 1)->orderBy('name', 'asc');
        }])->whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->get();

        $totalBrands = $brands->count();
        $deletedBrands = Brand::onlyTrashed()->count();
        $activeBrands = $brands->where('is_active', 1)->count();
        $inactiveBrands = $totalBrands - $activeBrands;

        $activePercentage = $totalBrands ? ($activeBrands / $totalBrands) * 100 : 0;
        $inactivePercentage = $totalBrands ? ($inactiveBrands / $totalBrands) * 100 : 0;

        return view('pages.file-maintenance.brand',
            compact(
                'brands',
                'categories',
                'totalBrands',
                'deletedBrands',
                'activeBrands',
                'inactiveBrands',
                'activePercentage',
                'inactivePercentage'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $brandValidationMessages = [
            'brand.required' => 'Please enter a brand name!',
            'brand.regex' => 'It must not contain special symbols and multiple spaces.',
            'brand.min' => 'The brand name must be at least :min characters.',
            'brand.max' => 'The brand name may not be greater than :max characters.',
            'brand.unique' => 'This brand name already exists.',

            'subcategories.required' => 'Please select a brand subcategory!',
        ];

        try {
            $brandValidator = Validator::make($request->all(), [
                'brand' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:80',
                    'unique:brands,name'
                ],
                'subcategories' => [
                    'required',
                ]
            ], $brandValidationMessages);

            if ($brandValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $brandValidator->errors(),
                ]);
            } else {
                $brand = Brand::query()->create([
                    'name' => ucwords(trim($request->input('brand'))),
                    'is_active' => 1,
                ]);

                foreach ($request->input('subcategories') as $subcategory) {
                    BrandSubcategory::query()->insert([
                        'brand_id' => $brand->id,
                        'subcateg_id' => $subcategory,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The brand has been added successfully!',
                ]);
            }
        } catch (Throwable $e) {
            Log::error('Error adding brand: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the brand. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $brand = Brand::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $subcategories = $brand->subcategories()->with('category')->whereNull('deleted_at')->orderBy('name')->get()->groupBy('category.name');

            $formattedSubcategories = [];
            foreach ($subcategories as $categoryName => $items) {
                $formattedSubcategories[] = [
                    'category' => $categoryName,
                    'subcategories' => $items->pluck('name')->toArray(),
                ];
            }

            return response()->json([
                'success' => true,
                'brand' => $brand->name,
                'subcategories' => $formattedSubcategories,
                'status' => $brand->is_active,
                'created' => $brand->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $brand->updated_at->format('D, F d, Y | h:i:s A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the brand.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $brand = Brand::query()->findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $brand->subcategories()->whereNull('deleted_at')->orderBy('name')->pluck('subcateg_id')->toArray();

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'brand' => $brand->name,
                'subcategories' => $subcategories,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the brand.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $brand = Brand::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'brand', 'subcategories'])) {
                $brandValidationMessages = [
                    'brand.required' => 'Please enter a brand name!',
                    'brand.regex' => 'It must not contain special symbols and multiple spaces.',
                    'brand.min' => 'The brand name must be at least :min characters.',
                    'brand.max' => 'The brand name may not be greater than :max characters.',
                    'brand.unique' => 'This brand name already exists.',

                    'subcategories.required' => 'Please select a brand subcategory!',
                ];

                $brandValidator = Validator::make($request->all(), [
                    'brand' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:80',
                        Rule::unique('brands', 'name')->ignore($brand->id)
                    ],
                    'subcategories' => [
                        'required',
                    ]
                ], $brandValidationMessages);

                if ($brandValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $brandValidator->errors(),
                    ]);
                } else {
                    $brand->name = ucwords(trim($request->input('brand')));
                    $brand->subcategories()->sync(explode(',', $request->input('subcategories')));
                }
            } elseif ($request->has('status')) {
                $brand->is_active = $request->input('status');
            }
            $brand->updated_at = now();
            $brand->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The brand has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the brand.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $ids = array_map(function ($id) {
                return Crypt::decryptString($id);
            }, $ids);

            $brands = Brand::query()->whereIn('id', $ids)->get();

            foreach ($brands as $brand) {
                $brand->is_active = 0;
                $brand->save();
                $brand->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($brands) > 1 ? 'The brands have been deleted and can be restored from the bin.' : 'The brand has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the brand.',
            ], 500);
        }
    }
}
