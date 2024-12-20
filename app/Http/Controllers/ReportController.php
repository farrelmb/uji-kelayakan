<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\ResponseProgress;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Ambil semua laporan milik user yang sedang login
        $reports = Report::where('user_id', Auth::id())->with('responseProgress','response')->get();
        return view('reports.index', compact('reports'));
    }
    public function indexStaff(Request $request)
    {
        $sortBy = $request->input('sort', 'voting'); // Default kolom 'votes'
        $order = $request->input('order', 'asc');  // Default urutan 'asc'

        $reports = Report::orderBy($sortBy, $order)->get();
         return view('reports.staff', compact('reports', 'sortBy', 'order'));
    }


    public function vote(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        // Cek apakah voting null, jika iya, set default menjadi array kosong
        $voting = $report->voting ? json_decode($report->voting, true) : [];

        if ($request->action === 'like') {
            // Cek jika user sudah memberikan vote, maka tidak boleh duplicate
            if (!in_array(auth()->id(), $voting)) {
                $voting[] = auth()->id(); // Menambahkan user ID ke dalam array
            }
        } elseif ($request->action === 'unlike') {
            // Menghapus user ID jika ada
            $voting = array_diff($voting, [auth()->id()]);
        }

        // Update kolom voting dengan json_encode
        $report->voting = json_encode($voting);
        $report->save();

        // Mengembalikan jumlah vote (jumlah elemen dalam array)
        return response()->json(['voting' => count($voting)]);
    }







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi data yang diterima
    $validatedData = $request->validate([
        'description' => 'required|string',
        'type' => 'required|in:KEJAHATAN,PEMBANGUNAN,SOSIAL',
        'province' => 'required|string',
        'regency' => 'required|string',
        'subdistrict' => 'required|string',
        'village' => 'required|string',
        'statement' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    // Simpan data ke database
    Report::create([
        'user_id' => auth()->id(),
        'description' => $validatedData['description'],
        'type' => $validatedData['type'],
        'province' => $validatedData['province'],
        'regency' => $validatedData['regency'],
        'subdistrict' => $validatedData['subdistrict'],
        'village' => $validatedData['village'],
        'statement' => $validatedData['statement'],
        'image' => $request->file('image') ? $request->file('image')->store('reports', 'public') : null,
    ]);

    return redirect()->route('index.reports.me');
}
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->back();;
    }
    public function export() 
    {
        return Excel::download(new ReportsExport, 'report.xlsx');
    }
}
