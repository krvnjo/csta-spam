<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Brand;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
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
                    'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                    'min:2',
                    'max:30',
                    Rule::unique('brands', 'name'),
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
                'created_at' => $brand->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $brand->updated_at->format('D, M d, Y | h:i A'),
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
            if ($request->has('action') && $request->input('action') === 'update') {
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
                        'regex:/^(?!.*([ .&\'-])\1)[a-zA-Z0-9][a-zA-Z0-9 .&\'-]*$/',
                        'min:2',
                        'max:30',
                        Rule::unique('brands', 'name')->ignore($brand->id),
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

                $brandName = $brand->name;
                $updatedProperties = [];

                if ($brand->name !== $request->input('brand')) {
                    $updatedProperties['old']['name'] = $brand->name;
                    $updatedProperties['new']['name'] = $request->input('brand');
                }

                $newSubcategories = explode(',', $request->input('subcategories'));
                $oldSubcategoryNames = $brand->subcategories()->pluck('name')->toArray();
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

                $brand->update([
                    'name' => $request->input('brand')
                ]);
                $brand->subcategories()->sync($newSubcategories);

                if (!empty($updatedProperties)) {
                    activity()
                        ->useLog('Edit Brand')
                        ->performedOn($brand)
                        ->event('updated')
                        ->withProperties($updatedProperties)
                        ->log("The brand: '{$brandName}' has been updated.");
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The brand has been updated successfully!',
                ]);
            } else {
                $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
                $status = $request->input('status');
                $statusText = $status == 1 ? 'Active' : 'Inactive';
                $brands = Brand::whereIn('id', $ids)->get();

                $allHaveSameStatus = $brands->every(fn($brand) => $brand->is_active == $status);

                if ($allHaveSameStatus) {
                    return response()->json([
                        'success' => true,
                        'title' => 'No changes made!',
                        'text' => 'The brands were already set to the desired status.',
                        'type' => 'info',
                    ]);
                }

                $brandsToUpdate = $brands->filter(fn($brand) => $brand->is_active != $status);
                Brand::whereIn('id', $brandsToUpdate->pluck('id'))->update(['is_active' => $status]);

                if ($brandsToUpdate->count() > 1) {
                    LogBatch::startBatch();
                }

                foreach ($brandsToUpdate as $brand) {
                    if ($brand->is_active != $status) {
                        activity()
                            ->useLog('Set Brand Status')
                            ->performedOn($brand)
                            ->event('updated')
                            ->causedBy(auth()->user())
                            ->withProperties([
                                'name' => $brand->name,
                                'status' => $statusText
                            ])
                            ->log("Updated the status of brand: '{$brand->name}' to {$statusText}.");
                    }
                }

                if ($brandsToUpdate->count() > 1) {
                    LogBatch::endBatch();
                }

                return response()->json([
                    'success' => true,
                    'title' => 'Updated Successfully!',
                    'text' => 'The status of the brands has been updated successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the brand(s). Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $brandText = (isset($ids) ? count($ids) : 0 > 1) ? 'brands' : 'brand';
        try {
            $ids = array_map(fn($id) => Crypt::decryptString($id), (array)$request->input('id'));
            $brands = Brand::whereIn('id', $ids)->get(['id', 'name']);

            Brand::whereIn('id', $ids)->update(['is_active' => 0]);
            Brand::destroy($ids);

            $isBatchLogging = count($brands) > 1;
            if ($isBatchLogging) {
                LogBatch::startBatch();
            }

            foreach ($brands as $brand) {
                activity()
                    ->useLog('Delete Brand')
                    ->performedOn($brand)
                    ->event('deleted')
                    ->withProperties([
                        'name' => $brand->name,
                        'status' => $brand->is_active == 1 ? 'Active' : 'Inactive'
                    ])
                    ->log("The brand: '{$brand->name}' has been deleted and moved to the bin.");
            }

            if ($isBatchLogging) {
                LogBatch::endBatch();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => "The {$brandText} have been deleted and can be restored from the bin.",
            ]);

        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => "An error occurred while deleting the {$brandText}. Please try again later.",
            ], 500);
        }
    }
}
