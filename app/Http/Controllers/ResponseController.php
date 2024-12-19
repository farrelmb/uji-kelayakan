<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showReportResponse(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'response_status' => 'required|in:ON_PROCESS,REJECT',
    ]);

    // Temukan atau buat respons baru
    $response = Response::updateOrCreate(
        ['report_id' => $id], // Kondisi untuk mencari data
        [
            'response_status' => $request->response_status,
            'report_id' => $id,
            'staff_id' => auth()->id(),
        ]
    );


    // Kirim data ke view
    return redirect()->route('response.index', $id);
}

public function reportResponseIndex($id)
{
    $response = Response::with('report')->find($id);
    $responseProgress = ResponseProgress::where('report_id', $id)->get();

    return view('response.index', compact('response', 'responseProgress'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Response $response)
    {
        //
    }
}
