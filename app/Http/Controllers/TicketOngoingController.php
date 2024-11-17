<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketOngoingRequest;
use App\Models\Priority;
use App\Models\Progress;
use App\Models\PropertyChild;
use App\Models\Ticket;
use Throwable;

class TicketOngoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('priority', 'progress')->whereIn('prog_id', [3, 4])->orderBy('created_at', 'desc')->get();
        $priorities = Priority::with('color')->get();
        $progresses = Progress::with('legend')->whereIn('id', [1, 2])->get();
        $items = PropertyChild::whereHas('property', function ($query) {
            $query->where('is_consumable', 0);
        })->with('property')->get();

        return view('pages.repair-maintenance.ongoing',
            compact(
                'tickets',
                'priorities',
                'progresses',
                'items',
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketOngoingRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketOngoingRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            if (!isset($validated['progress'])) {
                $currentItems = $ticket->items->pluck('id')->toArray();

                foreach ($validated['items'] as $newItemId) {
                    $item = PropertyChild::find($newItemId);
                    $item?->update([
                        'ticket_id' => $ticket->id,
                        'status_id' => 3,
                    ]);
                }

                $removedItems = array_diff($currentItems, $validated['items']);

                foreach ($removedItems as $removedItemId) {
                    $item = PropertyChild::find($removedItemId);
                    if ($item) {
                        $statusId = $item->inventory_date ? 2 : 1;
                        $item->update([
                            'status_id' => $statusId,
                            'ticket_id' => null,
                        ]);
                    }
                }
            } else {
                $ticket->update([
                    'prog_id' => $validated['progress'],
                ]);

                if ($ticket->prog_id == 4) {
                    $ticket->items()->orderBy('prop_code')->each(function ($item) {
                        $item->update([
                            'status_id' => 4,
                        ]);
                    });
                }
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The ticket request has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the ticket request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketOngoingRequest $request)
    {
        //
    }
}
