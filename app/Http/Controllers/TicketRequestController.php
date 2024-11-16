<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Audit;
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
                ->where('ticket_num', 'LIKE', "RMT{$currentYear}%")
                ->orderBy('ticket_num', 'desc')
                ->value('ticket_num');

            $nextNumber = $lastCode ? (int)substr($lastCode, 7) + 1 : 1;
            $code = 'RMT' . $currentYear . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            Ticket::create([
                'ticket_num' => $code,
                'name' => $this->formatInput($validated['ticket']),
                'description' => $this->formatInput($validated['description']),
                'estimated_cost' => $validated['cost'],
                'prio_id' => $validated['priority'],
                'prog_id' => 1,
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Created Successfully!',
                'text' => 'The ticket request has been created successfully!',
            ]);
        } catch (Throwable) {
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
    public function show(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', Ticket::class)->where('subject_id', $ticket->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Ticket::class)->where('subject_id', $ticket->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'num' => $ticket->ticket_num,
                'ticket' => $ticket->name,
                'description' => $ticket->description,
                'cost' => '₱' . number_format($ticket->estimated_cost, 2, '.', ','),
                'priority_name' => $ticket->priority->name,
                'priority_color' => $ticket->priority->color->class,
                'progress_name' => $ticket->progress->name,
                'progress_badge' => $ticket->progress->badge->class,
                'progress_legend' => $ticket->progress->legend->class,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $ticket->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $ticket->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the ticket request record. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketRequest $request)
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
    public function destroy(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            $ticket->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The ticket request has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the request. Please try again later.',
            ], 500);
        }
    }
}
