<?php

namespace App\Http\Controllers;

use App\Models\HeadStaff;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class HeadStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('head.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('head.create');
    }
    public function user()
    {
        return view('head.user');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'STAFF'
        ]);
        return redirect()->route('user');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeadStaff $headStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeadStaff $headStaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeadStaff $headStaff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeadStaff $headStaff)
    {
        //
    }
}
