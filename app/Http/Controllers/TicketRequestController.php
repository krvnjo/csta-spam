<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Priority;
use App\Models\PropertyChild;
use App\Models\Ticket;
use Carbon\Carbon;
use Throwable;

class TicketRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('priority', 'progress')->orderBy('created_at', 'desc')->get();
        $priorities = Priority::with('color')->get();
        $items = PropertyChild::whereHas('property', function ($query) {
            $query->where('is_consumable', 0);
        })->with('property')->get();

        return view('pages.repair-maintenance.request',
            compact(
                'tickets',
                'priorities',
                'items',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $currentYear = Carbon::now()->year;
            $lastCode = Ticket::query()
                ->where('ticket_num', 'LIKE', "{$currentYear}%")
                ->orderBy('ticket_num', 'desc')
                ->value('ticket_num');

            $nextNumber = $lastCode ? (int)substr($lastCode, 4) + 1 : 1;
            $code = $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            Ticket::create([
                'ticket_num' => 'RMT' . $code,
                'name' => $this->formatInput($validated['ticket']),
                'description' => $this->formatInput($validated['description']),
                'total_cost' => $validated['cost'],
                'prio_id' => $validated['priority'],
                'prog_id' => 1,
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Created Successfully!',
                'text' => 'The ticket request has been created successfully!',
            ]);
        } catch (Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while creating the request. Please try again later.',
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
    public function update(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            $ticket->update([
                'prog_id' => $validated['progress'],
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Approved Successfully!',
                'text' => 'The ticket request has been approved successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while approving the ticket request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
