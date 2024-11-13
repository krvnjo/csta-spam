<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Audit;
use App\Models\Brand;
use App\Observers\BrandObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([BrandObserver::class])]
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('name')->get();

        $totalBrands = $brands->count();
        $unusedBrands = Brand::doesntHave('propertyParent')->count();
        $activeBrands = $brands->where('is_active', 1)->count();
        $inactiveBrands = $brands->where('is_active', 0)->count();

        $activePercentage = $totalBrands ? ($activeBrands / $totalBrands) * 100 : 0;
        $inactivePercentage = $totalBrands ? ($inactiveBrands / $totalBrands) * 100 : 0;

        return view('pages.file-maintenance.brand',
            compact(
                'brands',
                'totalBrands',
                'unusedBrands',
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
    public function store(BrandRequest $request)
    {
        try {
            $validated = $request->validated();

            Brand::create([
                'name' => strtoupper(trim($validated['brand'])),
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'A new brand has been added successfully!',
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
    public function show(BrandRequest $request)
    {
        try {
            $validated = $request->validated();

            $brand = Brand::findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', Brand::class)->where('subject_id', $brand->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Brand::class)->where('subject_id', $brand->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'brand' => $brand->name,
                'status' => $brand->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $brand->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $brand->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the brand. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrandRequest $request)
    {
        try {
            $validated = $request->validated();

            $brand = Brand::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($brand->id),
                'brand' => $brand->name,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the brand. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request)
    {
        try {
            $validated = $request->validated();

            $brand = Brand::findOrFail($validated['id']);

            if (!isset($validated['status'])) {
                $brand->update([
                    'name' => strtoupper(trim($validated['brand'])),
                ]);
            } else {
                $brand->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The brand has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the brand. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandRequest $request)
    {
        try {
            $validated = $request->validated();

            $brand = Brand::findOrFail($validated['id']);

            if ($brand->propertyParent->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The brand cannot be deleted because it is still being used by other records.',
                ], 400);
            }

            $brand->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The brand has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the brand. Please try again later.',
            ], 500);
        }
    }
}
