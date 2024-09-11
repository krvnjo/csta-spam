<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AcquisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acquisitions = Acquisition::query()->whereNull('deleted_at')->get();
        $totalAcquisitions = $acquisitions->count();

        $activeAcquisitions = $acquisitions->where('is_active', 1)->count();
        $inactiveAcquisitions = $acquisitions->where('is_active', 0)->count();

        $deletedAcquisitions = Acquisition::withTrashed()->get();
        $deletedAcquisitions = $deletedAcquisitions->whereNotNull('deleted_at')->count();

        $activePercentage = $totalAcquisitions > 0 ? ($activeAcquisitions / $totalAcquisitions) * 100 : 0;
        $inactivePercentage = $totalAcquisitions > 0 ? ($inactiveAcquisitions / $totalAcquisitions) * 100 : 0;

        return view('pages.file-maintenance.acquisition',
            compact(
                'acquisitions',
                'totalAcquisitions',
                'activeAcquisitions',
                'inactiveAcquisitions',
                'deletedAcquisitions',
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
        $acquisitionValidationMessages = [
            'acquisition.required' => 'Please enter an acquisition name!',
            'acquisition.regex' => 'The acquisition name may only contain letters, spaces, and hyphens.',
            'acquisition.min' => 'The acquisition name must be at least :min characters.',
            'acquisition.max' => 'The acquisition name may not be greater than :max characters.',
            'acquisition.unique' => 'This acquisition name already exists.',
        ];

        $acquisitionValidator = Validator::make($request->all(), [
            'acquisition' => [
                'required',
                'regex:/^[a-zA-Z]+(?:[\- ][a-zA-Z]+)*$/',
                'min:3',
                'max:30',
                'unique:acquisitions,name'
            ],
        ], $acquisitionValidationMessages);

        if ($acquisitionValidator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $acquisitionValidator->errors(),
            ]);
        } else {
            Acquisition::query()->create([
                'name' => ucwords(strtolower(trim($request->input('acquisition')))),
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The acquisition has been added successfully!',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $acquisition = Acquisition::query()->findOrFail(Crypt::decryptString($request->input('id')));

        return response()->json([
            'id' => $request->input('id'),
            'name' => $acquisition->name
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $acquisition = Acquisition::query()->findOrFail(Crypt::decryptString($request->input('id')));

        if ($request->has('acquisition')) {
            $acquisitionValidationMessages = [
                'acquisition.required' => 'Please enter an acquisition name!',
                'acquisition.regex' => 'The acquisition name may only contain letters, spaces, and hyphens.',
                'acquisition.min' => 'The acquisition name must be at least :min characters.',
                'acquisition.max' => 'The acquisition name may not be greater than :max characters.',
                'acquisition.unique' => 'This acquisition name already exists.',
            ];

            $acquisitionValidator = Validator::make($request->all(), [
                'acquisition' => [
                    'required',
                    'regex:/^[a-zA-Z]+(?:[\- ][a-zA-Z]+)*$/',
                    'min:3',
                    'max:30',
                    Rule::unique('acquisitions', 'name')->ignore($acquisition->id)
                ],
            ], $acquisitionValidationMessages);

            if ($acquisitionValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $acquisitionValidator->errors(),
                ]);
            } else {
                $acquisition->name = ucwords(strtolower(trim($request->input('acquisition'))));
                $acquisition->save();
            }
        } elseif ($request->has('status')) {
            $acquisition->is_active = $request->input('status');
            $acquisition->save();
        }
        return response()->json([
            'success' => true,
            'title' => 'Updated Successfully!',
            'text' => 'The acquisition has been updated successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('id');

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $ids = array_map(function ($id) {
            return Crypt::decryptString($id);
        }, $ids);

        $acquisitions = Acquisition::query()->whereIn('id', $ids)->get();

        foreach ($acquisitions as $acquisition) {
            $acquisition->is_active = 0;
            $acquisition->save();
            $acquisition->delete();
        }

        return response()->json([
            'success' => true,
            'title' => 'Deleted Successfully!',
            'text' => count($acquisitions) > 1 ? 'The acquisitions have been deleted and can be restored from the recycle bin.' : 'The acquisition has been deleted and can be restored from the recycle bin.',
        ]);
    }
}
