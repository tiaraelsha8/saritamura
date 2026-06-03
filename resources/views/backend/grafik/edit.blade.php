@extends('backend.layouts.master')

@section('judul')
    Halaman Edit Info Grafis
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            @php
                preg_match('/storage\/berita\/foto\/([^\/]+)\//', $grafik->deskripsi, $m);
                $existingFolderId = $m[1] ?? uniqid();
            @endphp
            <form action="{{ route('grafik.update', $grafik->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="box-body">

                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="judul" value="{{$grafik->judul}}">
                    </div>
                    @error('judul')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="tentang">Deskripsi</label>
                        <textarea name="deskripsi" id="editor" class="form-control">{{ $grafik->deskripsi }}</textarea>
                        @error('deskripsi')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Penulis</label>
                        <input type="text" class="form-control" name="penulis" value="{{$grafik->penulis}}">
                    </div>
                    @error('judul')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="image">Foto</label>
                        <input type="file" class="form-control-file" name="foto" accept="image/*">
                        <p>jpg,jpeg,png. max 2 MB</p>
                    </div>
                    @error('foto')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('grafik.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'imageUpload',
                    'bulletedList', 'numberedList', 'alignment', '|',
                    'link', 'undo', 'redo'
                ],
                alignment: {
                    options: ['left', 'center', 'right', 'justify']
                },
                // Konfigurasi Upload Gambar
                ckfinder: {
                    uploadUrl: "{{ route('grafik.upload') }}?_token={{ csrf_token() }}&folder_id={{ $existingFolderId }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush