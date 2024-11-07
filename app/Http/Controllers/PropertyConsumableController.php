<?php

namespace App\Http\Controllers;

use App\Models\ConsumptionLog;
use App\Models\Department;
use App\Models\PropertyConsumable;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PropertyConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propertyConsumables = PropertyConsumable::with('unit')
            ->whereNull('deleted_at')
            ->get();

        $units = Unit::where('is_active', 1)->get();
        $departments = Department::where('is_active', 1)->get();

        return view('pages.property-asset.consumable.overview-consumable', compact('units', 'propertyConsumables', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consumableValidationMessages = [
            'consumableName.required' => 'Please enter an item name!',
            'consumableName.regex' => 'The item name may only contain letters, spaces, and hyphens.',
            'consumableName.min' => 'The item name must be at least :min characters.',
            'consumableName.max' => 'The item name may not be greater than :max characters.',
            'consumableName.unique' => 'This item name already exists.',

            'unitType.required' => 'Please choose a unit!',

            'consumableQuantity.required' => 'Please enter the quantity!',
            'consumableQuantity.min' => 'The quantity must be at least :min.',
            'consumableQuantity.integer' => 'The quantity must be a whole number',
            'consumableQuantity.max' => 'The quantity may not be greater than :max.',

            'consumableDesc.regex' => 'The description may only contain letters, spaces, and hyphens.',
            'consumableDesc.min' => 'The description must be at least :min characters.',
            'consumableDesc.max' => 'The description may not be greater than :max characters.',
        ];
        try {
            $consumableValidator = Validator::make($request->all(), [
                'consumableName' => [
                    'required',
                    'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$/',
                    'min:3',
                    'max:50',
                    'unique:property_consumables,name'
                ],
                'unitType' => [
                    'required'
                ],
                'consumableQuantity' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:99999'
                ],
                'consumableDesc' => [
                    'nullable',
                    'regex:/^[A-Za-z0-9%,\- ×".]+$/',
                    'min:3',
                    'max:100'
                ],
            ], $consumableValidationMessages);
            if ($consumableValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $consumableValidator->errors(),
                ]);
            } else {

                PropertyConsumable::query()->create([
                    'name' => ucwords(strtolower(trim(request('consumableName')))),
                    'unit_id' => (int)request('unitType'),
                    'description' => ucwords(strtolower(trim(request('consumableDesc')))),
                    'quantity' => (int)request('consumableQuantity'),
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The item has been added successfully!'
                ]);

            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding item. Please try again later.',
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyConsumable $propertyConsumable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $propertyConsumable = PropertyConsumable::findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($propertyConsumable->id),
                'consumableName' => $propertyConsumable->name,
                'consumableDesc' => $propertyConsumable->description,
                'unitType' => $propertyConsumable->unit_id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the item.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $consumables = PropertyConsumable::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['consumableName', 'consumableDesc', 'unitType'])) {
                $consumableValidationMessages = [
                    'consumableName.required' => 'Please enter an item name!',
                    'consumableName.regex' => 'The item name may only contain letters, spaces, and hyphens.',
                    'consumableName.min' => 'The item name must be at least :min characters.',
                    'consumableName.max' => 'The item name may not be greater than :max characters.',
                    'consumableName.unique' => 'This item name already exists.',

                    'unitType.required' => 'Please choose a unit!',

                    'consumableDesc.regex' => 'The description may only contain letters, spaces, and hyphens.',
                    'consumableDesc.min' => 'The description must be at least :min characters.',
                    'consumableDesc.max' => 'The description may not be greater than :max characters.',
                ];
                $consumableValidator = Validator::make($request->all(), [
                    'consumableName' => [
                        'required',
                        'regex:/^(?=.*[A-Za-z0-9])[A-Za-z0-9 ]+$/',
                        'min:3',
                        'max:50',
                        'unique:property_consumables,name'
                    ],
                    'unitType' => [
                        'required'
                    ],
                    'consumableDesc' => [
                        'nullable',
                        'regex:/^[A-Za-z0-9%,\- ×".]+$/',
                        'min:3',
                        'max:100'
                    ],
                ], $consumableValidationMessages);

                if ($consumableValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $consumableValidator->errors(),
                    ]);
                } else {
                    $consumables->name = $request->input('consumableName');
                    $consumables->description = $request->input('consumableDesc');
                    $consumables->unit_id = $request->input('unitType');
                }
            } else {
                $consumables->is_active = $request->input('status');
            }

            $consumables->updated_at = now();
            $consumables->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The item has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the item.',
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

            PropertyConsumable::query()->whereIn('id', $ids)->update(['is_active' => 0]);

            PropertyConsumable::destroy($ids);

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The item has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the item: ',
            ], 500);
        }
    }

    public function restock(Request $request): JsonResponse
    {
        try {
            $restockIds = explode(',', $request->input('id'));
            $newQuantity = $request->input('totalQuantity');

            $validator = Validator::make($request->all(), [
                'restockQuantity' => 'required|integer|min:1|max:99999',
            ], [
                'restockQuantity.required' => 'Please enter the quantity!',
                'restockQuantity.integer' => 'The quantity must be a whole number.',
                'restockQuantity.min' => 'The quantity must be at least :min.',
                'restockQuantity.max' => 'The quantity may not be greater than :max.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ]);
            }

            PropertyConsumable::whereIn('id', $restockIds)->update([
                'quantity' => $newQuantity,
                'updated_at' => now(),
            ]);


            return response()->json([
                'success' => true,
                'title' => 'Item Restocked Successfully!',
                'text' => 'The item has been restocked.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while restocking the item: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function use(Request $request): JsonResponse
    {
        try {
            $useId = $request->input('consumableId');
            $consumable = PropertyConsumable::findOrFail($useId);
            $availableQuantity = $consumable->quantity;

            // Laravel validator with max rule based on available quantity
            $validator = Validator::make($request->all(), [
                'useQuantity' => "required|integer|min:1|max:$availableQuantity",
                'useConsumedBy' => 'required|regex:/^[A-Za-z0-9%,\- ×".]+$/|min:1|max:100',
                'useDepartment' => 'required|exists:departments,id',
                'usePurpose' => 'required|regex:/^[A-Za-z0-9%,\- ×".]+$/|min:1|max:100',
                'useRemarks' => 'nullable|regex:/^[A-Za-z0-9%,\- ×".]+$/|min:1|max:100',
            ], [
                'useQuantity.required' => 'Please enter the quantity!',
                'useQuantity.integer' => 'The quantity must be a whole number.',
                'useQuantity.min' => 'The quantity must be at least :min.',
                'useQuantity.max' => "The quantity may not exceed the available quantity of {$availableQuantity}.",
                'useConsumedBy.required' => 'Please enter the consumer name!',
                'useConsumedBy.regex' => 'The consumer name may only contain letters, spaces, and period.',
                'useConsumedBy.min' => 'The consumer name must be at least :min characters.',
                'useConsumedBy.max' => 'The consumer name may not be greater than :max characters.',
                'useDepartment.required' => 'Please choose a department!',
                'usePurpose.required' => 'Please enter the purpose!',
                'usePurpose.regex' => 'The purpose may only contain letters, spaces, and period.',
                'useRemarks.regex' => 'The remarks may only contain letters, spaces, and period.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ]);
            }

            // Process the request if validation passes
            $useQuantity = (int) $request->input('useQuantity');
            $consumable->decrement('quantity', $useQuantity);

            // Create consumption log
            ConsumptionLog::create([
                'consume_id' => $useId,
                'consumed_by' => ucwords(strtolower(trim($request->input('useConsumedBy')))),
                'dept_id' => (int) $request->input('useDepartment'),
                'quantity_consumed' => $useQuantity,
                'consumed_at' => now(),
                'purpose' => ucwords(strtolower(trim($request->input('usePurpose')))),
                'remarks' => ucwords(strtolower(trim($request->input('useRemarks')))),
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Item Used Successfully!',
                'text' => 'The item has been used.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while using the item: ' . $e->getMessage(),
            ], 500);
        }
    }


}
