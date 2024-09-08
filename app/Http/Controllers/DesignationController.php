<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('department')->orderBy('name')->get();
        $departments = Department::query()->orderBy('name')->get();

        $totalDesignations = $designations->count();
        $activeDesignations = $designations->where('is_active', 1)->count();
        $inactiveDesignations = $designations->where('is_active', 0)->count();

        $activePercentage = $totalDesignations > 0 ? ($activeDesignations / $totalDesignations) * 100 : 0;
        $inactivePercentage = $totalDesignations > 0 ? ($inactiveDesignations / $totalDesignations) * 100 : 0;

        return view('pages.file-maintenance.designation', compact('designations', 'departments', 'totalDesignations', 'activeDesignations', 'inactiveDesignations', 'activePercentage', 'inactivePercentage'));
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
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        //
    }
}
