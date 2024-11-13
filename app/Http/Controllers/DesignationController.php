<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Audit;
use App\Models\Department;
use App\Models\Designation;
use App\Observers\DesignationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([DesignationObserver::class])]
class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('department')->orderBy('name')->get();
        $departments = Department::where('is_active', 1)->orderBy('name')->get();

        $totalDesignations = $designations->count();
        $unusedDesignations = Designation::doesntHave('propertyChildren')->count();
        $activeDesignations = $designations->where('is_active', 1)->count();
        $inactiveDesignations = $designations->where('is_active', 0)->count();

        $activePercentage = $totalDesignations ? ($activeDesignations / $totalDesignations) * 100 : 0;
        $inactivePercentage = $totalDesignations ? ($inactiveDesignations / $totalDesignations) * 100 : 0;

        return view('pages.file-maintenance.designation',
            compact(
                'designations',
                'departments',
                'totalDesignations',
                'unusedDesignations',
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
    public function store(DesignationRequest $request)
    {
        try {
            $validated = $request->validated();

            Designation::create([
                'name' => $this->formatInput($validated['designation']),
                'dept_id' => $validated['department'],
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The designation has been added successfully!',
            ]);
        } catch (Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the designation. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignationRequest $request)
    {
        try {
            $validated = $request->validated();

            $designation = Designation::with('department')->findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', Designation::class)->where('subject_id', $designation->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Designation::class)->where('subject_id', $designation->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'designation' => $designation->name,
                'department' => $designation->department->name,
                'status' => $designation->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $designation->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $designation->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the designation. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignationRequest $request)
    {
        try {
            $validated = $request->validated();

            $designation = Designation::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($designation->id),
                'designation' => $designation->name,
                'department' => $designation->dept_id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the designation. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesignationRequest $request)
    {
        try {
            $validated = $request->validated();

            $designation = Designation::findOrFail($validated['id']);

            if (!isset($validated['status'])) {
                $designation->update([
                    'name' => $this->formatInput($validated['designation']),
                    'dept_id' => $validated['department'],
                ]);
            } else {
                $designation->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The designation has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the designation. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignationRequest $request)
    {
        try {
            $validated = $request->validated();

            $designation = Designation::findOrFail($validated['id']);

            if ($designation->propertyChildren->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The designation cannot be deleted because it is still being used by other records.',
                ], 400);
            }

            $designation->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The designation has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the designation. Please try again later.',
            ], 500);
        }
    }
}
