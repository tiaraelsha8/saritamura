<?php

namespace App\Http\Controllers\backend;

// use App\Helpers\VisitorCounter;
use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Grafik;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $jumlahdokumen = Dokumen::count();
        $jumlahgrafik = Grafik::count();
        $jumlahvideo = Video::count();
        $jumlahadmin = User::where('role', 'admin')->count();
        // $statistik = VisitorCounter::count();
        return view('backend.dashboard', compact('jumlahdokumen','jumlahgrafik','jumlahvideo','jumlahadmin'));

        return view('backend.dashboard');
    }
}
