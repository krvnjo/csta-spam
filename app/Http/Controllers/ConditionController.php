<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conditions = Condition::whereNull('deleted_at')->get();

        $totalConditions = $conditions->count();
        $deletedConditions = Condition::onlyTrashed()->count();
        $activeConditions = $conditions->where('is_active', 1)->count();
        $inactiveConditions = $totalConditions - $activeConditions;

        $activePercentage = $totalConditions ? ($activeConditions / $totalConditions) * 100 : 0;
        $inactivePercentage = $totalConditions ? ($inactiveConditions / $totalConditions) * 100 : 0;

        return view('pages.file-maintenance.condition',
            compact(
                'conditions',
                'totalConditions',
                'deletedConditions',
                'activeConditions',
                'inactiveConditions',
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
        $conditionValidationMessages = [
            'condition.required' => 'Please enter a condition name!',
            'condition.regex' => 'It must not contain special symbols and multiple spaces.',
            'condition.min' => 'The condition name must be at least :min characters.',
            'condition.max' => 'The condition name may not be greater than :max characters.',
            'condition.unique' => 'This condition name already exists.',

            'description.required' => 'Please enter a description!',
            'description.regex' => 'It must not contain consecutive spaces and symbols.',
            'description.min' => 'The description code must be at least :min characters.',
            'description.unique' => 'This description already exists.',
        ];

        try {
            $conditionValidator = Validator::make($request->all(), [
                'condition' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:75',
                    'unique:conditions,name'
                ],
                'description' => [
                    'required',
                    'regex:/^(?!.*[ -]{2,}).*$/',
                    'min:10',
                    'unique:conditions,description'
                ],
            ], $conditionValidationMessages);

            if ($conditionValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $conditionValidator->errors(),
                ]);
            } else {
                Condition::query()->create([
                    'name' => $this->formatInput($request->input('condition')),
                    'description' => ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.'),
                    'is_active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The condition has been added successfully!',
                ]);
            }
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the condition. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $condition = Condition::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'condition' => $condition->name,
                'description' => $condition->description,
                'status' => $condition->is_active,
                'created' => $condition->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $condition->updated_at->format('D, F d, Y | h:i:s A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the condition.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $condition = Condition::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'condition' => $condition->name,
                'description' => $condition->description,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the condition.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $condition = Condition::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'condition', 'description'])) {
                $conditionValidationMessages = [
                    'condition.required' => 'Please enter a condition name!',
                    'condition.regex' => 'It must not contain special symbols and multiple spaces.',
                    'condition.min' => 'The condition name must be at least :min characters.',
                    'condition.max' => 'The condition name may not be greater than :max characters.',
                    'condition.unique' => 'This condition name already exists.',

                    'description.required' => 'Please enter a description!',
                    'description.regex' => 'It must not contain consecutive spaces and symbols.',
                    'description.min' => 'The description code must be at least :min characters.',
                    'description.unique' => 'This description already exists.',
                ];

                $conditionValidator = Validator::make($request->all(), [
                    'condition' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:75',
                        Rule::unique('conditions', 'name')->ignore($condition->id)
                    ],
                    'description' => [
                        'required',
                        'regex:/^(?!.*[ -]{2,}).*$/',
                        'min:10',
                        Rule::unique('conditions', 'description')->ignore($condition->id)
                    ],
                ], $conditionValidationMessages);

                if ($conditionValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $conditionValidator->errors(),
                    ]);
                } else {
                    $condition->name = $this->formatInput($request->input('condition'));
                    $condition->description = ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.');
                }
            } elseif ($request->has('status')) {
                $condition->is_active = $request->input('status');
            }
            $condition->updated_at = now();
            $condition->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The condition has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the condition.',
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

            $conditions = Condition::query()->whereIn('id', $ids)->get();

            foreach ($conditions as $condition) {
                $condition->is_active = 0;
                $condition->save();
                $condition->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($conditions) > 1 ? 'The conditions have been deleted and can be restored from the bin.' : 'The condition has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the condition.',
            ], 500);
        }
    }
}
