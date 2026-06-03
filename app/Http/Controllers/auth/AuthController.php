<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        //✅ Validasi input + reCAPTCHA
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ]);

        // Buat key berdasarkan IP dan username untuk rate limit
        $key = Str::lower($request->input('username')) . '|' . $request->ip();

        // Jika terlalu banyak percobaan
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit.",
            ]);
        }

        // ✅ Ambil credential username & password saja (tanpa CAPTCHA!)
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            RateLimiter::clear($key); // Clear hitungan jika berhasil login

            $user = Auth::user(); // ✅ ambil user aktif

            // ✅ Arahkan sesuai role
            if ($user->role === 'superadmin') {
                return redirect()->route('backend.dashboard')->with('success', 'Selamat datang Superadmin!');
            } elseif ($user->role === 'admin') {
                return redirect()->route('backend.dashboard')->with('success', 'Selamat datang Admin!');
            } else {
                abort(403, 'Akses tidak diizinkan');
            }
        }

        // Gagal login, tambah hitungan rate limit
        RateLimiter::hit($key, 300); // Lock selama 300 detik (5 menit)

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tambahkan pesan info di session setelah logout
        return redirect()->route('login')->with('success', 'Anda telah logout');
    }
}
