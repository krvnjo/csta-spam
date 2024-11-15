<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\User;
use Illuminate\Http\Request;

class TicketRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = Priority::with('color')->get();
        $users = User::where('role_id', '!=', 1)->orderBy('lname')->get();

        return view('pages.repair-maintenance.request',
            compact(
                'priorities',
                'users'
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
