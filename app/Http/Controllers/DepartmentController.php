<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::query()->orderBy('name')->get();
        $totalDepartments = $departments->count();
        $activeDepartments = $departments->where('is_active', 1)->count();
        $inactiveDepartments = $departments->where('is_active', 0)->count();

        $total = $totalDepartments;
        $activePercentage = $total > 0 ? ($activeDepartments / $total) * 100 : 0;
        $inactivePercentage = $total > 0 ? ($inactiveDepartments / $total) * 100 : 0;

        return view('pages.file-maintenance.department', compact('departments', 'totalDepartments', 'activeDepartments', 'inactiveDepartments', 'activePercentage', 'inactivePercentage'));
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
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
