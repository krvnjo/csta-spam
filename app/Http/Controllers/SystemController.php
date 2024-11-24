<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessionDuration = Setting::where('key', 'session_timeout')->first()->value;
        $passwordExpiration = Setting::where('key', 'password_expiry')->first()->value;
        $clearAuditLog = Setting::where('key', 'clear_audit_log')->first()->value;
        $cachingDuration = Setting::where('key', 'caching_duration')->first()->value;

        return view('pages.other.system-setting',
            compact(
                'sessionDuration',
                'passwordExpiration',
                'clearAuditLog',
                'cachingDuration'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
