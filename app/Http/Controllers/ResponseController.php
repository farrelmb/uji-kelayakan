<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;

class ResponseController extends Controller
{
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
    $response = Response::with('report')->where('report_id', $id)->first();
    $responseProgress = ResponseProgress::where('report_id', $id)->get();
    // dd($response->id);
    $responseId = $response->id;

    return view('response.index', compact('response', 'responseProgress', 'responseId'));
}
   
    public function update(Request $request, $id)
    {
        $update = Response::where('id', $id)->first();
        $update->update([
            'response_status' => 'DONE'
        ]);
        return redirect()->back();
    }
}
