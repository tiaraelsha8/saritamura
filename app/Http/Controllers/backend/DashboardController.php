<?php

namespace App\Http\Controllers\backend;

// use App\Helpers\VisitorCounter;
use App\Http\Controllers\Controller;
// use App\Models\Kategori;
// use App\Models\Layanan;
// use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        // $jumlahkategori = Kategori::count();
        // $jumlahlayanan = Layanan::count();
        // $statistik = VisitorCounter::count();
        // $jumlahadmin = User::where('role', 'admin')->count();
        // return view('backend.dashboard', compact('jumlahkategori','jumlahlayanan','statistik','jumlahadmin'));

        return view('backend.dashboard');
    }
}
