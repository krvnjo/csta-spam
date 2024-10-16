<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategorySubcategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('subcategories')->whereNull('deleted_at')->orderBy('name')->get();
        $subcategories = Subcategory::with('categories')->whereNull('deleted_at')->orderBy('name')->get();

        $totalCategories = $categories->count();
        $deletedCategories = Category::onlyTrashed()->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $inactiveCategories = $totalCategories - $activeCategories;

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
            $categoryValidationMessages = [
                'category.required' => 'Please enter a category name!',
                'category.regex' => 'No special symbols, consecutive spaces or hyphens allowed.',
                'category.min' => 'The category name must be at least :min characters.',
                'category.max' => 'The category name may not be greater than :max characters.',
                'category.unique' => 'This category name already exists.',

                'subcategories.required' => 'Please select a subcategory!'
            ];

            $categoryValidator = Validator::make($request->all(), [
                'category' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9&.\'-]+(?:[ -][a-zA-Z0-9&.\'-]+)*$/',
                    'min:3',
                    'max:30',
                    'unique:categories,name'
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

            $category = Category::query()->create([
                'name' => ucwords(trim($request->input('category'))),
                'is_active' => 1,
            ]);

            foreach ($request->input('subcategories') as $subcategory) {
                CategorySubcategory::query()->insert([
                    'categ_id' => $category->id,
                    'subcateg_id' => $subcategory,
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The category has been added successfully!',
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
            $category = Category::query()->findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $category->subcategories->whereNull('deleted_at')->pluck('name');

            return response()->json([
                'success' => true,
                'category' => $category->name,
                'subcategories' => $subcategories,
                'status' => $category->is_active,
                'created' => $category->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $category->updated_at->format('D, F d, Y | h:i:s A'),
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
            $category = Category::query()->findOrFail(Crypt::decryptString($request->input('id')));
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
            $category = Category::query()->findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $category->subcategories->whereNull('deleted_at');

            if ($request->has(['category', 'subcategories'])) {
                $categoryValidationMessages = [
                    'category.required' => 'Please enter a category name!',
                    'category.regex' => 'It must not contain special symbols and multiple spaces.',
                    'category.min' => 'The category name must be at least :min characters.',
                    'category.max' => 'The category name may not be greater than :max characters.',
                    'category.unique' => 'This category name already exists.',

                    'subcategories.required' => 'Please select a subcategory!'
                ];

                $categoryValidator = Validator::make($request->all(), [
                    'category' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:50',
                        Rule::unique('categories', 'name')->ignore($category->id)
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
                } else {
                    $category->name = ucwords(trim($request->input('category')));
                    $category->subcategories()->sync(explode(',', $request->input('subcategories')));
                }
            } elseif ($request->has('status')) {
                $category->is_active = $request->input('status');

                if ($category->is_active == 0) {
                    foreach ($subcategories as $subcategory) {
                        $subcategory->is_active = 0;
                        $subcategory->save();
                    }
                } else {
                    foreach ($subcategories as $subcategory) {
                        $subcategory->is_active = 1;
                        $subcategory->save();
                    }
                }
            }
            $category->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The category has been updated successfully!',
            ]);
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
        try {
            $ids = $request->input('id');

            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $ids = array_map(function ($id) {
                return Crypt::decryptString($id);
            }, $ids);

            $categories = Category::query()->whereIn('id', $ids)->get();

            foreach ($categories as $category) {
                if ($category->subcategories->count() > 0) {
                    return response()->json([
                        'success' => false,
                        'title' => 'Deletion Failed!',
                        'text' => 'The category cannot be deleted because it has associated subcategories.',
                    ], 400);
                }
                $category->is_active = 0;
                $category->save();
                $category->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($categories) > 1 ? 'The categories have been deleted and can be restored from the bin.' : 'The category has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the category.',
            ], 500);
        }
    }
}
