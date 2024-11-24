<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingItem;
use App\Models\ItemTransaction;
use App\Models\PropertyParent;
use App\Models\Requester;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ItemTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requesters = Requester::where('is_active', 1)->get();
        $items = PropertyParent::where('is_active', 1)->where('is_consumable', 1)->get();

        return view('pages.item-transactions.new-transaction', compact('requesters', 'items'));
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
            $transactionValidationMessages = [
                'requester.required' => 'Please choose a requester!',

                'remarks.required' => 'Please enter a remarks!',
                'remarks.regex' => 'The remarks may only contain letters, spaces, periods, and hyphens.',
                'remarks.min' => 'The remarks must be at least :min characters.',
                'remarks.max' => 'The remarks may not be greater than :max characters.',

                'received.required' => 'Please enter the name of the person who received the items!',
                'received.regex' => 'The received by may only contain letters, spaces, periods, and hyphens.',
                'received.min' => 'The received by must be at least :min characters.',
                'received.max' => 'The received by may not be greater than :max characters.',

                'items.required' => 'Please add at least one item!',
                'items.array' => 'The items must be an array!',
                'items.*.required' => 'Please choose an item!',
                'items.*.exists' => 'The selected item does not exist!',
                'items.*.distinct' => 'Each item must be unique!',
            ];

            $transactionValidators = Validator::make($request->all(), [
                'requester' => 'required',
                'remarks' => ['required', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
                'received' => ['required', 'regex:/^[A-Za-z0-9%,\- ×."\'"]+$/', 'min:3', 'max:100'],
                'items' => 'required|array|min:1',
                'items.*' => 'required|exists:property_parents,id',
            ], $transactionValidationMessages);

            $transactionValidators->after(function ($validator) use ($request) {
                $items = $request->input('items');
                if (count($items) !== count(array_unique($items))) {
                    $validator->errors()->add('items', 'Each item must be unique!');
                }
            });

            if ($transactionValidators->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $transactionValidators->errors(),
                ]);
            }


            $currentYear = Carbon::now()->year;

            $lastCode = ItemTransaction::query()
                ->where('transaction_num', 'LIKE', "T{$currentYear}%")
                ->orderBy('transaction_num', 'desc')
                ->value('transaction_num');

            $nextNumber = $lastCode ? (int)substr($lastCode, 7) + 1 : 1;
            $code = 'T' . $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $transaction = ItemTransaction::create([
                'requester_id' => $request->requester,
                'transaction_num' => $code,
                'remarks' => $request->remarks,
                'received_by' => $request->received,
                'transaction_date' => now(),
            ]);

            $items = $request->input('items');
            $quantities = $request->input('quantities');

            foreach ($items as $index => $itemId) {
                $propertyParent = PropertyParent::find($itemId);

                // Check stock availability
                if ($quantities[$index] > $propertyParent->quantity) {
                    return response()->json([
                        'success' => false,
                        'title' => 'Insufficient Stock!',
                        'text' => "Not enough stock for item '{$propertyParent->name}'. Available: {$propertyParent->quantity}. Requested: {$quantities[$index]}",
                    ]);
                }


                $propertyParent->quantity -= $quantities[$index];
                $propertyParent->save();


                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'parent_id' => $propertyParent->id,
                    'quantity' => $quantities[$index],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Item Transaction Added!',
                'text' => 'The item transaction has been added successfully!',
            ]);


        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while creating the transaction.' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
