<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role', 'department')->whereNull('deleted_at')->get();
        $roles = Role::whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
        $depts = Department::whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');

        $totalUsers = $users->count();

        return view('pages.user-management.user',
            compact(
                'users',
                'roles',
                'depts',
                'totalUsers',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userValidationMessages = [
            'fname.required' => 'Please enter a user name!',
            'fname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'fname.min' => 'The first name must be at least :min characters.',
            'fname.max' => 'The first name may not be greater than :max characters.',

            'mname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'mname.min' => 'The middle name must be at least :min characters.',
            'mname.max' => 'The middle name may not be greater than :max characters.',

            'lname.required' => 'Please enter a last name!',
            'lname.regex' => 'It must not contain numbers, special symbols, and multiple spaces.',
            'lname.min' => 'The last name must be at least :min characters.',
            'lname.max' => 'The last name may not be greater than :max characters.',

            'role.required' => 'Please select a role!',
            'dept.required' => 'Please select a department!',

            'email.required' => 'Please enter email address!',
            'email.email' => 'This email is invalid!',
            'email.unique' => 'This email is already taken!',

            'phone.regex' => 'The phone number must follow the format: 09##-###-####.',
            'phone.unique' => 'This phone number is already taken!',

            'user.required' => 'Please enter a username!',
            'user.regex' => 'The username must follow the format ##-#####.',
            'user.unique' => 'This username is already taken!',
        ];

        try {
            $userValidator = Validator::make($request->all(), [
                'fname' => [
                    'required',
                    'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                    'min:2',
                    'max:50',
                ],
                'mname' => [
                    'nullable',
                    'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                    'min:2',
                    'max:50',
                ],
                'lname' => [
                    'required',
                    'regex:/^(?!.*([ \'\-])\1)[a-zA-ZÀ-ÖØ-öø-ÿ\']+(?:[ \'\-][a-zA-ZÀ-ÖØ-öø-ÿ\']+)*$/',
                    'min:2',
                    'max:50',
                ],
                'role' => [
                    'required',
                ],
                'dept' => [
                    'required',
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:users,email',
                ],
                'phone' => [
                    'nullable',
                    'regex:/^(09)\d{2}-\d{3}-\d{4}$/',
                    'unique:users,phone_num'
                ],
                'user' => [
                    'required',
                    'regex:/^(0[7-9]|1\d|2[0-' . (int)date('y') . '])-\d{5}$/',
                    'unique:users,user_name'
                ],
            ], $userValidationMessages);

            if ($userValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $userValidator->errors(),
                ]);
            } else {
                User::query()->create([
                    'fname' => ucwords(trim($request->input('fname'))),
                    'mname' => ucwords(trim($request->input('mname'))),
                    'lname' => ucwords(trim($request->input('lname'))),
                    'role_id' => $request->input('role'),
                    'dept_id' => $request->input('dept'),
                    'email' => trim($request->input('email')),
                    'phone_num' => trim($request->input('phone')),
                    'user_name' => trim($request->input('user')),
                    'pass_hash' => bcrypt('Spampass123!'),
                    'user_image' => 'default.jpg',
                    'is_active' => 1,
                ]);

                return response()->json([
                    'success' => true,
                    'title' => 'Saved Successfully!',
                    'text' => 'The user has been added successfully!',
                ]);
            }
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
    public function show(Request $request)
    {
        try {
            $user = User::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'user' => $user->user_name,
                'fname' => $user->fname,
                'mname' => $user->mname,
                'lname' => $user->lname,
                'role' => $user->role->name,
                'dept' => $user->department->name,
                'email' => $user->email,
                'phone' => $user->phone_num,
                'image' => $user->user_image,
                'status' => $user->is_active,
                'created' => $user->created_at->format('D, F d, Y | h:i:s A'),
                'updated' => $user->updated_at->format('D, F d, Y | h:i:s A'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the user.',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $user = User::query()->findOrFail(Crypt::decryptString($request->input('id')));

            return response()->json([
                'success' => true,
                'id' => $request->input('id'),
                'user' => $user->user_name,
                'fname' => $user->fname,
                'mname' => $user->mname,
                'lname' => $user->lname,
                'role' => $user->role_id,
                'dept' => $user->dept_id,
                'email' => $user->email,
                'phone' => $user->phone_num,
                'image' => $user->user_image,
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the user.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
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

            $users = User::query()->whereIn('id', $ids)->get();

            foreach ($users as $user) {
                $user->is_active = 0;
                $user->save();
                $user->delete();
            }

            return response()->json([
                'success' => true,
                'title' => 'Deleted Successfully!',
                'text' => count($users) > 1 ? 'The users have been deleted and can be restored from the bin.' : 'The user has been deleted and can be restored from the bin.',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while deleting the user.',
            ], 500);
        }
    }
}
