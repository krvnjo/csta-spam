<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::query()->whereNull('deleted_at')->get();

        $totalDepartments = $departments->count();
        $deletedDepartments = Department::onlyTrashed()->count();
        $activeDepartments = $departments->where('is_active', 1)->count();
        $inactiveDepartments = $departments->where('is_active', 0)->count();

        $activePercentage = $totalDepartments > 0 ? ($activeDepartments / $totalDepartments) * 100 : 0;
        $inactivePercentage = $totalDepartments > 0 ? ($inactiveDepartments / $totalDepartments) * 100 : 0;

        return view('pages.file-maintenance.department',
            compact(
                'departments',
                'totalDepartments',
                'deletedDepartments',
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
    public function store(Request $request)
    {
        $departmentValidationMessages = [
            'department.required' => 'Please enter a department name!',
            'department.regex' => 'The department name may only contain letters, spaces, and hyphens.',
            'department.min' => 'The department name must be at least :min characters.',
            'department.max' => 'The department name may not be greater than :max characters.',
            'department.unique' => 'This department name already exists.',

            'deptcode.required' => 'Please enter a department code!',
            'deptcode.regex' => 'The department code may only contain letters and hyphens.',
            'deptcode.min' => 'The department code must be at least :min characters.',
            'deptcode.max' => 'The department code may not be greater than :max characters.',
            'deptcode.unique' => 'This department code already exists.',
        ];

        try {
            $departmentValidator = Validator::make($request->all(), [
                'department' => [
                    'required',
                    'regex:/^\s*[a-zA-Z]+(?:[ -][a-zA-Z]+)*\s*$/',
                    'min:10',
                    'max:50',
                    'unique:departments,name'
                ],
                'deptcode' => [
                    'required',
                    'regex:/^[a-zA-Z]+(?:-[a-zA-Z]+)*$/',
                    'min:2',
                    'max:15',
                    'unique:departments,dept_code'
                ],
            ], $departmentValidationMessages);

            if ($departmentValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $departmentValidator->errors(),
                ]);
            } else {
                Department::query()->create([
                    'name' => trim($request->input('department')),
                    'dept_code' => strtoupper(trim($request->input('deptcode'))),
                    'is active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The department has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the department. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $department = Department::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'name' => $department->name,
                'deptcode' => $department->dept_code
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the department.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $department = Department::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has('department') || $request->has('deptcode')) {
                $departmentValidationMessages = [
                    'department.required' => 'Please enter a department name!',
                    'department.regex' => 'The department name may only contain letters, spaces, and hyphens.',
                    'department.min' => 'The department name must be at least :min characters.',
                    'department.max' => 'The department name may not be greater than :max characters.',
                    'department.unique' => 'This department name already exists.',

                    'deptcode.required' => 'Please enter a department code!',
                    'deptcode.regex' => 'The department code may only contain letters and hyphens.',
                    'deptcode.min' => 'The department code must be at least :min characters.',
                    'deptcode.max' => 'The department code may not be greater than :max characters.',
                    'deptcode.unique' => 'This department code already exists.',
                ];

                $departmentValidator = Validator::make($request->all(), [
                    'department' => [
                        'required',
                        'regex:/^\s*[a-zA-Z]+(?:[ -][a-zA-Z]+)*\s*$/',
                        'min:10',
                        'max:50',
                        Rule::unique('departments', 'name')->ignore($department->id)
                    ],
                    'deptcode' => [
                        'required',
                        'regex:/^[a-zA-Z]+(?:-[a-zA-Z]+)*$/',
                        'min:2',
                        'max:15',
                        Rule::unique('departments', 'dept_code')->ignore($department->id)
                    ],
                ], $departmentValidationMessages);

                if ($departmentValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $departmentValidator->errors(),
                    ]);
                } else {
                    $department->name = trim($request->input('department'));
                    $department->dept_code = strtoupper(trim($request->input('deptcode')));
                }
            } elseif ($request->has('status')) {
                $department->is_active = $request->input('status');
            }
            $department->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The department has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while updating the department.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('id');

            if (!is_array($ids)) {
                $ids = [$ids];
            }

            $ids = array_map(function ($id) {
                return Crypt::decryptString($id);
            }, $ids);

            $departments = Department::query()->whereIn('id', $ids)->get();

            foreach ($departments as $department) {
                $department->is_active = 0;
                $department->save();
                $department->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($departments) > 1 ? 'The departments have been deleted and can be restored from the bin.' : 'The department has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the department.',
            ], 500);
        }
    }
}
