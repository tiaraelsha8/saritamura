<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Reset Password</title>

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
                    <a href=""><b>Diskominfo SP</b></a>
                    <div class="text-center mt-2">
                        <img src="{{ asset('image/logo/logodiskominfo.png') }}" alt="Logo Diskominfo"
                            style="height: 80px;">
                    </div>
                </div>

                <p class="text-center">Masukkan password baru</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}"
                            required placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-mail"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password Baru" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Konfirmasi Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePasswordConfirm" style="cursor: pointer;">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-6 d-flex gap-3">
                        <button type="submit" class="btn btn-primary btn-block w-60 text-nowrap">Reset
                            Password</button>
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
            // Untuk password baru
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const icon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });

            // Untuk konfirmasi password
            const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
            const passwordConfirm = document.querySelector('#password_confirmation');
            const iconConfirm = togglePasswordConfirm.querySelector('i');

            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirm.setAttribute('type', type);
                iconConfirm.classList.toggle('fa-eye');
                iconConfirm.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>
