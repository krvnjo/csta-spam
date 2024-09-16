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
        $designations = Designation::with('department')->whereNull('deleted_at')->get();
        $departments = Department::query()->whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');

        $totalDesignations = $designations->count();
        $deletedDesignations = Designation::onlyTrashed()->count();
        $activeDesignations = $designations->where('is_active', 1)->count();
        $inactiveDesignations = $designations->where('is_active', 0)->count();

        $activePercentage = $totalDesignations > 0 ? ($activeDesignations / $totalDesignations) * 100 : 0;
        $inactivePercentage = $totalDesignations > 0 ? ($inactiveDesignations / $totalDesignations) * 100 : 0;

        return view('pages.file-maintenance.designation',
            compact(
                'designations',
                'departments',
                'totalDesignations',
                'deletedDesignations',
                'activeDesignations',
                'inactiveDesignations',
                'activePercentage',
                'inactivePercentage'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
