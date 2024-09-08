<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use Illuminate\Http\Request;

class AcquisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acquisitions = Acquisition::query()->orderBy('name')->get();
        $totalAcquisitions = $acquisitions->count();
        $activeAcquisitions = $acquisitions->where('is_active', 1)->count();
        $inactiveAcquisitions = $acquisitions->where('is_active', 0)->count();

        $activePercentage = $totalAcquisitions > 0 ? ($activeAcquisitions / $totalAcquisitions) * 100 : 0;
        $inactivePercentage = $totalAcquisitions > 0 ? ($inactiveAcquisitions / $totalAcquisitions) * 100 : 0;

        return view('pages.file-maintenance.acquisition', compact('acquisitions', 'totalAcquisitions', 'activeAcquisitions', 'inactiveAcquisitions', 'activePercentage', 'inactivePercentage'));
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
    public function show(Acquisition $acquisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acquisition $acquisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acquisition $acquisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acquisition $acquisition)
    {
        //
    }
}
