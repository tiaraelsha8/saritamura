<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class ProfileController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.profile.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'required', // wajib isi password lama
        ]);

        try {
            $user = User::findOrFail($id);

            // Buat kunci unik untuk user yang login
            $key = 'verify-password-attempts:' . $user->id;

            // Cek apakah user melebihi batas percobaan
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return back()->withErrors([
                    'current_password' => 'Terlalu banyak percobaan gagal. Coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
                ]);
            }

            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user->password)) {
                RateLimiter::hit($key, 300); // Tambah 1 hit, lock selama 300 detik (5 menit)
                $seconds = RateLimiter::availableIn($key);
                return back()
                    ->withErrors([
                        'current_password' => 'Password lama salah.',
                    ])
                    ->with('secondsRemaining', $seconds);
            }

            // Jika password benar, reset percobaan gagal
            RateLimiter::clear($key);

            // Simpan perubahan data
            $user->fill([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            // Update password baru jika diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('profile.edit', $user->id)->with('success', 'Data berhasil diedit!');
        } catch (\Exception $e) {
            return redirect()
                ->route('profile.edit', $id)
                ->with('error', 'Gagal mengedit data: ' . $e->getMessage());
        }
    }
}
