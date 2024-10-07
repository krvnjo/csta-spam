<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auth.login');
    }

    /**
     * Authenticate the user and log the user in.
     */
    public function login(Request $request)
    {
        $userLoginValidationMessages = [
            'user.required' => 'Please enter a username!',
            'user.regex' => 'The username must follow the format ##-#####.',
            'user.exists' => 'This username does not exist.',
            'user.is_active' => 'The username is inactive.',

            'pass.required' => 'Please enter a password!',
            'pass.min' => 'The password must be at least :min characters long.',
            'pass.max' => 'The password must not exceed :max characters.',
            'pass.incorrect' => 'Incorrect password!',
        ];

        try {
            $userLoginValidator = Validator::make($request->all(), [
                'user' => [
                    'required',
                    'regex:/^(0[7-9]|1\d|2[0-' . (int)date('y') . '])-\d{5}$/',
                    'exists:users,user_name',
                    function ($attribute, $value, $fail) {
                        $user = User::where('user_name', $value)->first();
                        if ($user && $user->is_active == 0) {
                            $fail('The username is inactive.');
                        }
                    },
                ],
                'pass' => [
                    'required',
                    'min:8',
                    'max:20',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('user_name', $request->input('user'))->first();
                        if ($user && !Hash::check($value, $user->pass_hash)) {
                            $fail('Incorrect password!');
                        }
                    },
                ],
            ], $userLoginValidationMessages);

            if ($userLoginValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $userLoginValidator->errors(),
                ]);
            }

            $user = User::where('user_name', $request->input('user'))->first();

            Auth::login($user);
            $request->session()->regenerate();

            $user->timestamps = false;
            $user->last_login = now();
            $user->save();
            $user->timestamps = true;

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard.index'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while signing in the user. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the form for forgot password.
     */
    public function forgot()
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Authenticate the user to log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
