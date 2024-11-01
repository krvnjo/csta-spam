<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Brand;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Facades\LogBatch;
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
            $request->merge([
                'brand' => ucwords(strtolower(trim($request->input('brand')))),
            ]);

            $brandValidationMessages = [
                'brand.required' => 'Please enter a brand name!',
                'brand.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                'brand.min' => 'It must be at least :min characters.',
                'brand.max' => 'It must not exceed :max characters.',
                'brand.unique' => 'This brand name already exists.',

                'subcategories.required' => 'Please select at least one subcategory!'
            ];

            $brandValidator = Validator::make($request->all(), [
                'brand' => [
                    'required',
                    'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*[a-zA-Z0-9]$/',
                    'min:2',
                    'max:30',
                    Rule::unique('brands', 'name')->where('is_deleted', 0),
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

            $brand = Brand::create([
                'name' => $request->input('brand')
            ]);
            $brand->subcategories()->sync($request->input('subcategories'));

            activity()
                ->useLog('Add Brand')
                ->performedOn($brand)
                ->event('created')
                ->causedBy(auth()->user())
                ->withProperties([
                    'name' => $brand->name,
                    'subcategories' => Subcategory::whereIn('id', $request->input('subcategories'))->pluck('name')->toArray(),
                ])
                ->log("A new brand: '{$brand->name}' has been created.");

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
    public function show(Request $request)
    {
        try {
            $brand = Brand::findOrFail(Crypt::decryptString($request->input('id')));
            $subcategories = $brand->subcategories()->whereNull('deleted_at')->orderBy('name')->pluck('name')->toArray();

            $createdBy = Audit::where('subject_type', Brand::class)->where('subject_id', $brand->id)->where('event', 'created')->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Brand::class)->where('subject_id', $brand->id)->where('event', 'updated')->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'brand' => $brand->name,
                'subcategories' => $subcategories,
                'status' => $brand->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $brand->created_at->format('M d, Y | D, h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $brand->updated_at->format('M d, Y | D, h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the brand',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $brand = Brand::findOrFail(Crypt::decryptString($request->input('id')));
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
            if ($request->has(['action'] && $request->input('action') === 'update')) {
                $brand = Brand::findOrFail(Crypt::decryptString($request->input('id')));

                $request->merge([
                    'brand' => ucwords(strtolower(trim($request->input('brand')))),
                ]);

                $brandValidationMessages = [
                    'brand.required' => 'Please enter a brand name!',
                    'brand.regex' => 'No consecutive spaces and symbols allowed. Allowed: (. & \' -)',
                    'brand.min' => 'It must be at least :min characters.',
                    'brand.max' => 'It must not exceed :max characters.',
                    'brand.unique' => 'This brand name already exists.',

                    'subcategories.required' => 'Please select at least one subcategory!'
                ];

                $brandValidator = Validator::make($request->all(), [
                    'brand' => [
                        'required',
                        'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*[a-zA-Z0-9]$/',
                        'min:2',
                        'max:30',
                        Rule::unique('brands', 'name')->ignore($brand->id)->where('is_deleted', 0),
                    ],
                    'subcategories' => [
                        'required',
                    ],
                ], $brandValidationMessages);

                if ($brandValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $brandValidator->errors(),
                    ]);
                }

                $updatedProperties = [];

                if ($brand->name !== $request->input('brand')) {
                    $updatedProperties['old_name'] = $brand->name;
                    $updatedProperties['new_name'] = $request->input('brand');
                }

                $newSubcategories = explode(',', $request->input('subcategories'));
                $currentSubcategories = $brand->subcategories()->pluck('id')->toArray();

                if ($currentSubcategories !== $newSubcategories) {
                    $updatedProperties['old_subcategories'] = $currentSubcategories;
                    $updatedProperties['new_subcategories'] = $newSubcategories;
                }

                $brand->name = $request->input('brand');
                $brand->subcategories()->sync($newSubcategories);
                $brand->save();

                activity()
                    ->useLog('Edit Brand')
                    ->performedOn($brand)
                    ->event('updated')
                    ->causedBy(auth()->user())
                    ->withProperties($updatedProperties)
                    ->log("The brand: '{$brand->name}' has been updated.");

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The brand has been updated successfully!',
                ]);
            } else {
                $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));

                $brands = Brand::whereIn('id', $ids)->get();

                $status = $request->input('status');
                $statusText = $status == 1 ? 'Active' : 'Inactive';

                $brandsToUpdate = $brands->filter(function ($brand) use ($status) {
                    return $brand->is_active != $status;
                });

                if ($brandsToUpdate->isEmpty()) {
                    return response()->json([
                        'success' => true,
                        'title' => 'No Changes Made!',
                        'text' => 'The brand(s) were already set to the desired status.',
                    ]);
                }

                $brandIdsToUpdate = $brandsToUpdate->pluck('id')->toArray();
                Brand::whereIn('id', $brandIdsToUpdate)->update(['is_active' => $status]);

                $batchUUID = (string)Str::uuid();
                foreach ($brandsToUpdate as $brand) {
                    $updatedBrandData = [
                        'name' => $brand->name,
                        'status' => $statusText
                    ];


                    LogBatch::startBatch();
                    activity()
                        ->useLog('Update Brand Status')
                        ->performedOn($brand)
                        ->event('updated')
                        ->causedBy(auth()->user())
                        ->withProperties([$updatedBrandData, 'batchUUID' => $batchUUID])
                        ->log("Updated the status of brand: {$brand->name} to {$statusText}.");
                    LogBatch::endBatch();
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Status Updated!',
                    'text' => 'The status of the brand(s) has been updated successfully!',
                ]);
            }
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
    public function destroy(Request $request)
    {
        try {
            $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));

            $brands = Brand::whereIn('id', $ids)->get(['id', 'name']);

            Brand::whereIn('id', $ids)->update(['is_active' => 0]);
            Brand::destroy($ids);

            $batchUUID = (string)Str::uuid();
            foreach ($brands as $brand) {
                LogBatch::startBatch();
                activity()
                    ->useLog('Delete Brand')
                    ->performedOn($brand)
                    ->event('deleted')
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'name' => $brand->name,
                        'batchUUID' => $batchUUID
                    ])
                    ->log("The brand '{$brand->name}' has been deleted and moved to the bin.");
                LogBatch::endBatch();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'Brand(s) has been deleted and can be restored from the bin.',
            ]);

        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the brand(s). Please try again later.',
            ], 500);
        }
    }
}
