<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Throwable;

class PasswordController extends Controller
{
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
    public function forgot(PasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::firstWhere('email', $validated['email']);

            if (!$user || $user->is_active == 0) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => ['The email address is inactive.']],
                ]);
            }

            Password::sendResetLink($request->only('email'));

            return response()->json([
                'success' => true,
                'title' => 'Password Reset Link Sent',
                'text' => "We've sent a password reset link to {$validated['email']}. Please check your inbox and follow the link to reset your password.",
            ]);
        } catch (Throwable $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while requesting for password reset. Please try again later.',
            ], 500);
        }
    }

    /**
     * Display the form for password reset.
     */
    public function reset_index(string $token)
    {
        $passwordReset = DB::table('password_reset_tokens')->first();
        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            abort(404);
        }

        $expirationTime = Carbon::parse($passwordReset->created_at)->addMinutes(5);
        if (Carbon::now()->greaterThan($expirationTime)) {
            abort(419);
        }

        return view('pages.auth.reset', ['token' => $token]);
    }

    /**
     * Reset the user password.
     */
    public function reset(PasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::firstWhere('user_name', $validated['user']);

            $passwordEmail = DB::table('password_reset_tokens')->first();
            if ($user->email != $passwordEmail->email) {
                return response()->json([
                    'success' => false,
                    'errors' => ['user' => ['The username does not have the reset email.']],
                ]);
            }

            if ($validated['email'] != $passwordEmail->email) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => ['The email address does not match with the reset email.']],
                ]);
            }

            if (Hash::check($validated['pass'], $user->pass_hash)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['pass' => ['The new password cannot be the same as your current password.']],
                ]);
            }

            Password::reset(
                $request->only('user_name', 'email', 'token') + ['password' => $validated['pass']],
                function (User $user, string $password) {
                    $user->forceFill(['pass_hash' => Hash::make($password)]);
                    $user->save();
                    event(new PasswordReset($user));
                }
            );

            return response()->json([
                'success' => true,
                'title' => 'Password Reset Successful!',
                'text' => 'Your password has been changed successfully. You can now log in with your new password.',
                'redirect' => route('auth.login')
            ]);
        } catch (Throwable) {
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'text' => 'An error occurred while resetting password. Please try again later.',
            ], 500);
        }
    }
}
