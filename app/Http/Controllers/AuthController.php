<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function index(){
        return view('Auth.index');
    }

    public function login(Request $request){
       return view('Auth.login');
    }



    public function loginOrRegister(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Cek apakah user sudah terdaftar
        $user = User::where('email', $email)->first();

        if ($user) {
            // Jika user ditemukan, cek password
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                // Redirect berdasarkan role
                switch (Auth::user()->role) {
                    case 'GUEST':
                        return redirect()->route('article');
                    case 'STAFF':
                        return redirect()->route('report.staff');
                    case 'HEAD_STAFF':
                        return redirect()->route('head.staff');
                    default:
                        Auth::logout(); // Logout jika role tidak dikenali
                        return redirect()->route('login')->with('error', 'Role tidak dikenali.');
                }
            } else {
                // Jika password salah
                return redirect()->route('login')->with('error', 'Password salah.');
            }
        } else {
            // Jika user belum terdaftar, buat akun baru
            $newUser = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'GUEST', // Default role
            ]);

            // Login setelah registrasi
            Auth::login($newUser);

            // Redirect ke article setelah pendaftaran
            return redirect()->route('article');
        }
    }

    public function logout()
{
    // Menghapus session user yang sedang login
    auth()->logout();

    // Mengarahkan ke halaman login
    return redirect()->route('index');
}


public function article(Request $request){
    // Ambil semua artikel yang belum memiliki balasan
    $reports = Report::doesntHave('response');

    if ($request->search) {
        $reports->where('province', $request->search);
    }

    $reports = $reports->get();

    return view('article.index', compact('reports'));
}

public function articleId($id){
    $comment = Comment::where('report_id', $id)->with('user')->get();
    $report = Report::find($id);

    $report->increment('viewers');
    return view('article.indexId', compact('report','comment'));
}


public function destroy($id)
{
    // Cari artikel berdasarkan ID
    $report = Report::find($id);
    $report->delete();

    // Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->route('articles.index');
}
}