@extends('backend.layouts.master')

@section('judul')
    Halaman Tambah Dokumen
@endsection

@section('content')
<div class="card">
    <div class="card-header">
    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="box-body">

            <div class="form-group">
                <label>Nama Dokumen</label>
                <input type="text" class="form-control" name="nama_dok" placeholder="Isikan Nama Dokumen">
            </div>
            @error('nama_dok')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" class="form-control" name="keterangan" placeholder="Contoh Isikan Perencanaan, Pelaporan">
            </div>
            @error('keterangan')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="form-group">
                <label for="file">Dokumen</label>
                <input type="file" class="form-control-file" name="file" accept=".pdf">
                <p>pdf. max 5 MB</p>
            </div>
            @error('file')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route ('dokumen.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection
