<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketOngoingRequest;
use App\Models\Audit;
use App\Models\MaintenanceTicket;
use App\Models\Progress;
use App\Observers\TicketRequestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([TicketRequestObserver::class])]
class TicketOngoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = MaintenanceTicket::with('progress')->whereIn('prog_id', [4])->orderBy('started_at', 'desc')->get();
        $progresses = Progress::with('legend')->whereIn('id', [4, 5])->get();

        return view('pages.repair-maintenance.ongoing',
            compact(
                'tickets',
                'progresses',
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketOngoingRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = MaintenanceTicket::findOrFail($validated['id']);
            $items = $ticket->items()
                ->with('property')
                ->orderBy('prop_code')
                ->get()
                ->map(function ($item) {
                    $parentName = $item->property->name;
                    $category = $item->property->category->name;
                    $brand = $item->property->brand->name;
                    $designation = $item->designation->name;
                    $status = $item->status->name;
                    return "{$item->prop_code} | {$parentName} | {$category} | {$brand} | {$designation} | {$status}";
                })
                ->toArray();

            $createdBy = Audit::where('subject_type', MaintenanceTicket::class)->where('subject_id', $ticket->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', MaintenanceTicket::class)->where('subject_id', $ticket->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'num' => $ticket->ticket_num,
                'ticket' => $ticket->name,
                'description' => $ticket->description,
                'cost' => '₱' . number_format($ticket->cost, 2, '.', ','),
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
    public function edit(TicketOngoingRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = MaintenanceTicket::findOrFail($validated['id']);

            $items = $ticket->items()
                ->with(['property', 'property.category', 'property.brand', 'designation'])
                ->orderBy('prop_code')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => "{$item->prop_code} | {$item->property->name} | {$item->property->category->name} | {$item->property->brand->name} | {$item->designation->name}",
                    ];
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($ticket->id),
                'num' => $ticket->ticket_num,
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
    public function update(TicketOngoingRequest $request)
    {
        try {
            $validated = $request->validated();

            $ticket = MaintenanceTicket::findOrFail($validated['id']);

            $ticket->update([
                'remarks' => $validated['remarks'],
                'prog_id' => 5,
                'completed_at' => now(),
            ]);

            $requestData = $request->all();

            $ticket->items()->each(function ($item) use ($requestData) {
                foreach ($requestData as $key => $value) {
                    if (preg_match('/^(condition|status)(\d+)$/', $key, $matches)) {
                        $type = $matches[1];
                        $itemId = $matches[2];

                        if ((int)$itemId === (int)$item->id) {
                            if ($type === 'condition') {
                                $item->update(['condi_id' => $value]);
                            } elseif ($type === 'status') {
                                $item->update(['status_id' => $value]);
                            }
                        }
                    }
                }
            });

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
}
