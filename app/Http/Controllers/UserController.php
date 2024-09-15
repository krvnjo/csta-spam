<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->whereNull('deleted_at')->get();
        $roles = Role::query()->select('id', 'name')->where('is_active', '=', 1)->whereNull('deleted_at')->get();
        $depts = Department::query()->select('id', 'name')->where('is_active', '=', 1)->whereNull('deleted_at')->get();

        $totalUsers = $users->count();

        return view('pages.user-management.user',
            compact(
                'users',
                'roles',
                'depts',
                'totalUsers'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
