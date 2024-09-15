<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::query()->whereNull('deleted_at')->get();
        $colors = Color::query()->get();

        $totalStatuses = $statuses->count();
        $deletedStatuses = Status::onlyTrashed()->count();
        $activeStatuses = $statuses->where('is_active', 1)->count();
        $inactiveStatuses = $statuses->where('is_active', 0)->count();

        $activePercentage = $totalStatuses > 0 ? ($activeStatuses / $totalStatuses) * 100 : 0;
        $inactivePercentage = $totalStatuses > 0 ? ($inactiveStatuses / $totalStatuses) * 100 : 0;

        return view('pages.file-maintenance.status',
            compact(
                'statuses',
                'colors',
                'totalStatuses',
                'deletedStatuses',
                'activeStatuses',
                'inactiveStatuses',
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
        $statusValidationMessages = [
            'status.required' => 'Please enter a status name!',
            'status.regex' => 'The status name may only contain letters, spaces, and hyphens.',
            'status.min' => 'The status name must be at least :min characters.',
            'status.max' => 'The status name may not be greater than :max characters.',
            'status.unique' => 'This status name already exists.',

            'description.required' => 'Please enter a status description!',
            'description.regex' => 'The status name may not contain multiple spaces.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',
            'description.unique' => 'This status description already exists.',

            'color.required' => 'Please select a status color!',
        ];

        try {
            $statusValidator = Validator::make($request->all(), [
                'status' => [
                    'required',
                    'regex:/^\s*[a-zA-Z]+(?:[ -][a-zA-Z]+)*\s*$/',
                    'min:3',
                    'max:30',
                    'unique:statuses,name'
                ],
                'description' => [
                    'required',
                    'regex:/^(?!.*\s{2,})[A-Za-z0-9\s\p{P}]+$/u',
                    'min:10',
                    'max:100',
                    'unique:statuses,description'
                ],
                'color' => [
                    'required',
                ],
            ], $statusValidationMessages);

            if ($statusValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $statusValidator->errors(),
                ]);
            } else {
                Status::query()->create([
                    'name' => ucwords(strtolower(trim($request->input('status')))),
                    'description' => rtrim(trim($request->input('description')), '.') . '.',
                    'color_id' => Crypt::decryptString($request->input('color')),
                    'is active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The status has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the status. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $status = Status::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'name' => $status->name,
                'description' => $status->description,
                'color_id' => $status->color_id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the status.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $status = Status::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has('status') || $request->has('description') || $request->has('color')) {
                $statusValidationMessages = [
                    'status.required' => 'Please enter a status name!',
                    'status.regex' => 'The status name may only contain letters, spaces, and hyphens.',
                    'status.min' => 'The status name must be at least :min characters.',
                    'status.max' => 'The status name may not be greater than :max characters.',
                    'status.unique' => 'This status name already exists.',

                    'description.required' => 'Please enter a status description!',
                    'description.regex' => 'The status name may not contain multiple spaces.',
                    'description.min' => 'The description must be at least :min characters.',
                    'description.max' => 'The description may not be greater than :max characters.',
                    'description.unique' => 'This status description already exists.',

                    'color.required' => 'Please select a status color!',
                ];

                $statusValidator = Validator::make($request->all(), [
                    'status' => [
                        'required',
                        'regex:/^\s*[a-zA-Z]+(?:[ -][a-zA-Z]+)*\s*$/',
                        'min:3',
                        'max:30',
                        Rule::unique('statuses', 'name')->ignore($status->id)
                    ],
                    'description' => [
                        'required',
                        'regex:/^(?!.*\s{2,})[A-Za-z0-9\s\p{P}]+$/u',
                        'min:10',
                        'max:100',
                        Rule::unique('statuses', 'description')->ignore($status->id)
                    ],
                    'color' => [
                        'required',
                    ],
                ], $statusValidationMessages);

                if ($statusValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $statusValidator->errors(),
                    ]);
                } else {
                    $status->name = trim($request->input('status'));
                    $status->description = strtoupper(trim($request->input('description')));
                    $status->color_id = $request->input('color');
                }
            } elseif ($request->has('statuses')) {
                $status->is_active = $request->input('statuses');
            }
            $status->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The status has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while updating the status.',
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

            $statuses = Status::query()->whereIn('id', $ids)->get();

            foreach ($statuses as $status) {
                $status->is_active = 0;
                $status->save();
                $status->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($statuses) > 1 ? 'The departments have been deleted and can be restored from the bin.' : 'The department has been deleted and can be restored from the bin.',
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
