<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Lupa Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('templateadmin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('templateadmin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('templateadmin/dist/css/adminlte.min.css') }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('templateadmin/dist/img/AdminLTELogo.png') }}">
</head>

<body class="hold-transition login-page">

    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-box">
                <div class="login-logo">
                    <a href=""><b>Katalog Layanan</b></a>
                    <div class="text-center mt-2">
                        <img src="{{ asset('image/logo/logodiskominfo.png') }}" alt="Logo Diskominfo"
                            style="height: 80px;">
                    </div>
                </div>

                <p class="text-center">Masukkan Email</p>

                {{-- Pesan sukses --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Pesan error validasi atau kegagalan --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="masukkan email anda"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-block w-60 text-nowrap">Kirim Link
                            Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('templateadmin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('templateadmin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('templateadmin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
