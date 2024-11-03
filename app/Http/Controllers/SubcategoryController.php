<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Facades\LogBatch;
use Throwable;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('categories')->whereNull('deleted_at')->orderBy('name')->get();
        $categories = Category::whereNull('deleted_at')->orderBy('name')->get();
        $brands = Brand::whereNull('deleted_at')->orderBy('name')->get();

        $totalSubcategories = $subcategories->count();
        $deletedSubcategories = Subcategory::onlyTrashed()->count();
        $activeSubcategories = $subcategories->where('is_active', 1)->count();
        $inactiveSubcategories = $subcategories->where('is_active', 0)->count();

        $activePercentage = $totalSubcategories ? ($activeSubcategories / $totalSubcategories) * 100 : 0;
        $inactivePercentage = $totalSubcategories ? ($inactiveSubcategories / $totalSubcategories) * 100 : 0;

        return view('pages.file-maintenance.subcategory',
            compact(
                'subcategories',
                'brands',
                'categories',
                'totalSubcategories',
                'deletedSubcategories',
                'activeSubcategories',
                'inactiveSubcategories',
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
            $request->merge([
                'subcategory' => ucwords(strtolower(trim($request->input('subcategory')))),
            ]);

            $subcategoryValidationMessages = [
                'subcategory.required' => 'Please enter a subcategory name!',
                'subcategory.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                'subcategory.min' => 'It must be at least :min characters.',
                'subcategory.max' => 'It must not exceed :max characters.',
                'subcategory.unique' => 'This subcategory name already exists.',

                'categories.required' => 'Please select at least one category!',
                'brands.required' => 'Please select at least one brand!',
            ];

            $subcategoryValidator = Validator::make($request->all(), [
                'subcategory' => [
                    'required',
                    'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                    'min:2',
                    'max:30',
                    Rule::unique('subcategories', 'name'),
                ],
                'categories' => [
                    'required',
                ],
                'brands' => [
                    'required',
                ],
            ], $subcategoryValidationMessages);

            if ($subcategoryValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $subcategoryValidator->errors(),
                ]);
            } else {
                $subcategory = Subcategory::create([
                    'name' => ucwords(trim($request->input('subcategory'))),
                ]);
                $subcategory->categories()->sync($request->input('categories'));
                $subcategory->brands()->sync($request->input('brands'));

                activity()
                    ->useLog('Add Subcategory')
                    ->performedOn($subcategory)
                    ->event('created')
                    ->withProperties([
                        'name' => $subcategory->name,
                        'categories' => Category::whereIn('id', $request->input('categories'))->pluck('name')->toArray(),
                        'brands' => Brand::whereIn('id', $request->input('brands'))->pluck('name')->toArray(),
                    ])
                    ->log("A new subcategory: '{$subcategory->name}' has been created.");

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'A new subcategory has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the subcategory. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $subcategory = Subcategory::findOrFail(Crypt::decryptString($request->input('id')));
            $categories = $subcategory->categories()->whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();
            $brands = $subcategory->brands()->whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();

            $createdBy = Audit::where('subject_type', Subcategory::class)->where('subject_id', $subcategory->id)->where('event', 'created')->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Subcategory::class)->where('subject_id', $subcategory->id)->where('event', 'updated')->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'subcategory' => $subcategory->name,
                'categories' => $categories,
                'brands' => $brands,
                'status' => $subcategory->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $subcategory->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $subcategory->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the subcategory.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $subcategory = Subcategory::findOrFail(Crypt::decryptString($request->input('id')));
            $categories = $subcategory->categories()->whereNull('deleted_at')->orderBy('name')->pluck('categ_id')->toArray();
            $brands = $subcategory->brands()->whereNull('deleted_at')->orderBy('name')->pluck('brand_id')->toArray();

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($subcategory->id),
                'subcategory' => $subcategory->name,
                'categories' => $categories,
                'brands' => $brands,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the subcategory.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->merge([
                'subcategory' => ucwords(strtolower(trim($request->input('subcategory')))),
            ]);

            if ($request->has('action') && $request->input('action') === 'update') {
                $subcategory = Subcategory::findOrFail(Crypt::decryptString($request->input('id')));

                $subcategoryValidationMessages = [
                    'subcategory.required' => 'Please enter a subcategory name!',
                    'subcategory.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                    'subcategory.min' => 'It must be at least :min characters.',
                    'subcategory.max' => 'It must not exceed :max characters.',
                    'subcategory.unique' => 'This subcategory name already exists.',

                    'categories.required' => 'Please select at least one category!',
                    'brands.required' => 'Please select at least one brand!',
                ];

                $subcategoryValidator = Validator::make($request->all(), [
                    'subcategory' => [
                        'required',
                        'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                        'min:2',
                        'max:30',
                        Rule::unique('subcategories', 'name')->ignore($subcategory->id),
                    ],
                    'categories' => [
                        'required',
                    ],
                    'brands' => [
                        'required',
                    ],
                ], $subcategoryValidationMessages);

                if ($subcategoryValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $subcategoryValidator->errors(),
                    ]);
                }

                $subcategoryName = $subcategory->name;
                $updatedProperties = [];

                if ($subcategory->name !== $request->input('brand')) {
                    $updatedProperties['old']['name'] = $subcategory->name;
                    $updatedProperties['new']['name'] = $request->input('subcategory');
                }

                $newCategories = explode(',', $request->input('categories'));
                $oldCategoryNames = $subcategory->categories()->pluck('name')->toArray();
                $newCategoryNames = [];

                foreach ($newCategories as $categId) {
                    $categ = Subcategory::find($categId);
                    if ($categ) {
                        $newCategoryNames[] = $categ->name;
                    }
                }

                if ($oldCategoryNames !== $newCategoryNames) {
                    $updatedProperties['old']['categories'] = $oldCategoryNames;
                    $updatedProperties['new']['categories'] = $newCategoryNames;
                }

                $newCategories = explode(',', $request->input('categories'));
                $oldCategoryNames = $subcategory->categories()->pluck('name')->toArray();
                $newCategoryNames = [];

                foreach ($newCategories as $categId) {
                    $categ = Subcategory::find($categId);
                    if ($categ) {
                        $newCategoryNames[] = $categ->name;
                    }
                }

                if ($oldCategoryNames !== $newCategoryNames) {
                    $updatedProperties['old']['categories'] = $oldCategoryNames;
                    $updatedProperties['new']['categories'] = $newCategoryNames;
                }

                $newBrands = explode(',', $request->input('brands'));
                $oldBrandNames = $subcategory->brands()->pluck('name')->toArray();
                $newBrandNames = [];

                foreach ($newBrands as $brandId) {
                    $brand = Brand::find($brandId);
                    if ($brand) {
                        $newBrandNames[] = $brand->name;
                    }
                }

                if ($oldBrandNames !== $newBrandNames) {
                    $updatedProperties['old']['brands'] = $oldBrandNames;
                    $updatedProperties['new']['brands'] = $newBrandNames;
                }

                $subcategory->update([
                    'name' => $request->input('subcategory')
                ]);
                $subcategory->categories()->sync($newCategoryNames);
                $subcategory->brands()->sync($newBrands);

                if (!empty($updatedProperties)) {
                    activity()
                        ->useLog('Edit Subcategory')
                        ->performedOn($subcategory)
                        ->event('updated')
                        ->withProperties($updatedProperties)
                        ->log("The subcategory: '{$subcategoryName}' has been updated.");
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The subcategory has been updated successfully!',
                ]);
            } else {
                $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
                $status = $request->input('status');
                $statusText = $status == 1 ? 'Active' : 'Inactive';
                $subcategories = Subcategory::whereIn('id', $ids)->get();

                $allHaveSameStatus = $subcategories->every(fn($subcategory) => $subcategory->is_active == $status);

                if ($allHaveSameStatus) {
                    return response()->json([
                        'success' => true,
                        'title' => 'No changes made!',
                        'text' => 'The subcategories were already set to the desired status.',
                        'type' => 'info',
                    ]);
                }

                $subcategoriesToUpdate = $subcategories->filter(fn($subcategory) => $subcategory->is_active != $status);
                Subcategory::whereIn('id', $subcategoriesToUpdate->pluck('id'))->update(['is_active' => $status]);

                if ($subcategoriesToUpdate->count() > 1) {
                    LogBatch::startBatch();
                }

                foreach ($subcategoriesToUpdate as $subcategory) {
                    if ($subcategory->is_active != $status) {
                        activity()
                            ->useLog('Set Subcategory Status')
                            ->performedOn($subcategory)
                            ->event('updated')
                            ->causedBy(auth()->user())
                            ->withProperties([
                                'name' => $subcategory->name,
                                'status' => $statusText
                            ])
                            ->log("Updated the status of subcategory: '{$subcategory->name}' to {$statusText}.");
                    }
                }

                if ($subcategoriesToUpdate->count() > 1) {
                    LogBatch::endBatch();
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The status of the subcategories has been updated successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the subcategory.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $subcategoryText = (isset($ids) ? count($ids) : 0 > 1) ? 'subcategories' : 'subcategory';
        try {
            $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
            $subcategories = Subcategory::whereIn('id', $ids)->get(['id', 'name']);

            Subcategory::whereIn('id', $ids)->update(['is_active' => 0]);
            Subcategory::destroy($ids);

            $isBatchLogging = count($subcategories) > 1;
            if ($isBatchLogging) {
                LogBatch::startBatch();
            }

            foreach ($subcategories as $subcategory) {
                activity()
                    ->useLog('Delete Subcategory')
                    ->performedOn($subcategory)
                    ->event('deleted')
                    ->withProperties([
                        'name' => $subcategory->name,
                        'status' => $subcategory->is_active == 1 ? 'Active' : 'Inactive'
                    ])
                    ->log("The subcategory: '{$subcategory->name}' has been deleted and moved to the bin.");
            }

            if ($isBatchLogging) {
                LogBatch::endBatch();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => "The {$subcategoryText} have been deleted and can be restored from the bin.",
            ]);

        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => "An error occurred while deleting the {$subcategoryText}. Please try again later.",
            ], 500);
        }
    }
}
