<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;

class OngoingBorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['requester', 'requestItems.property.propertyChildren'])
            ->whereHas('requestItems.property', function ($query) {
                $query->where('is_consumable', 0);
            })
            ->get();

        $conditions = Condition::where('is_active', 1)->get();

        return view('pages.borrowing-reservation.ongoing', compact('borrowings', 'conditions'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $decryptedId = Crypt::decryptString($request->input('id'));

            $borrowing = Borrowing::findOrFail($decryptedId);

            return response()->json([
                'success' => true,
                'id' => $borrowing->id,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the ongoing borrow.' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $borrowing = Borrowing::query()->findOrFail($request->input('id'));

            $returnValidationMessages = [
                'remarks.regex' => 'The remarks may only contain letters, spaces, and hyphens.',
                'remarks.min' => 'The remarks must be at least :min characters.',
                'remarks.max' => 'The remarks may not be greater than :max characters.',
                'condition.required' => 'Please choose a condition!',

            ];
            $returnValidator = Validator::make($request->all(), [
                'remarks' => [
                    'nullable',
                    'regex:/^[A-Za-z0-9%,\- ×"]+$/',
                    'min:3',
                    'max:70'
                ],

                'condition' => [
                    'required'
                ],
            ], $returnValidationMessages);

            if ($returnValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $returnValidator->errors(),
                ]);
            }

            foreach ($borrowing->requestItems as $item) {
                if (!$item->property->is_consumable) {
                    foreach ($item->propertyChildren as $child) {
                        $child->update([
                            'condi_id' => $request->input('condition'),
                            'remarks' => $request->input('remarks'),
                            'status_id' => 1,
                        ]);
                    }
                }
            }

            $borrowing->prog_id = 7;
            $borrowing->save();

            return response()->json([
                'success' => true,
                'title' => 'Item Returned Successfully!',
                'text' => 'The Item has been returned successfully!',
            ]);


        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while returning the item.' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
