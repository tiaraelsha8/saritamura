<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grafik;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GrafikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grafik = Grafik::latest()->get();
        return view('backend.grafik.index', compact('grafik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.grafik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate form
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'penulis' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Ambil konten dan folder_id dari request
        $deskripsi = $request->deskripsi;
        preg_match('/storage\/grafik\/foto\/([^\/]+)\//', $deskripsi, $matches);
        $folderId = $matches[1] ?? ""; // Diambil dari input hidden di form

        // Path menuju folder spesifik berita ini
        $storagePath = public_path('storage/grafik/foto/' . $folderId);

        // Lakukan pembersihan hanya jika foldernya ada
        if ($folderId && File::exists($storagePath)) {

            // 1. Ambil semua nama file yang MASIH ADA di dalam deskripsi (yang akan disimpan)
            preg_match_all('/<img [^>]*src="([^"]+)"/', $deskripsi, $matches);

            // Ambil nama filenya saja (contoh: 17123456_foto.jpg)
            $imagesInContent = array_map(function ($url) {
                return basename(parse_url($url, PHP_URL_PATH));
            }, $matches[1]);

            // 2. Ambil semua file FISIK yang ada di dalam sub-folder berita ini
            $allFiles = File::files($storagePath);

            // 3. Bandingkan: Jika file di folder tidak ada di teks deskripsi, maka HAPUS
            foreach ($allFiles as $file) {
                $fileName = $file->getFilename();

                if (!in_array($fileName, $imagesInContent)) {
                    File::delete($file->getPathname());
                }
            }

            // 4. Opsional: Hapus folder jika kosong (misal user menghapus semua gambar di editor)
            if (count(File::files($storagePath)) === 0) {
                File::deleteDirectory($storagePath);
            }
        }

        //upload image
        $image = $request->file('foto');
        $image->storeAs('grafik', $image->hashName());

        //create 
        Grafik::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'penulis' => $request->penulis,
            'foto' => $image->hashName(),
        ]);

        //redirect to index
        return redirect()->route('grafik.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
        $grafik = Grafik::findOrFail($id);

        //render view with product
        return view('backend.grafik.edit', compact('grafik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate form
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'penulis' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Ambil konten dan folder_id dari request
        $deskripsi = $request->deskripsi;
        preg_match('/storage\/grafik\/foto\/([^\/]+)\//', $deskripsi, $matches);
        $folderId = $matches[1] ?? ""; // Diambil dari input hidden di form

        // Path menuju folder spesifik berita ini
        $storagePath = public_path('storage/grafik/foto/' . $folderId);

        // Lakukan pembersihan hanya jika foldernya ada
        if ($folderId && File::exists($storagePath)) {

            // 1. Ambil semua nama file yang MASIH ADA di dalam deskripsi (yang akan disimpan)
            preg_match_all('/<img [^>]*src="([^"]+)"/', $deskripsi, $matches);

            // Ambil nama filenya saja (contoh: 17123456_foto.jpg)
            $imagesInContent = array_map(function ($url) {
                return basename(parse_url($url, PHP_URL_PATH));
            }, $matches[1]);

            // 2. Ambil semua file FISIK yang ada di dalam sub-folder berita ini
            $allFiles = File::files($storagePath);

            // 3. Bandingkan: Jika file di folder tidak ada di teks deskripsi, maka HAPUS
            foreach ($allFiles as $file) {
                $fileName = $file->getFilename();

                if (!in_array($fileName, $imagesInContent)) {
                    File::delete($file->getPathname());
                }
            }

            // 4. Opsional: Hapus folder jika kosong (misal user menghapus semua gambar di editor)
            if (count(File::files($storagePath)) === 0) {
                File::deleteDirectory($storagePath);
            }
        }

        //get product by ID
        $grafik = grafik::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('foto')) {
            //delete old image
            Storage::delete('grafik/' . $grafik->foto);

            //upload new image
            $image = $request->file('foto');
            $image->storeAs('bgrafika', $image->hashName());

            //update product with new image
            $grafik->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'foto' => $image->hashName(),
            ]);
        } else {
            //update product without image
            $grafik->update([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'penulis' => $request->penulis,
            ]);
        }

        //redirect to index
        return redirect()->route('grafik.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grafik = Grafik::findOrFail($id);
        $deskripsi = $grafik->deskripsi;

        // 1. Cari pola folder_id di dalam deskripsi (menggunakan Regex)
        // Mencari teks yang berada di antara 'foto/' dan '/' selanjutnya
        preg_match('/storage\/grafik\/foto\/([^\/]+)\//', $deskripsi, $matches);

        if (isset($matches[1])) {
            $folderId = $matches[1];
            $folderPath = public_path('storage/grafik/foto/' . $folderId);

            // 2. Hapus folder jika ditemukan
            if (\File::exists($folderPath)) {
                \File::deleteDirectory($folderPath);
            }
        }

        // 3. Hapus foto utama/thumbnail (jika ada)
        if ($grafik->foto) {
            $thumbnailPath = public_path('storage/grafik/' . $grafik->foto);
            if (\File::exists($thumbnailPath)) {
                \File::delete($thumbnailPath);
            }
        }

        $grafik->delete();

        return redirect()->route('grafik.index')->with(['success' => 'Grafik dan folder foto berhasil dihapus!']);
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // 1. VALIDASI FORMAT FILE
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => ['message' => 'Format file tidak didukung! Gunakan JPG, PNG, atau WEBP.']
                ]);
            }

            // 2. VALIDASI UKURAN (Maksimal 2MB)
            $maxSize = 2 * 1024 * 1024;
            if ($file->getSize() > $maxSize) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => ['message' => 'Ukuran foto terlalu besar! Maksimal adalah 2MB.']
                ]);
            }

            // 3. JIKA LOLOS SEMUA VALIDASI, PROSES SIMPAN
            $folderId = $request->query('folder_id');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $path = "storage/grafik/foto/" . $folderId;
            $file->move(public_path($path), $fileName);

            return response()->json([
                'uploaded' => 1,
                'url' => asset($path . '/' . $fileName)
            ]);
        }
    }
}
