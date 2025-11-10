<?php

namespace App\Http\Controllers\Back_End;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Menampilkan form login dan menghasilkan soal Captcha.
     * Harus dijadikan route GET /login.
     */
    public function showLoginForm(Request $request)
    {
        // 1. Hasilkan dua angka acak (1 sampai 9)
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $question = "$num1 + $num2 =";
        $answer = $num1 + $num2;

        // 2. Simpan pertanyaan dan jawaban di session
        $request->session()->put('captcha_question', $question);
        $request->session()->put('captcha_answer', $answer);

        // Pastikan nama view yang dikembalikan benar (misalnya: 'auth.login' jika file ada di resources/views/auth/login.blade.php)
        return view('auth.login'); 
    }

    /**
     * Memproses permintaan login, termasuk validasi Captcha.
     */
    public function login(Request $request)
    {
        // 1. Validasi input, TERMASUK Captcha
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:50',
            'captcha' => 'required|numeric', 
        ]);

        // 2. Cek jawaban Captcha
        $expected_answer = $request->session()->get('captcha_answer');
        $user_answer = (int)$request->input('captcha');

        // Hapus Captcha dari sesi setelah diambil (untuk keamanan dan refresh soal)
        $request->session()->forget(['captcha_question', 'captcha_answer']); 
        
        if ($user_answer !== $expected_answer) {
            // Redirect ke route('login') agar Captcha baru digenerate oleh showLoginForm
            return redirect()->route('login')->with('failed', 'Jawaban Captcha Salah.')->withInput($request->only('email'));
        }

        // 3. Cek login (autentikasi user)
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            
            // Dapatkan objek user yang berhasil login
            $user = Auth::user();

            // 4. TAMBAHAN: Cek status akun
            if ($user->status === 'nonaktif') {
                Auth::logout(); 
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Redirect ke route('login') agar Captcha baru digenerate
                return redirect()->route('login')->with('status_error', 'Akun dinonaktifkan! Silakan hubungi admin.');
            }

            // 5. Jika status aktif, lanjutkan proses login
            $request->session()->regenerate();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'operator') {
                return redirect()->route('operator.dashboard');
            }
        }

        // Jika Auth::attempt gagal (email/password salah)
        // Redirect ke route('login') agar Captcha baru digenerate
        return redirect()->route('login')->with('failed', 'Email atau Password Salah')->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}