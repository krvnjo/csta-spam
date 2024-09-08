<?php

namespace App\Http\Controllers;

use App\Models\Acquisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcquisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $acquisitions = Acquisition::query()->get();
        $totalAcquisitions = $acquisitions->count();
        $activeAcquisitions = $acquisitions->where('is_active', 1)->count();
        $inactiveAcquisitions = $acquisitions->where('is_active', 0)->count();

        $activePercentage = $totalAcquisitions > 0 ? ($activeAcquisitions / $totalAcquisitions) * 100 : 0;
        $inactivePercentage = $totalAcquisitions > 0 ? ($inactiveAcquisitions / $totalAcquisitions) * 100 : 0;

        return view('pages.file-maintenance.acquisition', compact('acquisitions', 'totalAcquisitions', 'activeAcquisitions', 'inactiveAcquisitions', 'activePercentage', 'inactivePercentage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationMessages = [
            'acquisition.required' => 'Please enter a acquisition name!',
            'acquisition.regex' => 'It must not contain any numbers and special characters.',
            'acquisition.max' => 'The acquisition name may not be greater than :max characters.',
            'acquisition.unique' => 'The acquisition name already exists.',
        ];

        $validator = Validator::make($request->all(), [
            'acquisition' => ['required', 'regex:/^[a-zA-Z]+(?:[\'\s\.\-!][a-zA-Z0-9]+)*$/', 'max:30', 'unique:acquisitions,name'],
        ], $validationMessages);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            return response()->json([
                'success' => false,
                'errors' => $errors,
                'data' => $request->all(),
            ]);
        } else {
            Acquisition::query()->create([
                'name' => trim($request->input('acquisition')),
            ]);
            return response()->json(['success' => true]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Acquisition $acquisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acquisition $acquisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acquisition $acquisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acquisition $acquisition)
    {
        //
    }
}
