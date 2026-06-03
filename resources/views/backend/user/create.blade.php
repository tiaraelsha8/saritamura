@extends('backend.layouts.master')

@section('judul')
    Halaman Tambah User
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

    <div class="card">
        <div class="card-header">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="box-body">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Isikan Nama User">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Isikan Username">
                    </div>
                    @error('usernmae')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Isikan Email">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group position-relative">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Isikan Password">
                        <!-- Ikon Mata -->
                        <span class="position-absolute" style="right:10px; top:38px; cursor:pointer;"
                            onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password';
                 this.innerHTML = this.previousElementSibling.type === 'password' 
                    ? '<i class=\'fas fa-eye\'></i>' 
                    : '<i class=\'fas fa-eye-slash\'></i>';">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    @error('password')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
