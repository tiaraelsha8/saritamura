<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;

class SipdWalidataController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumen::query();

        $allKeterangan = Dokumen::select('keterangan')->distinct()->pluck('keterangan');

        if ($request->filled('keterangan')) {
            $query->where('keterangan', $request->keterangan);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_dok', 'like', "%{$search}%")->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $dokumen = $query->paginate(10)->withQueryString();

        return view('frontend.sipd-walidata', compact('dokumen', 'allKeterangan'));
    }

    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $path = storage_path('app/public/dokumen/' . $dokumen->file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $dokumen->file . '"',
        ]);
    }
}
