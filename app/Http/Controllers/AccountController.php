<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($username)
    {
        $user = Auth::user();

        if ($user->user_name !== $username) {
            abort(403, 'Unauthorized access.');
        }

        return view('pages.account.setting');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
