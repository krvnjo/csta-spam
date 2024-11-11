<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Audit;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Cache::remember('permissions_all', now()->addMinutes(10), function () {
            return Permission::get();
        });

        return view('pages.user-management.role',
            compact(
                'roles',
                'permissions'
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

            'can_view.required' => 'Please select at least one permission!',
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
                'can_view' => [
                    'required:*',
                ],
            ], $roleValidationMessages);

            if ($roleValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $roleValidator->errors(),
                ]);
            } else {
                Role::query()->create([
                    'name' => ucwords(trim($request->input('role'))),
                    'description' => ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.'),
                    'is_active' => 1,
                ]);
                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The role has been added successfully!',
                ]);
            }
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

            $role = Role::with('permissions')->findOrFail($validated['id']);
            $permissions = $role->permissions->pluck('name')->toArray();

            $createdBy = Audit::where('subject_type', Role::class)->where('subject_id', $role->id)->where('event', 'created')->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            $updatedBy = Audit::where('subject_type', Role::class)->where('subject_id', $role->id)->where('event', 'updated')->latest()->first() ?? $createdBy;
            $updatedDetails = $this->getUserAuditDetails($updatedBy);

            return response()->json([
                'success' => true,
                'role' => $role->name,
                'description' => $role->description,
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
            $role = Role::query()->findOrFail(Crypt::decryptString($request->input('id')));

            $permissions = DB::table('role_permissions')
                ->join('permissions', 'role_permissions.perm_id', '=', 'permissions.id')
                ->where('role_permissions.role_id', $role->id)
                ->select('permissions.id', 'permissions.name', 'role_permissions.can_view', 'role_permissions.can_create', 'role_has_permissions.can_edit', 'role_has_permissions.can_delete')
                ->get()
                ->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'can_view' => $permission->can_view,
                        'can_create' => $permission->can_create,
                        'can_edit' => $permission->can_edit,
                        'can_delete' => $permission->can_delete,
                    ];
                });

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'role' => $role->name,
                'description' => $role->description,
                'permissions' => $permissions,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the role.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $role = Role::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'role', 'description'])) {
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

                    'can_view.required' => 'Please select at least one permission!',
                ];

                $roleValidator = Validator::make($request->all(), [
                    'role' => [
                        'required',
                        'regex:/^(?!.*([ -])\1)[a-zA-Z0-9]+(?:[ -][a-zA-Z0-9]+)*$/',
                        'min:3',
                        'max:75',
                        Rule::unique('roles', 'name')->ignore($role->id)
                    ],
                    'description' => [
                        'required',
                        'regex:/^(?!.*[ -]{2,}).*$/',
                        'min:10',
                        Rule::unique('roles', 'description')->ignore($role->id)
                    ],
                    'can_view' => [
                        'required:*',
                    ],
                ], $roleValidationMessages);

                if ($roleValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $roleValidator->errors(),
                    ]);
                } else {
                    $role->name = ucwords(trim($request->input('role')));
                    $role->description = ucfirst(rtrim($request->input('description'))) . (str_ends_with(rtrim($request->input('description')), '.') ? '' : '.');

                    $permissions = Permission::all()->keyBy('id');

                    foreach ($permissions as $permission) {
                        $canView = isset($request->can_view[$permission->id]) ? 1 : 0;
                        $canCreate = isset($request->can_create[$permission->id]) ? 1 : 0;
                        $canEdit = isset($request->can_edit[$permission->id]) ? 1 : 0;
                        $canDelete = isset($request->can_delete[$permission->id]) ? 1 : 0;

                        if ($canView || $canCreate || $canEdit || $canDelete) {
                            DB::table('role_has_permissions')->updateOrInsert(
                                [
                                    'role_id' => $role->id,
                                    'permission_id' => $permission->id,
                                ],
                                [
                                    'can_view' => $canView,
                                    'can_create' => $canCreate,
                                    'can_edit' => $canEdit,
                                    'can_delete' => $canDelete,
                                ]
                            );
                        } else {
                            DB::table('role_has_permissions')->where([
                                'role_id' => $role->id,
                                'permission_id' => $permission->id,
                            ])->delete();
                        }
                    }
                }
            } elseif ($request->has('status')) {
                $role->is_active = $request->input('status');
            }
            $role->updated_at = now();
            $role->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The role has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the role.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $role = Role::query()->findOrFail(Crypt::decryptString($request->input('id')));

            if ($role->users->count() > 0) {
                return response()->json([
                    'success' => false,
                    'title' => 'Deletion Failed!',
                    'text' => 'The role cannot be deleted because it has associated users.',
                ], 400);
            }

            $role->is_active = 0;
            $role->save();
            $role->delete();

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => 'The role has been deleted and can be restored from the bin.',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the role.',
            ], 500);
        }
    }
}
