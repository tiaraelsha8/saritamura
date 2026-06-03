<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = \App\Models\User::orderByRaw("CASE WHEN role = 'superadmin' THEN 1 ELSE 2 END")
            ->orderBy('name', 'asc') // bisa juga username/email sesuai kebutuhan
            ->get();

        return view('backend.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,admin',
        ]);

        // ✅ Cek apakah sudah ada Superadmin
        if ($request->role === 'superadmin') {
            $cekSuperadmin = \App\Models\User::where('role', 'superadmin')->exists();

            if ($cekSuperadmin) {
                return redirect()->back()->with('error', 'Superadmin sudah ada, tidak bisa menambah lagi!')->withInput();
            }
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        //redirect to index
        return redirect()
            ->route('user.index')
            ->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:superadmin,admin',
        ]);

        $user = User::findOrFail($id);

        // ✅ Cegah lebih dari satu Superadmin
        if ($request->role === 'superadmin') {
            $cekSuperadmin = \App\Models\User::where('role', 'superadmin')->where('id', '!=', $user->id)->exists();

            if ($cekSuperadmin) {
                return redirect()->back()->with('error', 'Superadmin sudah ada, tidak bisa menambah lagi!')->withInput();
            }
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        //redirect to index
        return redirect()
            ->route('user.index')
            ->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // 🔒 Cegah hapus superadmin
        if ($user->role === 'superadmin') {
            return redirect()->back()->with('error', 'Superadmin tidak dapat dihapus!');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
