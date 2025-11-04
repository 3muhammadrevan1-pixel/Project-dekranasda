<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:50'
        ]);

        // 2. Cek login (autentikasi user)
        if (Auth::attempt($credentials)) {
            
            // Dapatkan objek user yang berhasil login
            $user = Auth::user();

            // 3. TAMBAHAN: Cek status akun
            if ($user->status === 'nonaktif') {
                // Jika status nonaktif, batalkan login (logout otomatis dari Auth::attempt)
                Auth::logout(); 
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Beri pesan error kustom seperti di contoh gambar
                return back()->with('status_error', 'Akun dinonaktifkan! Silakan hubungi admin.');
            }

            // 4. Jika status aktif, lanjutkan proses login
            $request->session()->regenerate();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'operator') {
                return redirect()->route('operator.dashboard');
            }
        }

        // Jika Auth::attempt gagal (email/password salah)
        return back()->with('failed', 'Email atau Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
