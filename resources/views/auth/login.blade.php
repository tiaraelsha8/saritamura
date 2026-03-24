<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>

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
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/tingang.png') }}">
    <!-- Google reCAPTCHA Script -->
    {!! NoCaptcha::renderJs() !!}
</head>

<body class="hold-transition login-page">

    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-box">
                <div class="login-logo">
                    <a href="" style="font-size: 25px; line-height: 1.3; text-align: center; display: inline-block;">
                        <b>Tempat Informasi dan<br>Gerbang Pelayanan Digital</b>
                    </a>
                    <div class="text-center mt-2">
                        <img src="{{ asset('image/tingang.png') }}" alt="Logo" style="height: 80px;">
                    </div>
                </div>

                <p class="text-center">Masukkan username & password untuk login</p>

                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('username'))
                    <div class="alert alert-danger text-center">
                        {{ $errors->first('username') }}
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    {{-- ✅ reCAPTCHA --}}
                    <div class="mb-3">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6 d-flex gap-3" style="padding-left: 0px">
                        <button type="submit" class="btn btn-primary btn-block w-60 text-nowrap">Masuk</button>
                        <a href="{{ route('password.request') }}" class="btn btn-secondary w-60 text-nowrap"
                            style="margin-left: 20px">Lupa Password?</a>
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
    <!-- Fish Eye -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                // ubah type
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // ubah ikon
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>

</body>

</html>
