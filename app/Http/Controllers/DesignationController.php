<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('department')->whereNull('deleted_at')->get();
        $departments = Department::whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');

        $totalDesignations = $designations->count();
        $deletedDesignations = Designation::onlyTrashed()->count();
        $activeDesignations = $designations->where('is_active', 1)->count();
        $inactiveDesignations = $totalDesignations - $activeDesignations;

        $activePercentage = $totalDesignations ? ($activeDesignations / $totalDesignations) * 100 : 0;
        $inactivePercentage = $totalDesignations ? ($inactiveDesignations / $totalDesignations) * 100 : 0;

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
        $designationValidationMessages = [
            'designation.required' => 'Please enter a designation name!',
            'designation.regex' => 'The designation name may not contain special symbols.',
            'designation.min' => 'The designation name must be at least :min characters.',
            'designation.max' => 'The designation name may not be greater than :max characters.',
            'designation.unique' => 'This designation name already exists.',

            'department.required' => 'Please select a main department!',
        ];

        try {
            $designationValidator = Validator::make($request->all(), [
                'designation' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:75',
                    'unique:designations,name'
                ],
                'department' => [
                    'required',
                ],
            ], $designationValidationMessages);

            if ($designationValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $designationValidator->errors(),
                ]);
            } else {
                Designation::query()->create([
                    'name' => $this->formatDesignation($request->input('designation')),
                    'dept_id' => $request->input('department'),
                    'is active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The designation has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the designation. Please try again later.',
            ], 500);
        }
    }

    /**
     * Format Designation Input.
     */
    public function formatDesignation($input)
    {
        $words = explode(' ', trim($input));

        $formattedWords = array_map(function ($word) {
            $preserveWords = ['GYM', 'CSTA', 'STSN', 'IT', 'HM', 'TM', 'EDUC', 'SHTM', 'of', 'is', 'from', 'as'];
            if (in_array(strtoupper($word), $preserveWords)) {
                return strtoupper($word);
            }
            return ucfirst(strtolower($word));
        }, $words);

        return implode(' ', $formattedWords);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $designation = Designation::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'designation' => $designation->name,
                'department' => $designation->department->name,
                'status' => $designation->is_active,
                'created' => $designation->created_at->format('F d, Y | h:i:s A'),
                'updated' => $designation->updated_at->format('F d, Y | h:i:s A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the designation.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $designation = Designation::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'designation' => $designation->name,
                'department' => $designation->dept_id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the designation.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $designation = Designation::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'designation', 'department'])) {
                $designationValidationMessages = [
                    'designation.required' => 'Please enter a designation name!',
                    'designation.regex' => 'The designation name may not contain special symbols.',
                    'designation.min' => 'The designation name must be at least :min characters.',
                    'designation.max' => 'The designation name may not be greater than :max characters.',
                    'designation.unique' => 'This designation name already exists.',

                    'department.required' => 'Please select a main department!',
                ];

                $designationValidator = Validator::make($request->all(), [
                    'designation' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:75',
                        Rule::unique('designations', 'name')->ignore($designation->id)
                    ],
                    'department' => [
                        'required',
                    ],
                ], $designationValidationMessages);

                if ($designationValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $designationValidator->errors(),
                    ]);
                } else {
                    $designation->name = $request->input('designation');
                    $designation->dept_id = $request->input('department');
                }
            } elseif ($request->has('status')) {
                $designation->is_active = $request->input('status');
            }
            $designation->updated_at = now();
            $designation->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The designation has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the designation.',
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

            $designations = Designation::query()->whereIn('id', $ids)->get();

            foreach ($designations as $designation) {
                $designation->is_active = 0;
                $designation->save();
                $designation->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($designations) > 1 ? 'The designations have been deleted and can be restored from the bin.' : 'The designation has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the designation.',
            ], 500);
        }
    }
}
