<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Audit;
use App\Models\Priority;
use App\Models\Progress;
use App\Models\PropertyChild;
use App\Models\Ticket;
use App\Observers\TicketRequestObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([TicketRequestObserver::class])]
class TicketRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('priority', 'progress')->whereIn('prog_id', [1, 2])->orderBy('created_at')->get();
        $priorities = Priority::with('color')->get();
        $progresses = Progress::with('legend')->whereIn('id', [1, 2])->get();
        $items = PropertyChild::whereHas('property', function ($query) {
            $query->where('is_consumable', 0);
        })
            ->whereIn('status_id', [1, 2, 3])
            ->with('property')
            ->get();

        return view('pages.repair-maintenance.request',
            compact(
                'tickets',
                'priorities',
                'progresses',
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

            $ticket = Ticket::create([
                'ticket_num' => $code,
                'name' => ucwords(trim($validated['ticket'])),
                'description' => $validated['description'],
                'estimated_cost' => $validated['cost'],
                'prio_id' => $validated['priority'],
                'prog_id' => 1,
            ]);

            foreach ($validated['items'] as $itemId) {
                $item = PropertyChild::findOrFail($itemId);
                $item->update([
                    'ticket_id' => $ticket->id,
                    'status_id' => 3,
                ]);
            }

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
            $items = $ticket->items()
                ->with('property')
                ->orderBy('prop_code')
                ->get()
                ->map(function ($item) {
                    $parentName = $item->property->name;
                    $category = $item->property->category->name;
                    $brand = $item->property->brand->name;
                    $designation = $item->designation->name;
                    return "{$item->prop_code} | {$parentName} | {$category} | {$brand} | {$designation}";
                })
                ->toArray();

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
                'items' => $items,
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
                'message' => 'An error occurred while fetching the ticket request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);
            $items = $ticket->items()->orderBy('prop_code')->pluck('id')->toArray();

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($ticket->id),
                'num' => $ticket->ticket_num,
                'ticket' => $ticket->name,
                'description' => $ticket->description,
                'cost' => $ticket->estimated_cost,
                'priority' => $ticket->prio_id,
                'items' => $items,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the ticket request. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            if (!isset($validated['progress'])) {
                $currentItems = $ticket->items->pluck('id')->toArray();

                // Sync the new items by updating the ticket_id of the items
                foreach ($validated['items'] as $newItemId) {
                    $item = PropertyChild::find($newItemId);
                    $item?->update([
                        'ticket_id' => $ticket->id,  // Assign the current ticket ID
                        'status_id' => 3, // Set status_id to 3 for newly added items
                    ]);
                }

                // Determine the removed items by comparing the current items with the new ones
                $removedItems = array_diff($currentItems, $validated['items']);

                // Update the status_id and ticket_id for removed items
                foreach ($removedItems as $removedItemId) {
                    $item = PropertyChild::find($removedItemId);
                    if ($item) {
                        // Set status_id based on inventory_date
                        $statusId = $item->inventory_date ? 2 : 1;
                        $item->update([
                            'status_id' => $statusId,  // Update status_id
                            'ticket_id' => null, // Set ticket_id to null for removed items
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
     * Remove the specified resource from storage.
     */
    public function destroy(TicketRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['id']);

            $ticket->items()->each(function ($item) {
                $statusId = $item->inventory_date ? 2 : 1;
                $item->update([
                    'status_id' => $statusId,
                ]);
            });

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
