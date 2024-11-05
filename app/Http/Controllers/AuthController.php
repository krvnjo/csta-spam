<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
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
        try {
            $request->merge([
                'user' => trim($request->input('user') ?? ''),
                'pass' => trim($request->input('pass') ?? ''),
            ]);

            $userLoginValidator = Validator::make($request->all(), [
                'user' => [
                    'required',
                    'regex:/^(0[7-9]|1\d|2[0-' . (int)date('y') . '])-\d{5}$/',
                    'exists:users,user_name',
                ],
                'pass' => [
                    'required',
                    'min:8',
                    'max:20',
                ],
            ], [
                'user.required' => 'Please enter a username!',
                'user.regex' => 'The username must follow the format ##-#####.',
                'user.exists' => 'This username does not exist.',

                'pass.required' => 'Please enter a password!',
                'pass.min' => 'It must be at least :min characters.',
                'pass.max' => 'It must not exceed :max characters.',
            ]);

            if ($userLoginValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $userLoginValidator->errors(),
                ]);
            }

            $user = User::where('user_name', $request->input('user'))->first();

            if (!$user || $user->is_active == 0) {
                return response()->json([
                    'success' => false,
                    'errors' => ['user' => ['The username is inactive.']],
                ]);
            }

            if (!Hash::check($request->input('pass'), $user->pass_hash)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['pass' => ['Incorrect password!']],
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();
            $user->update(['last_login' => now()]);

            activity()
                ->useLog('User Login')
                ->performedOn($user)
                ->event('login')
                ->withProperties([
                    'username' => $user->user_name,
                    'name' => $this->formatFullName($user->fname, $user->lname)
                ])
                ->log("User: '{$this->formatFullName($user->fname, $user->lname)}' has logged in to the system.");

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard.index'),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while logging in. Please try again later.',
            ], 500);
        }
    }

    /**
     * Authenticate the user to log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }

    /**
     * Display the form for forgot password.
     */
    public function forgot_index()
    {
        return view('pages.auth.forgot');
    }

    /**
     * Send a forgot password link.
     */
    public function forgot(Request $request)
    {
        try {
            $request->merge([
                'email' => trim($request->input('email') ?? '')
            ]);

            $forgotPasswordValidator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    'exists:users,email',
                ],
            ], [
                'email.required' => 'Please enter an email address!',
                'email.email' => 'Please enter a valid email address!',
                'email.exists' => 'This email does not exist.',
            ]);

            if ($forgotPasswordValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $forgotPasswordValidator->errors(),
                ]);
            }

            $status = Password::sendResetLink($request->only('email'));
            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'success' => true,
                    'title' => 'Submitted Successfully!',
                    'text' => 'Password reset link has been sent to your email successfully!',
                    'status' => __($status),
                ]);
            }

            return response()->json([
                'success' => false,
                'title' => 'Failed to Send Reset Link',
                'text' => __($status),
                'status' => __($status),
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while requesting password reset. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the form for password reset.
     */
    public function reset_index(string $token)
    {
        return view('pages.auth.reset', ['token' => $token]);
    }

    /**
     * Reset the user password.
     */
    public function reset(Request $request)
    {
        try {
            $status = Password::reset(
                $request->only('user_name', 'email', 'token') + ['password' => $request->input('pass')],
                function (User $user, string $password) {
                    // Update the user password to the hashed value
                    $user->forceFill([
                        'pass_hash' => Hash::make($password),
                    ]);

                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'success' => true,
                    'title' => 'Password Reset Successful!',
                    'text' => 'Your password has been reset successfully. You can now log in with your new password.',
                    'redirect' => route('auth.login')
                ]);
            }

            return response()->json([
                'success' => false,
                'title' => 'Failed to Reset Password',
                'text' => __($status) ?: 'An error occurred while resetting your password. Please try again.'
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while resetting password. Please try again later.',
            ], 500);
        }

    }
}
