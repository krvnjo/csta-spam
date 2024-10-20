<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role', 'department')->whereNull('deleted_at')->orderBy('lname')->get();
        $roles = Role::with('users')->whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');
        $depts = Department::with('users')->whereNull('deleted_at')->where('is_active', 1)->orderBy('name')->pluck('name', 'id');

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
            'user.required' => 'Please enter a username!',
            'user.regex' => 'The username must follow the format ##-#####.',
            'user.unique' => 'This username is already taken!',

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

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Only jpeg, png, jpg formats are allowed.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];

        try {
            $userValidator = Validator::make($request->all(), [
                'user' => [
                    'required',
                    'regex:/^(0[7-9]|1\d|2[0-' . (int)date('y') . '])-\d{5}$/',
                    'unique:users,user_name'
                ],
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
                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png',
                    'max:2048'
                ],
            ], $userValidationMessages);

            if ($userValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $userValidator->errors(),
                ]);
            } else {
                $user = User::query()->create([
                    'user_name' => trim($request->input('user')),
                    'pass_hash' => bcrypt('Spampass123!'),
                    'fname' => ucwords(trim($request->input('fname'))),
                    'mname' => ucwords(trim($request->input('mname'))),
                    'lname' => ucwords(trim($request->input('lname'))),
                    'role_id' => $request->input('role'),
                    'dept_id' => $request->input('dept'),
                    'email' => trim($request->input('email')),
                    'phone_num' => trim($request->input('phone')),
                    'is_active' => 1,
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
                'mname' => $user->mname ? $user->mname : 'N/A',
                'lname' => $user->lname,
                'role' => $user->role->name,
                'dept' => $user->department->name,
                'email' => $user->email,
                'phone' => $user->phone_num ? $user->phone_num : 'N/A',
                'login' => $user->last_login ? Carbon::parse($user->last_login)->format('D, F d, Y | h:i:s A') : 'Never',
                'image' => asset('storage/img/user-images/' . $user->user_image),
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
                'image' => asset('storage/img/user-images/' . $user->user_image),
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
        $user = User::query()->findOrFail(Crypt::decryptString($request->input('id')));
        try {
            if ($request->has('status')) {
                $user->is_active = $request->input('status');
            } else {
                $userValidationMessages = [
                    'user.required' => 'Please enter a username!',
                    'user.regex' => 'The username must follow the format ##-#####.',
                    'user.unique' => 'This username is already taken!',

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

                    'image.image' => 'The file must be an image.',
                    'image.mimes' => 'Only jpeg, png, jpg formats are allowed.',
                    'image.max' => 'Image size must not exceed 2MB.',
                ];

                $userValidator = Validator::make($request->all(), [
                    'user' => [
                        'required',
                        'regex:/^(0[7-9]|1\d|2[0-' . (int)date('y') . '])-\d{5}$/',
                        Rule::unique('users', 'user_name')->ignore($user->id)
                    ],
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
                        Rule::unique('users', 'email')->ignore($user->id)
                    ],
                    'phone' => [
                        'nullable',
                        'regex:/^(09)\d{2}-\d{3}-\d{4}$/',
                        Rule::unique('users', 'phone_num')->ignore($user->id)
                    ],
                    'image' => [
                        'nullable',
                        'image',
                        'mimes:jpg,jpeg,png',
                        'max:2048'
                    ],
                ], $userValidationMessages);

                if ($userValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $userValidator->errors(),
                    ]);
                }

                $user->user_name = trim($request->input('user'));
                $user->fname = ucwords(trim($request->input('fname')));
                $user->mname = ucwords(trim($request->input('mname')));
                $user->lname = ucwords(trim($request->input('lname')));
                $user->role_id = $request->input('role');
                $user->dept_id = $request->input('dept');
                $user->email = trim($request->input('email'));
                $user->phone_num = trim($request->input('phone'));

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
            }
            $user->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The user has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the user.',
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
