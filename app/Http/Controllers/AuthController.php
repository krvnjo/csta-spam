<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //
    }

    /**
     * Authenticate the user to log the user out.
     */
    public function logout(Request $request)
    {
        //
    }
}
