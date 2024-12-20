<?php

namespace App\Http\Controllers;

use App\Models\HeadStaff;
use App\Models\Report;
use App\Models\Response;
use App\Models\StaffProvince;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeadStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report = Report::count();
        $response = Response::count();

        return view('head.index', compact('report', 'response'));
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
        StaffProvince::where('user_id', auth::user()->id);
        $data = User::where('role', 'STAFF')->get();
        return view('head.user', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'STAFF',
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
    public function destroy(HeadStaff $headStaff, $id)
    {
        User::where('id', $id)->delete();
        return redirect()->back();
    }
}
