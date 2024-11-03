<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Facades\LogBatch;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('subcategories')->whereNull('deleted_at')->orderBy('name')->get();
        $subcategories = Subcategory::whereNull('deleted_at')->orderBy('name')->get();

        $totalCategories = $categories->count();
        $deletedCategories = Category::onlyTrashed()->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $inactiveCategories = $categories->where('is_active', 0)->count();

        $activePercentage = $totalCategories ? ($activeCategories / $totalCategories) * 100 : 0;
        $inactivePercentage = $totalCategories ? ($inactiveCategories / $totalCategories) * 100 : 0;

        return view('pages.file-maintenance.category',
            compact(
                'categories',
                'subcategories',
                'totalCategories',
                'deletedCategories',
                'activeCategories',
                'inactiveCategories',
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
                'category' => ucwords(strtolower(trim($request->input('category')))),
            ]);

            $categoryValidationMessages = [
                'category.required' => 'Please enter a category name!',
                'category.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                'category.min' => 'It must be at least :min characters.',
                'category.max' => 'It must not exceed :max characters.',
                'category.unique' => 'This category name already exists.',

                'subcategories.required' => 'Please select at least one subcategory!'
            ];

            $categoryValidator = Validator::make($request->all(), [
                'category' => [
                    'required',
                    'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                    'min:2',
                    'max:30',
                    Rule::unique('categories', 'name'),
                ],
                'subcategories' => [
                    'required',
                ]
            ], $categoryValidationMessages);

            if ($categoryValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $categoryValidator->errors(),
                ]);
            }

            $category = Category::create([
                'name' => $request->input('category')
            ]);
            $category->subcategories()->sync($request->input('subcategories'));

            activity()
                ->useLog('Add Category')
                ->performedOn($category)
                ->event('created')
                ->withProperties([
                    'name' => $category->name,
                    'subcategories' => Subcategory::whereIn('id', $request->input('subcategories'))->pluck('name')->toArray(),
                ])
                ->log("A new category: '{$category->name}' has been created.");

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'A new category has been added successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the category. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $category = Category::findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $category->subcategories()->whereNull('deleted_at')->pluck('name')->toArray();

            $createdBy = Audit::where('subject_type', Category::class)->where('subject_id', $category->id)->where('event', 'created')->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Category::class)->where('subject_id', $category->id)->where('event', 'updated')->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'category' => $category->name,
                'subcategories' => $subcategories,
                'status' => $category->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $category->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $category->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the category.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $category = Category::findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $category->subcategories()->whereNull('deleted_at')->orderBy('name')->pluck('subcateg_id')->toArray();

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($category->id),
                'category' => $category->name,
                'subcategories' => $subcategories,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the category.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->has('action') && $request->input('action') === 'update') {
                $category = Category::findOrFail(Crypt::decryptString($request->input('id')));

                $request->merge([
                    'category' => ucwords(strtolower(trim($request->input('category')))),
                ]);

                $categoryValidationMessages = [
                    'category.required' => 'Please enter a category name!',
                    'category.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                    'category.min' => 'It must be at least :min characters.',
                    'category.max' => 'It must not exceed :max characters.',
                    'category.unique' => 'This category name already exists.',

                    'subcategories.required' => 'Please select at least one subcategory!'
                ];

                $categoryValidator = Validator::make($request->all(), [
                    'category' => [
                        'required',
                        'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                        'min:2',
                        'max:50',
                        Rule::unique('categories', 'name')->ignore($category->id),
                    ],
                    'subcategories' => [
                        'required',
                    ]
                ], $categoryValidationMessages);

                if ($categoryValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $categoryValidator->errors(),
                    ]);
                }

                $categoryName = $category->name;
                $updatedProperties = [];

                if ($category->name !== $request->input('category')) {
                    $updatedProperties['old']['name'] = $category->name;
                    $updatedProperties['new']['name'] = $request->input('category');
                }

                $newSubcategories = explode(',', $request->input('subcategories'));
                $oldSubcategoryNames = $category->subcategories()->pluck('name')->toArray();
                $newSubcategoryNames = [];

                foreach ($newSubcategories as $subcategId) {
                    $subcateg = Subcategory::find($subcategId);
                    if ($subcateg) {
                        $newSubcategoryNames[] = $subcateg->name;
                    }
                }

                if ($oldSubcategoryNames !== $newSubcategoryNames) {
                    $updatedProperties['old']['subcategories'] = $oldSubcategoryNames;
                    $updatedProperties['new']['subcategories'] = $newSubcategoryNames;
                }

                $category->update([
                    'name' => $request->input('category')
                ]);
                $category->subcategories()->sync($newSubcategories);

                if (!empty($updatedProperties)) {
                    activity()
                        ->useLog('Edit Category')
                        ->performedOn($category)
                        ->event('updated')
                        ->withProperties($updatedProperties)
                        ->log("The category: '{$categoryName}' has been updated.");
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The category has been updated successfully!',
                ]);
            } else {
                $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
                $status = $request->input('status');
                $statusText = $status == 1 ? 'Active' : 'Inactive';
                $categories = Category::whereIn('id', $ids)->get();

                $allHaveSameStatus = $categories->every(fn($category) => $category->is_active == $status);

                if ($allHaveSameStatus) {
                    return response()->json([
                        'success' => true,
                        'title' => 'No changes made!',
                        'text' => 'The categories were already set to the desired status.',
                        'type' => 'info',
                    ]);
                }

                $categoriesToUpdate = $categories->filter(fn($category) => $category->is_active != $status);
                Category::whereIn('id', $categoriesToUpdate->pluck('id'))->update(['is_active' => $status]);

                if ($categoriesToUpdate->count() > 1) {
                    LogBatch::startBatch();
                }

                foreach ($categoriesToUpdate as $category) {
                    if ($category->is_active != $status) {
                        activity()
                            ->useLog('Set Category Status')
                            ->performedOn($category)
                            ->event('updated')
                            ->causedBy(auth()->user())
                            ->withProperties([
                                'name' => $category->name,
                                'status' => $statusText
                            ])
                            ->log("Updated the status of category: '{$category->name}' to {$statusText}.");
                    }
                }

                if ($categoriesToUpdate->count() > 1) {
                    LogBatch::endBatch();
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The status of the categories has been updated successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the category.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $categoryText = (isset($ids) ? count($ids) : 0 > 1) ? 'categories' : 'category';
        try {
            $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
            $categories = Category::whereIn('id', $ids)->get(['id', 'name']);

            Category::whereIn('id', $ids)->update(['is_active' => 0]);
            Category::destroy($ids);

            $isBatchLogging = count($categories) > 1;
            if ($isBatchLogging) {
                LogBatch::startBatch();
            }

            foreach ($categories as $category) {
                activity()
                    ->useLog('Delete Category')
                    ->performedOn($category)
                    ->event('deleted')
                    ->withProperties([
                        'name' => $category->name,
                        'status' => $category->is_active == 1 ? 'Active' : 'Inactive'
                    ])
                    ->log("The category: '{$category->name}' has been deleted and moved to the bin.");
            }

            if ($isBatchLogging) {
                LogBatch::endBatch();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => "The {$categoryText} have been deleted and can be restored from the bin.",
            ]);

        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => "An error occurred while deleting the {$categoryText}. Please try again later.",
            ], 500);
        }
    }
}
