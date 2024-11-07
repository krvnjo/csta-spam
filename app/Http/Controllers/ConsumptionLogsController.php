<?php

namespace App\Http\Controllers;

use App\Models\ConsumptionLog;
use Illuminate\Http\Request;

class ConsumptionLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consumptionLogs = ConsumptionLog::with('consumable')
            ->whereNotNull('created_at')
            ->get();


        return view('pages.property-asset.consumption-log.overview-consumption-log', compact('consumptionLogs'));
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
    public function show(ConsumptionLog $consumptionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConsumptionLog $consumptionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConsumptionLog $consumptionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConsumptionLog $consumptionLog)
    {
        //
    }
}
