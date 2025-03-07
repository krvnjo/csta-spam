<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($username)
    {
        if (Auth::user()->user_name !== $username) {
            abort(404);
        }
        return view('pages.other.user-account');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $user = User::findOrFail(Crypt::decryptString($request->input('id')));

            if ($request->has(['id', 'email', 'phone']) || $request->hasFile('image')) {
                $accountValidationMessages = [
                    'email.required' => 'Please enter an email address!',
                    'email.max' => 'The email address must not exceed :max characters.',
                    'email.email' => 'This email is incorrect format!',
                    'email.unique' => 'This email is already taken!',

                    'phone.regex' => 'The phone number must follow the format: 09##-###-####.',
                    'phone.unique' => 'This phone number is already taken!',

                    'image.image' => 'The file must be an image.',
                    'image.mimes' => 'Only jpeg, png, jpg formats are allowed.',
                    'image.max' => 'Image size must not exceed 2MB.',
                ];

                $accountValidator = Validator::make($request->all(), [
                    'email' => [
                        'required',
                        'max:100',
                        'email',
                        Rule::unique('users', 'email')->ignore($user->id)
                    ],
                    'phone' => [
                        'nullable',
                        'regex:/^(09)\d{2}-\d{3}-\d{4}$/',
                        Rule::unique('users', 'phone_num')->ignore($user->id)
                    ],
                    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ], $accountValidationMessages);

                if ($accountValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $accountValidator->errors(),
                    ]);
                }
                $user->email = trim($request->input('email'));
                $user->phone_num = trim($request->input('phone'));

                if ($request->hasFile('image')) {
                    if ($user->user_image && $user->user_image !== 'default.jpg') {
                        Storage::delete('public/img/user-images/' . $user->user_image);
                    }

                    $image = $request->file('image');
                    $filename = time() . "-" . $user->id . '.' . $image->getClientOriginalExtension();

                    $image->storeAs('public/img/user-images', $filename);

                    $user->user_image = $filename;
                } else {
                    if ($request->input('avatar') === 'default.jpg' && $user->user_image !== 'default.jpg') {
                        Storage::delete('public/img/user-images/' . $user->user_image);
                        $user->user_image = 'default.jpg';
                    }
                }
            } elseif ($request->has('current', 'new', 'confirm')) {
                $passwordValidationMessages = [
                    'current.required' => 'Please enter your current password!',
                    'current.incorrect' => 'Incorrect password!',

                    'new.required' => 'Please enter your new password!',
                    'new.min' => 'It must be at least :min characters long!',
                    'new.max' => 'It must not exceed :max characters.',
                    'new.regex' => 'Your new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character!',

                    'confirm.required' => 'Please confirm your new password!',
                    'confirm.same' => 'The confirmation password does not match the new password!',
                ];
                $passwordValidator = Validator::make($request->all(), [
                    'current' => [
                        'required',
                        function ($attribute, $value, $fail) use ($user) {
                            if ($user && !Hash::check($value, $user->pass_hash)) {
                                $fail('Incorrect password!');
                            }
                        },
                    ],
                    'new' => [
                        'required',
                        'min:8',
                        'max:20',
                        'regex:/[A-Z]/',
                        'regex:/[a-z]/',
                        'regex:/[0-9]/',
                        'regex:/[\W_]/',
                    ],
                    'confirm' => [
                        'required',
                        'same:new',
                    ],
                ], $passwordValidationMessages);

                if ($passwordValidator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $passwordValidator->errors(),
                    ]);
                }
                $user->pass_hash = Hash::make($request->new);
                $user->pass_changed_at = now();
            }
            $user->save();

            return response()->json([
                'success' => true,
                'title' => 'Updated Successfully!',
                'text' => 'The account information has been updated successfully!',
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while updating the account information.',
            ], 500);
        }
    }
}
