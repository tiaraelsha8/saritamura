@extends('backend.layouts.master')

@section('judul')
    Halaman Kelola Video
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif



    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Video</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a href="{{ route('video.create') }}" class="btn btn-primary btn-sm mb-3">Tambah</a>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Video</th>
                                    <th>Deskripsi</th>
                                    <th>Video</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($videos as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->judul }}</td>
                                        <td>{{ $value->deskripsi }}</td>
                                        <td>
                                            <div class="ratio ratio-16x9">
                                                <iframe src="https://www.youtube.com/embed/{{ $value->video }}"
                                                    title="Video 2" allowfullscreen></iframe>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('video.destroy', $value->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('video.edit', $value->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <input type="submit" value="Hapus" class="btn btn-danger btn-sm">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data video</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
