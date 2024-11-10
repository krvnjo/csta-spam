<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Audit;
use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([CategoryObserver::class])]
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        $totalCategories = $categories->count();
        $unusedCategories = Category::doesntHave('propertyParent')->count();
        $activeCategories = $categories->where('is_active', 1)->count();
        $inactiveCategories = $categories->where('is_active', 0)->count();

        $activePercentage = $totalCategories ? ($activeCategories / $totalCategories) * 100 : 0;
        $inactivePercentage = $totalCategories ? ($inactiveCategories / $totalCategories) * 100 : 0;

        return view('pages.file-maintenance.category',
            compact(
                'categories',
                'totalCategories',
                'unusedCategories',
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
    public function store(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            Category::create([
                'name' => strtoupper(trim($validated['category'])),
            ]);

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
    public function show(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            $category = Category::findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', Category::class)->where('subject_id', $category->id)->where('event', 'created')->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Category::class)->where('subject_id', $category->id)->where('event', 'updated')->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'category' => $category->name,
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
                'message' => 'An error occurred while fetching the category. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            $category = Category::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($category->id),
                'category' => $category->name,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the category. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            $category = Category::findOrFail($validated['id']);

            if (!isset($validated['status'])) {
                $category->update([
                    'name' => strtoupper(trim($validated['category'])),
                ]);
            } else {
                $category->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The category has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the category. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

            $category = Category::findOrFail($validated['id']);

            if ($category->propertyParent->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The category cannot be deleted because it is still being used by other records.',
                ], 400);
            }

            $category->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The category has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the category. Please try again later.',
            ], 500);
        }
    }
}
