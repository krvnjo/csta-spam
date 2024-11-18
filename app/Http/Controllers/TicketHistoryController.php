<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\MaintenanceTicket;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class TicketHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = MaintenanceTicket::with('progress')->whereIn('prog_id', [5])->orderBy('started_at', 'desc')->get();

        return view('pages.repair-maintenance.history',
            compact(
                'tickets',
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $ticket = MaintenanceTicket::findOrFail(Crypt::decryptString($request->input('id')));

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
                    $condition = $item->condition->name;
                    return "{$item->prop_code} | {$parentName} | {$category} | {$brand} | {$designation} | {$status} | {$condition}";
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
                'remarks' => $ticket->remarks,
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
}
