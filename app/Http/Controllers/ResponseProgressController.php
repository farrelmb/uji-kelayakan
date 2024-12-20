<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;

class ResponseProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

     public function store(Request $request, $id)
     {
         // Validasi input
         $request->validate([
             'response' => 'required|string',
         ]);

         // Periksa apakah response_id valid di tabel responses
         $responseExists = Response::where('id', $id)->exists();
         // Simpan data ke tabel response_progress
        $proses =  ResponseProgress::create([
             'report_id' => $id,
             'histories' => json_encode(['response' => $request->response]),
         ]);

         return $proses
         ? redirect()->back()->with('success', 'Progres berhasil ditambahkan!')
         : redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan progres!');
     }



    /**
     * Display the specified resource.
     */
    public function show(ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponseProgress $responseProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan data berdasarkan ID atau gagal jika tidak ditemukan
    $responseProgress = ResponseProgress::findOrFail($id);

    // Hapus data yang ditemukan
    $responseProgress->delete();

    // Berikan respon balik (opsional, untuk memberi informasi kepada pengguna)
    return redirect()->back()->with('success', 'Response deleted successfully.');
    }
}
