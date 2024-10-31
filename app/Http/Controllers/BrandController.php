<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Brand;
use App\Models\Subcategory;
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
        $brands = Brand::with('subcategories')->whereNull('deleted_at')->orderBy('name')->get();
        $subcategories = Subcategory::whereNull('deleted_at')->orderBy('name')->get();

        $totalBrands = $brands->count();
        $deletedBrands = Brand::onlyTrashed()->count();
        $activeBrands = $brands->where('is_active', 1)->count();
        $inactiveBrands = $brands->where('is_active', 0)->count();

        $activePercentage = $totalBrands ? ($activeBrands / $totalBrands) * 100 : 0;
        $inactivePercentage = $totalBrands ? ($inactiveBrands / $totalBrands) * 100 : 0;

        return view('pages.file-maintenance.brand',
            compact(
                'brands',
                'subcategories',
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
        try {
            $brandValidationMessages = [
                'brand.required' => 'Please enter a brand name!',
                'brand.regex' => 'No special symbols, consecutive spaces or hyphens allowed.',
                'brand.min' => 'It must be at least :min characters.',
                'brand.max' => 'It must not exceed :max characters.',
                'brand.unique' => 'This brand name already exists.',

                'subcategories.required' => 'Please select at least one subcategory!'
            ];

            $brandValidator = Validator::make($request->all(), [
                'brand' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9&.\'-]+(?:[ -][a-zA-Z0-9&.\'-]+)*$/',
                    'min:2',
                    'max:30',
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
            }

            $brand = Brand::create(['name' => ucwords(trim($request->input('brand')))]);
            $subcategoryIds = $request->input('subcategories');
            $brand->subcategories()->attach($subcategoryIds);
            $subcategories = Subcategory::query()->whereIn('id', $subcategoryIds)->pluck('name')->toArray();

            activity()
                ->useLog('Add Brand')
                ->performedOn($brand)
                ->event('created')
                ->causedBy(auth()->user())
                ->withProperties([
                    'name' => $brand->name,
                    'subcategories' => $subcategories,
                ])
                ->log("A new brand: '{$brand->name}' has been created.");

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The brand has been added successfully!',
            ]);
        } catch (Throwable) {
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
            $subcategories = $brand->subcategories()->with('categories')->whereNull('deleted_at')->orderBy('name')->get()->groupBy(function ($subcategory) {
                return $subcategory->categories->pluck('name')->first();
            });

            $formattedSubcategories = [];
            foreach ($subcategories as $categoryName => $items) {
                $formattedSubcategories[] = [
                    'category' => $categoryName,
                    'subcategories' => $items->pluck('name')->toArray(),
                ];
            }

            $createdBy = Audit::query()
                ->where('subject_type', Brand::class)
                ->where('subject_id', $brand->id)
                ->where('event', 'created')
                ->first();

            $updatedBy = Audit::query()
                ->where('subject_type', Brand::class)
                ->where('subject_id', $brand->id)
                ->where('event', 'updated')
                ->latest()
                ->first() ?? $createdBy;

            return response()->json([
                'success' => true,
                'brand' => $brand->name,
                'subcategories' => $formattedSubcategories,
                'status' => $brand->is_active,
                'created_img' => $createdBy && $createdBy->causer
                    ? asset('storage/img/user-images/' . $createdBy->causer->user_image)
                    : asset('storage/img/user-images/system.jpg'),
                'created_by' => $createdBy && $createdBy->causer
                    ? implode(" ", [$createdBy->causer->fname, $createdBy->causer->lname])
                    : 'CSTA-SPAM System',
                'created' => $brand->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedBy && $updatedBy->causer
                    ? asset('storage/img/user-images/' . $updatedBy->causer->user_image)
                    : asset('storage/img/user-images/system.jpg'),
                'updated_by' => $updatedBy && $updatedBy->causer
                    ? implode(" ", [$updatedBy->causer->fname, $updatedBy->causer->lname])
                    : 'CSTA-SPAM System',
                'updated' => $brand->updated_at->format('D, M d, Y | h:i A'),
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
                'id' => Crypt::encryptString($brand->id),
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

            $logProperties = [
                'name' => $brand->name,
                'subcategories' => $brand->subcategories()->pluck('subcateg_id')->toArray(),
            ];

            if ($request->has(['brand', 'subcategories'])) {
                $brandValidationMessages = [
                    'brand.required' => 'Please enter a brand name!',
                    'brand.regex' => 'No special symbols, consecutive spaces or hyphens allowed.',
                    'brand.min' => 'The brand name must be at least :min characters.',
                    'brand.max' => 'The brand name may not be greater than :max characters.',
                    'brand.unique' => 'This brand name already exists.',

                    'subcategories.required' => 'Please select at least one subcategory!',
                ];

                $brandValidator = Validator::make($request->all(), [
                    'brand' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9&.\'-]+(?:[ -][a-zA-Z0-9&.\'-]+)*$/',
                        'min:2',
                        'max:30',
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
                }
                $brand->name = ucwords(trim($request->input('brand')));
                $brand->subcategories()->sync(explode(',', $request->input('subcategories')));

                $logProperties['new_name'] = $brand->name;
                $logProperties['new_subcategories'] = explode(',', $request->input('subcategories'));

                activity()
                    ->useLog('Edit Brand')
                    ->performedOn($brand)
                    ->event('updated')
                    ->causedBy(auth()->user())
                    ->withProperties($logProperties)
                    ->log('Brand name and subcategories have been updated.');
            } else {
                $brand->is_active = $request->input('status');

                activity()
                    ->useLog('Edit Brand')
                    ->performedOn($brand)
                    ->event('updated')
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'name' => $brand->name,
                        'is_active' => $brand->is_active,
                    ])
                    ->log('Brand status has been updated.');
            }
            $brand->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The brand has been updated successfully!',
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
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
            $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));

            $brands = Brand::query()->whereIn('id', $ids)->get(['id', 'name']);

            Brand::query()->whereIn('id', $ids)->update(['is_active' => 0]);
            Brand::destroy($ids);

            activity()
                ->useLog('Delete Brand')
                ->event('deleted')
                ->causedBy(auth()->user())
                ->withProperties([
                    'deleted_brands' => $brands->map(fn($brand) => [
                        'name' => $brand->name,
                    ]),
                ])
                ->log('The following brands were deleted.');

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The brand(s) has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the brand(s).',
            ], 500);
        }
    }
}
