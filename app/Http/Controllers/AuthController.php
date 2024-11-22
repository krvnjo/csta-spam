<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
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

            if ($user->pass_changed_at && Carbon::parse($user->pass_changed_at)->lt(now()->subMonths(6))) {
                $token = Str::random(64);
                Session::put('password_change_token', $token);

                return response()->json([
                    'success' => false,
                    'redirect' => route('password.change', ['token' => $token]),
                ]);
            }

            Auth::login($user);

            $user->timestamps = false;
            $user->updateQuietly([
                'last_login' => now(),
            ]);

            (new Audit())
                ->logName('User Login')
                ->logDesc("{$user->name} has logged in to the system.")
                ->performedOn($user)
                ->logEvent(4)
                ->logProperties([
                    'name' => $user->name,
                    'login at' => $user->last_login->format('M d, Y | h:i A'),
                ])
                ->log();

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
        $user = Auth::user();
        (new Audit())
            ->logName('User Logout')
            ->logDesc("{$user->name} has logged out.")
            ->performedOn($user)
            ->logEvent(5)
            ->logProperties([
                'name' => $user->name,
                'logout at' => now()->format('M d, Y | h:i A'),
            ])
            ->log();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
