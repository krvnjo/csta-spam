<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('pages.auth.login');
        }
        return redirect()->route('dashboard.index');
    }

    /**
     * Authenticate the user and log the user in.
     */
    public function login(AuthRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::firstWhere('user_name', $validated['user']);

            if (!$user || $user->is_active == 0) {
                return response()->json([
                    'success' => false,
                    'errors' => ['user' => ['The username is inactive.']],
                ]);
            }

            if (!Hash::check($validated['pass'], $user->pass_hash)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['pass' => ['Incorrect password!']],
                ]);
            }

            Auth::login($user);

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
}
