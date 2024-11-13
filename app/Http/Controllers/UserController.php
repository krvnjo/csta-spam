<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Audit;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Throwable;

#[ObservedBy([UserObserver::class])]
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role', 'department')->where('role_id', '!=', 1)->orderBy('lname')->get();
        $roles = Role::where('id', '!=', 1)->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        $totalUsers = $users->count();

        return view('pages.user-management.user',
            compact(
                'users',
                'roles',
                'departments',
                'totalUsers'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'user_name' => trim($validated['user']),
                'pass_hash' => Hash::make($validated['pass']),
                'fname' => ucwords(trim($validated['fname'])),
                'mname' => ucwords(trim($validated['mname'])),
                'lname' => ucwords(trim($validated['lname'])),
                'role_id' => $validated['role'],
                'dept_id' => $validated['department'],
                'email' => trim($validated['email']),
                'phone_num' => trim($validated['phone'])
            ]);

            if ($request->hasFile('image')) {
                if ($user->user_image && $user->user_image !== 'default.jpg' && Storage::exists('public/img/user-images/' . $user->user_image)) {
                    Storage::delete('public/img/user-images/' . $user->user_image);
                }
                $image = $request->file('image');
                $filename = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->storeAs('public/img/user-images', $filename);
                $user->user_image = $filename;
            } else {
                if ($request->input('avatar') === 'default.jpg' && $user->user_image !== 'default.jpg') {
                    Storage::delete('public/img/user-images/' . $user->user_image);
                    $user->user_image = 'default.jpg';
                }
            }
            $user->save();

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The user has been added successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::with('role', 'department')->findOrFail($validated['id']);

            $createdBy = Audit::where('subject_type', User::class)->where('subject_id', $user->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', User::class)->where('subject_id', $user->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'user' => $user->user_name,
                'fname' => $user->fname,
                'mname' => $user->mname ? $user->mname : 'N/A',
                'lname' => $user->lname,
                'role' => $user->role->name,
                'department' => $user->department->name,
                'email' => $user->email,
                'phone' => $user->phone_num ? $user->phone_num : 'N/A',
                'login' => $user->last_login ? Carbon::parse($user->last_login)->format('D, F d, Y | h:i:s A') : 'Never',
                'image' => asset('storage/img/user-images/' . $user->user_image),
                'status' => $user->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $user->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $user->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::findOrFail($validated['id']);

            return response()->json([
                'success' => true,
                'id' => Crypt::encryptString($user->id),
                'user' => $user->user_name,
                'fname' => $user->fname,
                'mname' => $user->mname,
                'lname' => $user->lname,
                'role' => $user->role_id,
                'department' => $user->dept_id,
                'email' => $user->email,
                'phone' => $user->phone_num,
                'image' => asset('storage/img/user-images/' . $user->user_image),
                'auth' => Auth::user()->id === $user->id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::findOrFail($validated['id']);

            if (!isset($validated['status'])) {
                if (isset($validated['pass'])) {
                    if (Hash::check($validated['pass'], $user->pass_hash)) {
                        return response()->json([
                            'success' => false,
                            'errors' => ['pass' => ['The new password cannot be the same as your current password!']]
                        ]);
                    }
                    $user->pass_hash = Hash::make($validated['pass']);
                }

                $user->update([
                    'user_name' => trim($validated['user']),
                    'fname' => ucwords(trim($validated['fname'])),
                    'mname' => ucwords(trim($validated['mname'])),
                    'lname' => ucwords(trim($validated['lname'])),
                    'role_id' => $validated['role'],
                    'dept_id' => $validated['department'],
                    'email' => trim($validated['email']),
                    'phone_num' => trim($validated['phone'])
                ]);

                if ($request->hasFile('image')) {
                    if ($user->user_image && $user->user_image !== 'default.jpg' && Storage::exists('public/img/user-images/' . $user->user_image)) {
                        Storage::delete('public/img/user-images/' . $user->user_image);
                    }
                    $image = $request->file('image');
                    $filename = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->storeAs('public/img/user-images', $filename);
                    $user->user_image = $filename;
                } else {
                    if ($request->input('avatar') === 'default.jpg' && $user->user_image !== 'default.jpg') {
                        Storage::delete('public/img/user-images/' . $user->user_image);
                        $user->user_image = 'default.jpg';
                    }
                }
                $user->save();
            } else {
                $user->update([
                    'is_active' => $validated['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The user has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::findOrFail($validated['id']);

            if ($user->audits->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The user cannot be deleted because it is still being used by other records.',
                ], 400);
            }

            $user->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The user has been deleted permanently.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the user. Please try again later.',
            ], 500);
        }
    }
}
