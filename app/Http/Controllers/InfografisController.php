<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Grafik;
use Illuminate\Support\Facades\Cache;

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

        $key = 'infografis_' . $infografis->id . '_' . request()->ip();

        return view('frontend.infografis-show', compact('infografis'));
    }
}