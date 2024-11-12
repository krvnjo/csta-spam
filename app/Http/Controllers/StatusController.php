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
        $statuses = Status::get();
        $colors = Color::where('is_active', 1)->where('is_color', 1)->get();

        $totalStatuses = $statuses->count();
        $deletedStatuses = Status::onlyTrashed()->count();
        $activeStatuses = $statuses->where('is_active', 1)->count();
        $inactiveStatuses = $totalStatuses - $activeStatuses;

        $activePercentage = $totalStatuses ? ($activeStatuses / $totalStatuses) * 100 : 0;
        $inactivePercentage = $totalStatuses ? ($inactiveStatuses / $totalStatuses) * 100 : 0;

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
            'status.regex' => 'It must not contain special symbols and multiple spaces.',
            'status.min' => 'The status name must be at least :min characters.',
            'status.max' => 'The status name may not be greater than :max characters.',
            'status.unique' => 'This status name already exists.',

            'description.required' => 'Please enter a description!',
            'description.regex' => 'It must not contain consecutive spaces or symbols.',
            'description.min' => 'The description code must be at least :min characters.',
            'description.unique' => 'This description already exists.',

            'color.required' => 'Please select a color!'
        ];

        try {
            $statusValidator = Validator::make($request->all(), [
                'status' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:75',
                    'unique:statuses,name'
                ],
                'description' => [
                    'required',
                    'regex:/^(?!.*[ -]{2,}).*$/',
                    'min:10',
                    'unique:statuses,description'
                ],
                'color' => [
                    'required'
                ],
            ], $statusValidationMessages);

            if ($statusValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $statusValidator->errors()
                ]);
            } else {
                Status::query()->create([
                    'name' => $this->formatInput($request->input('status')),
                    'description' => ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.'),
                    'color_id' => $request->input('color'),
                    'is_active' => 1
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The status has been added successfully!'
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the status. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $status = Status::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'statusname' => $status->name,
                'description' => $status->description,
                'color' => $status->color->class,
                'status' => $status->is_active,
                'created' => $status->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $status->updated_at->format('D, F d, Y | h:i:s A')
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the status.'
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
                'status' => $status->name,
                'description' => $status->description,
                'color' => $status->color_id
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

            if ($request->has(['id', 'statusname', 'description', 'color'])) {
                $statusValidationMessages = [
                    'statusname.required' => 'Please enter a status name!',
                    'statusname.regex' => 'It must not contain special symbols and multiple spaces.',
                    'statusname.min' => 'The status name must be at least :min characters.',
                    'statusname.max' => 'The status name may not be greater than :max characters.',
                    'statusname.unique' => 'This status name already exists.',

                    'description.required' => 'Please enter a description!',
                    'description.regex' => 'It must not contain consecutive spaces or symbols.',
                    'description.min' => 'The description code must be at least :min characters.',
                    'description.unique' => 'This description already exists.',

                    'color.required' => 'Please select a color!'
                ];

                $statusValidator = Validator::make($request->all(), [
                    'statusname' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:75',
                        Rule::unique('statuses', 'name')->ignore($status->id)
                    ],
                    'description' => [
                        'required',
                        'regex:/^(?!.*[ -]{2,}).*$/',
                        'min:10',
                        Rule::unique('statuses', 'description')->ignore($status->id)
                    ],
                    'color' => [
                        'required'
                    ],
                ], $statusValidationMessages);

                if ($statusValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $statusValidator->errors()
                    ]);
                } else {
                    $status->name = $this->formatInput($request->input('statusname'));
                    $status->description = ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.');
                    $status->color_id = $request->input('color');
                }
            } elseif ($request->has('status')) {
                $status->is_active = $request->input('status');
            }
            $status->updated_at = now();
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
                'text' => 'An error occurred while updating the status.',
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
                'text' => count($statuses) > 1 ? 'The statuses have been deleted and can be restored from the bin.' : 'The status has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the status.',
            ], 500);
        }
    }
}
