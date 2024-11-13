<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Audit;
use App\Models\Department;
use App\Observers\DepartmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([DepartmentObserver::class])]
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::orderBy('name')->get();

        $totalDepartments = $departments->count();
        $unusedDepartments = Department::doesntHave('designations')->doesntHave('users')->count();
        $activeDepartments = $departments->where('is_active', 1)->count();
        $inactiveDepartments = $totalDepartments - $activeDepartments;

        $activePercentage = $totalDepartments ? ($activeDepartments / $totalDepartments) * 100 : 0;
        $inactivePercentage = $totalDepartments ? ($inactiveDepartments / $totalDepartments) * 100 : 0;

        return view('pages.file-maintenance.department',
            compact(
                'departments',
                'totalDepartments',
                'unusedDepartments',
                'activeDepartments',
                'inactiveDepartments',
                'activePercentage',
                'inactivePercentage'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();

            Department::create([
                'name' => $this->formatInput($validated['department']),
                'code' => strtoupper(trim($validated['code'])),
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'A new department has been added successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the department. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();

            $department = Department::with('designations')->findOrFail($validated['id']);
            $designations = $department->designations()->orderBy('name')->pluck('name')->toArray();

            $createdBy = Audit::where('subject_type', Department::class)->where('subject_id', $department->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Department::class)->where('subject_id', $department->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'department' => $department->name,
                'code' => $department->code,
                'designations' => $designations,
                'status' => $department->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $department->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $department->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the department. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();

            $department = Department::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($department->id),
                'department' => $department->name,
                'code' => $department->code,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the department. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();

            $department = Department::findOrFail($validated['id']);

            if (!isset($validated['status'])) {
                $department->update([
                    'name' => $this->formatInput($validated['department']),
                    'code' => strtoupper(trim($validated['code'])),
                ]);
            } else {
                $department->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The department has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the department. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentRequest $request)
    {
        try {
            $validated = $request->validated();

            $department = Department::findOrFail($validated['id']);

            if ($department->designations->count() > 0 || $department->users->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The department cannot be deleted because it is still being used by other records.',
                ], 400);
            }

            $department->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The department has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the department. Please try again later.',
            ], 500);
        }
    }
}
