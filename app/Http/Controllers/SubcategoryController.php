<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->whereNull('deleted_at')->get();
        $categories = Category::whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');

        $totalSubcategories = $subcategories->count();
        $deletedSubcategories = Subcategory::onlyTrashed()->count();
        $activeSubcategories = $subcategories->where('is_active', 1)->count();
        $inactiveSubcategories = $totalSubcategories - $activeSubcategories;

        $activePercentage = $totalSubcategories ? ($activeSubcategories / $totalSubcategories) * 100 : 0;
        $inactivePercentage = $totalSubcategories ? ($inactiveSubcategories / $totalSubcategories) * 100 : 0;

        return view('pages.file-maintenance.subcategory',
            compact(
                'subcategories',
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
        $subcategoryValidationMessages = [
            'subcategory.required' => 'Please enter a subcategory name!',
            'subcategory.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'subcategory.min' => 'The subcategory name must be at least :min characters.',
            'subcategory.max' => 'The subcategory name may not be greater than :max characters.',
            'subcategory.unique' => 'This subcategory name already exists.',

            'category.required' => 'Please select a main category!',
        ];

        try {
            $subcategoryValidator = Validator::make($request->all(), [
                'subcategory' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z]+(?:[ -][a-zA-Z]+)*$/',
                    'min:2',
                    'max:50',
                    'unique:subcategories,name'
                ],
                'category' => [
                    'required',
                ],
            ], $subcategoryValidationMessages);

            if ($subcategoryValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $subcategoryValidator->errors(),
                ]);
            } else {
                Subcategory::query()->create([
                    'name' => ucwords(trim($request->input('subcategory'))),
                    'categ_id' => $request->input('category'),
                    'is_active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The subcategory has been added successfully!',
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
            $subcategory = Subcategory::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'subcategory' => $subcategory->name,
                'category' => $subcategory->category->name,
                'status' => $subcategory->is_active,
                'created' => $subcategory->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $subcategory->updated_at->format('D, F d, Y | h:i:s A'),
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
            $subcategory = Subcategory::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'subcategory' => $subcategory->name,
                'category' => $subcategory->categ_id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the designation.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $subcategory = Subcategory::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'designation', 'department'])) {
                $subcategoryValidationMessages = [
                    'subcategory.required' => 'Please enter a subcategory name!',
                    'subcategory.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
                    'subcategory.min' => 'The subcategory name must be at least :min characters.',
                    'subcategory.max' => 'The subcategory name may not be greater than :max characters.',
                    'subcategory.unique' => 'This subcategory name already exists.',

                    'category.required' => 'Please select a main category!',
                ];

                $subcategoryValidator = Validator::make($request->all(), [
                    'subcategory' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z]+(?:[ -][a-zA-Z]+)*$/',
                        'min:2',
                        'max:50',
                        Rule::unique('subcategories', 'name')->ignore($subcategory->id)
                    ],
                    'category' => [
                        'required',
                    ],
                ], $subcategoryValidationMessages);

                if ($subcategoryValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $subcategoryValidator->errors(),
                    ]);
                } else {
                    $subcategory->name = ucwords(trim($request->input('subcategory')));
                    $subcategory->categ_id = $request->input('category');
                }
            } elseif ($request->has('status')) {
                $subcategory->is_active = $request->input('status');
            }
            $subcategory->updated_at = now();
            $subcategory->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The designation has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the designation.',
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

            $subcategories = Subcategory::query()->whereIn('id', $ids)->get();

            foreach ($subcategories as $subcategory) {
                $subcategory->is_active = 0;
                $subcategory->save();
                $subcategory->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($subcategories) > 1 ? 'The designations have been deleted and can be restored from the bin.' : 'The designation has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the designation.',
            ], 500);
        }
    }
}
