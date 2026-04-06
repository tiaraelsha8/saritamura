@extends('backend.layouts.master')

@section('judul')
    Halaman Edit Profile
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit data user</h3>
                    </div>
                    <!-- /.card-header -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- form start -->
                    <form action="{{ route('profile.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                            @error('name')
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
                                <label>Password Lama</label>
                                <input type="password" class="form-control" name="current_password" id="password"
                                    placeholder="isikan password lama saat mengubah email,username,nama,password">
                                <!-- Ikon Mata -->
                                <span class="position-absolute" style="right:10px; top:38px; cursor:pointer;"
                                    onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password';
                 this.innerHTML = this.previousElementSibling.type === 'password' 
                    ? '<i class=\'fas fa-eye\'></i>' 
                    : '<i class=\'fas fa-eye-slash\'></i>';">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>

                            @error('current_password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                            <div class="form-group position-relative">
                                <label>Password Baru</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="kosongkan jika tidak ingin mengubah password">
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

                            <div class="form-group position-relative">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password"
                                    placeholder="isikan jika mengubah password">
                                <!-- Ikon Mata -->
                                <span class="position-absolute" style="right:10px; top:38px; cursor:pointer;"
                                    onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password';
                 this.innerHTML = this.previousElementSibling.type === 'password' 
                    ? '<i class=\'fas fa-eye\'></i>' 
                    : '<i class=\'fas fa-eye-slash\'></i>';">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>

                            @error('password_confirmation')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('backend.dashboard') }}" class="btn btn-default">Batal</a>
                        </div>

                        @if (session('secondsRemaining'))
                            <div class="alert alert-warning">
                                Anda telah mencoba terlalu banyak. Tunggu <span id="countdown"
                                    style="font-weight: bold"></span>
                            </div>
                        @endif
                    </form>
                </div>
                <!-- /.card -->
                <!--/.col (right) -->
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection

@push('scripts')
    <script>
        let seconds = {{ session('secondsRemaining') }};

        function formatClock(secs) {
            const m = Math.floor(secs / 60);
            const s = secs % 60;
            return `${m < 10 ? '0' : ''}${m}:${s < 10 ? '0' : ''}${s}`;
        }

        function updateCountdown() {
            const el = document.getElementById('countdown');
            if (seconds <= 0) {
                el.innerText = '00:00';
                return;
            }
            el.innerText = formatClock(seconds);
            seconds--;
            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();
    </script>
@endpush
