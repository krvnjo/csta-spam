<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Progress;
use App\Models\PropertyChild;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketOngoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('priority', 'progress')->whereIn('prog_id', [4])->orderBy('created_at', 'desc')->get();
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
        //
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
