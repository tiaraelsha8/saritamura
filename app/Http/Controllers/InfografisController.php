<?php

namespace App\Http\Controllers;

use App\Models\Grafik;

class InfografisController extends Controller
{
    public function index()
    {
        $infografis = Grafik::latest()->paginate(6);

        return view('frontend.infografis', compact('infografis'));
    }

    public function show(string $id)
    {
        $infografis = Grafik::findOrFail($id);

        $infografisLainnya = Grafik::where('id', '!=', $id)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.infografis-show', compact(
            'infografis',
            'infografisLainnya'
        ));
    }
}