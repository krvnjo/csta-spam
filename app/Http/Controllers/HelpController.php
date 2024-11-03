<?php

namespace App\Http\Controllers;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function about()
    {
        return view('pages.other.about-us');
    }

    /**
     * Display a listing of the resource.
     */
    public function guide()
    {
        return view('pages.other.user-guide');
    }
}
