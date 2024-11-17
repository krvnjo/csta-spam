<?php

namespace App\Http\Controllers;

use App\Models\PropertyChild;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role->dash_id == 1) {
            return view('pages.dashboard.default'); // Pass $totalItems to the view
        }
        $propertyOverview = new PropertyOverviewController();
        $propertyChildren = PropertyChild::with(['property', 'department', 'designation', 'condition', 'status'])
            ->where('is_active', 1)
            ->get();
        $totalItems = $propertyChildren->count();
        $itemsAssigned = $propertyChildren->filter(function ($item) {
            return !is_null($item->inventory_date);
        })->count();

        return view('pages.dashboard.default', compact('totalItems','itemsAssigned'));


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
