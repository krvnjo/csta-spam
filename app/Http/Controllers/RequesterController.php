<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequesterRequest;
use App\Models\Audit;
use App\Models\Department;
use App\Models\Requester;
use App\Observers\RequesterObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Facades\Crypt;
use Throwable;

#[ObservedBy([RequesterObserver::class])]
class RequesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requesters = Requester::with('department')->orderBy('lname')->get();
        $departments = Department::orderBy('name')->get();

        $totalRequesters = $requesters->count();
        $activeRequesters = $requesters->where('is_active', 1)->count();
        $inactiveRequesters = $requesters->where('is_active', 0)->count();

        $activePercentage = $totalRequesters ? ($activeRequesters / $totalRequesters) * 100 : 0;
        $inactivePercentage = $totalRequesters ? ($inactiveRequesters / $totalRequesters) * 100 : 0;

        return view('pages.file-maintenance.requester',
            compact(
                'requesters',
                'departments',
                'totalRequesters',
                'activeRequesters',
                'inactiveRequesters',
                'activePercentage',
                'inactivePercentage'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequesterRequest $request)
    {
        try {
            $validated = $request->validated();

            Requester::create([
                'req_num' => trim($validated['requester']),
                'name' => $this->formatName($validated['fname'], $validated['mname'], $validated['lname']),
                'fname' => ucwords(trim($validated['fname'])),
                'mname' => ucwords(trim($validated['mname'])),
                'lname' => ucwords(trim($validated['lname'])),
                'dept_id' => $validated['department'],
                'email' => trim($validated['email']),
                'phone_num' => trim($validated['phone']),
            ]);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'A new requester has been added successfully!',
            ]);
        } catch (Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the requester. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequesterRequest $request)
    {
        try {
            $validated = $request->validated();

            $requester = Requester::with('department')->findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', Requester::class)->where('subject_id', $requester->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Requester::class)->where('subject_id', $requester->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'requester' => $requester->req_num,
                'fname' => $requester->fname,
                'mname' => $requester->mname ? $requester->mname : 'N/A',
                'lname' => $requester->lname,
                'department' => $requester->department->name,
                'email' => $requester->email,
                'phone' => $requester->phone_num ? $requester->phone_num : 'N/A',
                'status' => $requester->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $requester->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $requester->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the requester. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequesterRequest $request)
    {
        try {
            $validated = $request->validated();

            $requester = Requester::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($requester->id),
                'requester' => $requester->req_num,
                'fname' => $requester->fname,
                'mname' => $requester->mname,
                'lname' => $requester->lname,
                'department' => $requester->dept_id,
                'email' => $requester->email,
                'phone' => $requester->phone_num,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the requester. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequesterRequest $request)
    {
        try {
            $validated = $request->validated();

            $requester = Requester::findOrFail($validated['id']);

            if (!isset($validated['status'])) {

                $requester->update([
                    'req_num' => trim($validated['requester']),
                    'name' => $this->formatName($validated['fname'], $validated['mname'], $validated['lname']),
                    'fname' => ucwords(trim($validated['fname'])),
                    'mname' => ucwords(trim($validated['mname'])),
                    'lname' => ucwords(trim($validated['lname'])),
                    'dept_id' => $validated['department'],
                    'email' => trim($validated['email']),
                    'phone_num' => trim($validated['phone'])
                ]);
            } else {
                $requester->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The requester has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the requester. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequesterRequest $request)
    {
        try {
            $validated = $request->validated();

            $requester = Requester::findOrFail($validated['id']);

            $requester->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The requester has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the requester. Please try again later.',
            ], 500);
        }
    }
}
