<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingItem;
use App\Models\Progress;
use App\Models\PropertyChild;
use App\Models\PropertyParent;
use App\Models\Requester;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;

class BorrowingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requesters = Requester::where('is_active', 1)->get();
        $items = PropertyParent::where('is_active', 1)->with('propertyChildren')->get();
        $progresses = Progress::where('is_active', 1)->whereIn('id', [1,2])->get();

        $borrowings = Borrowing::with('requester', 'requestItems.property')->get();


        return view('pages.borrowing-reservation.request', compact( 'requesters', 'items', 'borrowings','progresses'));
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

        try {
            $borrowingValidationMessages = [
                'requester.required' => 'Please choose a requester!',
                'when.required' => 'Please enter a borrow date!',
                'when.date' => 'The borrow date must be a valid date!',
                'when.after' => 'The borrow date must be at least 3 days after the request date.',
                'remarks.required' => 'Please enter a remarks!',
                'remarks.regex' => 'The remarks may only contain letters, spaces, periods, and hyphens.',
                'remarks.min' => 'The remarks must be at least :min characters.',
                'remarks.max' => 'The remarks may not be greater than :max characters.',

                'items.required' => 'Please add at least one item!',
                'items.array' => 'The items must be an array!',
                'items.*.required' => 'Please choose an item!',
                'items.*.exists' => 'The selected item does not exist!',
                'items.*.distinct' => 'Each item must be unique!',
            ];

            $borrowingValidators = Validator::make($request->all(), [
                'requester' => 'required',
                'when' => 'required|date|after:' . now()->addDays(3)->toDateString(),
                'remarks' => ['required', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
                'items' => 'required|array|min:1',
                'items.*' => 'required|exists:property_parents,id',
            ], $borrowingValidationMessages);

            $borrowingValidators->after(function ($validator) use ($request) {
                $items = $request->input('items');
                if (count($items) !== count(array_unique($items))) {
                    $validator->errors()->add('items', 'Each item must be unique!');
                }
            });

            if ($borrowingValidators->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $borrowingValidators->errors(),
                ]);
            }


            $currentYear = Carbon::now()->year;

            $lastCode = Borrowing::query()
                ->where('borrow_num', 'LIKE', "BRT{$currentYear}%")
                ->orderBy('borrow_num', 'desc')
                ->value('borrow_num');

            $nextNumber = $lastCode ? (int)substr($lastCode, 7) + 1 : 1;
            $code = 'BRT' . $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $borrowing = Borrowing::create([
                'requester_id' => $request->requester,
                'borrow_num' => $code,
                'remarks' => $request->remarks,
                'prog_id' => 1,
                'borrow_date' => $request->when,
            ]);

            $items = $request->input('items');
            $quantities = $request->input('quantities');

            foreach ($items as $index => $itemId) {
                $propertyParent = PropertyParent::find($itemId);
                BorrowingItem::create([
                    'borrow_id' => $borrowing->id,
                    'parent_id' => $propertyParent->id,
                    'quantity' => $quantities[$index],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Borrowing Request Submitted!',
                'text' => 'The borrowing has been submitted successfully!',
            ]);


        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while creating the request.' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $newRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $borrowing = Borrowing::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $borrowing->prog_id = 2;
            $borrowing->approved_at = now();
            $borrowing->save();

            return response()->json([
                'success' => true,
                'title' => 'Approved Successfully!',
                'text' => 'The borrow request has been approved successfully!',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while approving the borrow request: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function release(Request $request)
    {
        try {
            $borrowing = Borrowing::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $borrowingItems = $borrowing->requestItems;

            foreach ($borrowingItems as $borrowingItem) {
                $propertyParent = $borrowingItem->property;

                if (!$propertyParent->is_consumable) {
                    $availableChildren = $propertyParent->propertyChildren()
                        ->where('status_id', 1)
                        ->get();

                    if ($availableChildren->count() < $borrowingItem->quantity) {
                        return response()->json([
                            'success' => false,
                            'title' => 'Insufficient Items!',
                            'text' => 'Not enough available items to fulfill the request!',
                        ], 500);
                    }

                    $childrenToBorrow = $availableChildren->take($borrowingItem->quantity);

                    foreach ($childrenToBorrow as $child) {
                        $child->status_id = 6;
                        $child->save();
                        $borrowingItem->propertyChildren()->attach($child->id);
                    }

                } else {

                    if ($propertyParent->count() < $borrowingItem->quantity) {
                        return response()->json([
                            'success' => false,
                            'title' => 'Insufficient Items!',
                            'text' => 'Not enough available items to fulfill the request!',
                        ], 500);
                    }

                    $propertyParent->quantity -= $borrowingItem->quantity;
                    $propertyParent->save();
                }

            }

            $borrowing->released_at = now();
            $borrowing->prog_id = 3;
            $borrowing->save();

            return response()->json([
                'success' => true,
                'title' => 'Approved Successfully!',
                'text' => 'The borrow request has been approved successfully!',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while approving the borrow request: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
