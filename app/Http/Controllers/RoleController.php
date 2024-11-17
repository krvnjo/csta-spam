<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Access;
use App\Models\Audit;
use App\Models\Dashboard;
use App\Models\Permission;
use App\Models\Role;
use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

#[ObservedBy([RoleObserver::class])]
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with(['rolePermissions.permission', 'rolePermissions.access'])->where('id', '!=', 1)->orderBy('name')->get();
        $permissions = Permission::with('roles')->get();
        $accesses = Access::with('roles')->get();
        $dashboards = Dashboard::with('roles')->get();

        return view('pages.user-management.role',
            compact(
                'roles',
                'permissions',
                'accesses',
                'dashboards'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roleValidationMessages = [
            'role.required' => 'Please enter a role name!',
            'role.regex' => 'It must not contain special symbols and multiple spaces.',
            'role.min' => 'The role name must be at least :min characters.',
            'role.max' => 'The role name may not be greater than :max characters.',
            'role.unique' => 'This role name already exists.',

            'description.required' => 'Please enter a description!',
            'description.regex' => 'It must not contain consecutive spaces and symbols.',
            'description.min' => 'The description code must be at least :min characters.',
            'description.unique' => 'This description already exists.',

            'dashboard.required' => 'Please select a main dashboard!',
        ];

        try {
            $roleValidator = Validator::make($request->all(), [
                'role' => [
                    'required',
                    'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                    'min:3',
                    'max:75',
                    'unique:roles,name'
                ],
                'description' => [
                    'required',
                    'regex:/^(?!.*[ -]{2,}).*$/',
                    'min:10',
                    'unique:roles,description'
                ],
                'dashboard' => [
                    'required',
                ],
            ], $roleValidationMessages);

            if ($roleValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $roleValidator->errors(),
                ]);
            }

            $permissionsFilled = false;
            $permissionsData = [];
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'permission') && !empty($value)) {
                    $permId = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                    $accessId = (int)$value;

                    $permissionsData[] = [
                        'perm_id' => $permId,
                        'access_id' => $accessId,
                    ];

                    $permissionsFilled = true;
                }
            }

            if (!$permissionsFilled) {
                return response()->json([
                    'success' => false,
                    'errors' => ['permission' => ['Please select at least 1 permission to add']],
                ]);
            }

            $role = Role::create([
                'name' => ucwords(trim($request->input('role'))),
                'description' => ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.'),
                'dash_id' => $request->input('dashboard'),
            ]);

            $role->permissions()->sync($permissionsData);

            return response()->json([
                'success' => true,
                'title' => 'Saved Successfully!',
                'text' => 'The role has been added successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while adding the role. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleRequest $request)
    {
        try {
            $validated = $request->validated();

            $role = Role::with('rolePermissions.permission', 'rolePermissions.access')->findOrFail($validated['id']);
            $permissions = $role->rolePermissions->map(function ($rolePermission) {
                return $rolePermission->permission->name . ': ' . $rolePermission->access->name;
            });

            $createdBy = Audit::where('subject_type', Role::class)->where('subject_id', $role->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Role::class)->where('subject_id', $role->id)->where('event_id', 2)->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'role' => $role->name,
                'description' => $role->description,
                'dashboard' => $role->dashboard->name,
                'permissions' => $permissions,
                'status' => $role->is_active,
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $role->created_at->format('D, M d, Y | h:i A'),
                'updated_img' => $updatedDetails['image'],
                'updated_by' => $updatedDetails['name'],
                'updated_at' => $role->updated_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the role. Please try again later.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $role = Role::with('rolePermissions.access')->findOrFail(Crypt::decryptString($request->input('id')));

            $permissionsWithAccess = $role->rolePermissions->map(function ($rolePermission) {
                return [
                    'perm_id' => $rolePermission->perm_id,
                    'access_id' => $rolePermission->access_id,
                ];
            });

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'role' => $role->name,
                'description' => $role->description,
                'dashboard' => $role->dash_id,
                'permissions' => $permissionsWithAccess,
                'auth' => Auth::user()->role_id === $role->id,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the role. Please try again later.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $role = Role::findOrFail(Crypt::decryptString($request->input('id')));

            $roleValidationMessages = [
                'role.required' => 'Please enter a role name!',
                'role.regex' => 'It must not contain special symbols and multiple spaces.',
                'role.min' => 'The role name must be at least :min characters.',
                'role.max' => 'The role name may not be greater than :max characters.',
                'role.unique' => 'This role name already exists.',

                'description.required' => 'Please enter a description!',
                'description.regex' => 'It must not contain consecutive spaces and symbols.',
                'description.min' => 'The description code must be at least :min characters.',
                'description.unique' => 'This description already exists.',

                'dashboard.required' => 'Please select a main dashboard!',
            ];

            if (!$request->has('status')) {
                $roleValidator = Validator::make($request->all(), [
                    'role' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:75',
                        Rule::unique('roles', 'name')->ignore($role->id),
                    ],
                    'description' => [
                        'required',
                        'regex:/^(?!.*[ -]{2,}).*$/',
                        'min:10',
                        Rule::unique('roles', 'description')->ignore($role->id),
                    ],
                    'dashboard' => [
                        'required',
                    ],
                ], $roleValidationMessages);

                if ($roleValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $roleValidator->errors(),
                    ]);
                }

                $permissionsFilled = false;
                $permissionsData = [];
                foreach ($request->all() as $key => $value) {
                    if (str_starts_with($key, 'permission') && !empty($value)) {
                        $permId = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                        $accessId = (int)$value;

                        $permissionsData[] = [
                            'perm_id' => $permId,
                            'access_id' => $accessId,
                        ];

                        $permissionsFilled = true;
                    }
                }

                if (!$permissionsFilled) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['permission' => ['Please select at least one permission to add']],
                    ]);
                }

                $role->name = ucwords(trim($request->input('role')));
                $role->description = ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.');
                $role->dash_id = $request->input('dashboard');

                $role->permissions()->detach();
                $role->permissions()->sync($permissionsData);
            } else {
                $role->is_active = $request->input('status');
            }
            $role->save();

            $cacheKey = "role_permissions.{$role->id}";
            Cache::forget($cacheKey);

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The role has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the role. Please try again later.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleRequest $request)
    {
        try {
            $validated = $request->validated();

            $role = Role::findOrFail($validated['id']);

            if ($role->users->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The role cannot be deleted because it has associated users.',
                ], 400);
            }

            $role->forceDelete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The role has been deleted permanently.',
            ]);

        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the role. Please try again later.',
            ], 500);
        }
    }
}
