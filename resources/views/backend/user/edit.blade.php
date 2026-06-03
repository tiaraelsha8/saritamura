@extends('backend.layouts.master')

@section('judul')
    Halaman Edit User
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
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="box-body">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                    </div>
                    @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                    </div>
                    @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-group position-relative">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="kosongkan kalau tidak ubah password">
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
                            <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Superadmin
                            </option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
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
