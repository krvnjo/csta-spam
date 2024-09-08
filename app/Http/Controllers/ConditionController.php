<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conditions = Condition::query()->orderBy('name')->get();
        $totalConditions = $conditions->count();
        $activeConditions = $conditions->where('is_active', 1)->count();
        $inactiveConditions = $conditions->where('is_active', 0)->count();

        $activePercentage = $totalConditions > 0 ? ($activeConditions / $totalConditions) * 100 : 0;
        $inactivePercentage = $totalConditions > 0 ? ($inactiveConditions / $totalConditions) * 100 : 0;

        return view('pages.file-maintenance.condition', compact('conditions', 'totalConditions', 'activeConditions', 'inactiveConditions', 'activePercentage', 'inactivePercentage'));
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
    public function show(Condition $condition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Condition $condition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Condition $condition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Condition $condition)
    {
        //
    }
}
