<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Storage;
use File;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumens = Dokumen::latest()->get();
        return view('backend.dokumen.index', compact('dokumens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate form
        $request->validate([
            'nama_dok' => 'required',
            'keterangan' => 'required',
            'file' => 'required|mimes:pdf|max:5120', //5 mb
        ]);

        //upload
        $file = $request->file('file');
        $file->storeAs('dokumen', $file->hashName());

        //create
        Dokumen::create([
            'nama_dok' => $request->nama_dok,
            'keterangan' => $request->keterangan,
            'file' => $file->hashName(),
        ]);

        //redirect to index
        return redirect()->route('dokumen.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
        //get product by ID
        $dokumens = Dokumen::findOrFail($id);

        //render view with product
        return view('backend.dokumen.edit', compact('dokumens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate form
        $request->validate([
            'nama_dok' => 'required',
            'keterangan' => 'required',
            'file' => 'mimes:pdf|max:5120', //5 mb
        ]);

        $dokumens = Dokumen::findOrFail($id);

         //check
         if ($request->hasFile('file')) {
            //delete
            Storage::delete('dokumen/' . $dokumens->file);

            //upload
            $file = $request->file('file');
            $file->storeAs('dokumen', $file->hashName());

            //update new 
            $dokumens->update([
                'nama_dok' => $request->nama_dok,
                'keterangan' => $request->keterangan,
                'file' => $file->hashName(),
            ]);
        } else {
            //update without file
            $dokumens->update([
                'nama_dok' => $request->nama_dok,
                'keterangan' => $request->keterangan,
            ]);
        }

        //redirect to index
        return redirect()->route('dokumen.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get by ID
        $dokumens = Dokumen::findOrFail($id);

        //delete
        Storage::delete('dokumen/' . $dokumens->file);

        //delete image
        $dokumens->delete();

        //redirect to index
        return redirect()
            ->route('dokumen.index')
            ->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id); // pastikan modelnya sesuai

        $filename = $dokumen->file;
        $path = storage_path('app/public/dokumen/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $dokumen->file . '"'
        ]);
    }
}
