<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $categories = Category::whereNull('deleted_at')->get();

        $totalCategories = $categories->count();
        $deletedCategories = Category::onlyTrashed()->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $inactiveCategories = $totalCategories - $activeCategories;

        $activePercentage = $totalCategories ? ($activeCategories / $totalCategories) * 100 : 0;
        $inactivePercentage = $totalCategories ? ($inactiveCategories / $totalCategories) * 100 : 0;

        return view('pages.file-maintenance.category',
            compact(
                'categories',
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
        $categoryValidationMessages = [
            'category.required' => 'Please enter a category name!',
            'category.regex' => 'It must not contain special symbols and multiple spaces.',
            'category.min' => 'The category name must be at least :min characters.',
            'category.max' => 'The category name may not be greater than :max characters.',
            'category.unique' => 'This category name already exists.',
        ];

        try {
            $categoryValidator = Validator::make($request->all(), [
                'category' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:50',
                    'unique:categories,name'
                ],
            ], $categoryValidationMessages);

            if ($categoryValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $categoryValidator->errors(),
                ]);
            } else {
                Category::query()->create([
                    'name' => $this->formatInput($request->input('category')),
                    'is_active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The category has been added successfully!',
                ]);
            }
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

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'category' => $category->name,
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

            if ($request->has(['id', 'category'])) {
                $categoryValidationMessages = [
                    'category.required' => 'Please enter a category name!',
                    'category.regex' => 'It must not contain special symbols and multiple spaces.',
                    'category.min' => 'The category name must be at least :min characters.',
                    'category.max' => 'The category name may not be greater than :max characters.',
                    'category.unique' => 'This category name already exists.',
                ];

                $categoryValidator = Validator::make($request->all(), [
                    'category' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:50',
                        Rule::unique('categories', 'name')->ignore($category->id)
                    ],
                ], $categoryValidationMessages);

                if ($categoryValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $categoryValidator->errors(),
                    ]);
                } else {
                    $category->name = $this->formatInput($request->input('category'));
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
            $category->updated_at = now();
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
