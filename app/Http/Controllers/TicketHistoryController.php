<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;

class TicketHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audits = Audit::with([
            'event' => function ($query) {
                $query->with(['badge', 'legend']);
            },
            'subject',
            'causer.role'
        ])->orderBy('name')->get();
        $types = Type::get();
        $events = Event::with('badge', 'legend')->get();
        $users = User::with('role')->where('role_id', '!=', 1)->orderBy('lname')->get();

        return view('pages.other.audit-history',
            compact(
                'audits',
                'types',
                'events',
                'users',
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
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
