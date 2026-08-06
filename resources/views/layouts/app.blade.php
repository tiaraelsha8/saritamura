<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo-komdigi.png') }}">

    <!-- Meta deskripsi untuk SEO. Ini yang ditampilkan Google di hasil pencarian -->
    <meta name="description"
        content="Portal Resmi Satu Data Indonesia Kabupaten Murung Raya yang menyediakan data statistik, 
        data sektoral, informasi geospasial, metadata, berita, publikasi, dan layanan data 
        Pemerintah Daerah secara akurat, terpadu, dan berkelanjutan.">
    <meta name="robots" content="index, follow"> <!-- biarkan Google mengindeks -->
    <link rel="canonical" href="https://satudata.murungrayakab.go.id"> <!-- ganti dengan domain -->

    <!-- Custom Styles -->
    <style>
        html {
            overflow-y: scroll;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #f8fafc;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        #backToTopBtn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            width: 45px;
            height: 45px;
            background: transparent;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.8) translateY(10px);
            transition: all 0.3s ease;
            backdrop-filter: blur(6px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #backToTopBtn::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.08);
            z-index: 0;
            pointer-events: none;
        }

        #backToTopBtn svg,
        #backToTopBtn i {
            z-index: 1;
        }

        #backToTopBtn.show {
            opacity: 1;
            visibility: visible;
            transform: scale(1) translateY(0);
        }

        #backToTopBtn i {
            font-size: 1.2rem;
            color: #000;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #backToTopBtn:hover i {
            transform: translate(-50%, -50%) scale(1.08);
            text-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
        }

        #backToTopBtn svg {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 70px;
            height: 70px;
            transform: translate(-50%, -50%) rotate(-90deg);
        }
    </style>

    @stack('styles')
</head>

<body>

    <button onclick="scrollToTop()" id="backToTopBtn" title="Kembali ke atas">
        <svg viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="30" stroke="#ffffff33" stroke-width="6" fill="none" />
            <circle id="progressRing" cx="50" cy="50" r="30" stroke="#000" stroke-width="3" fill="none"
                stroke-linecap="round" />
        </svg>
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- Navbar --}}
    @include('partial.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partial.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btn = document.getElementById("backToTopBtn");
        const circle = document.getElementById("progressRing");

        const radius = 30;
        const circumference = 2 * Math.PI * radius;

        circle.style.strokeDasharray = circumference;
        circle.style.strokeDashoffset = circumference;

        window.addEventListener('scroll', function () {
            const scrollTop = document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;

            const progress = scrollHeight > 0 ? scrollTop / scrollHeight : 0;
            const offset = circumference * (1 - progress);

            btn.classList.toggle('show', scrollTop > 300);
            circle.style.strokeDashoffset = offset;
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

    @stack('scripts')
</body>

</html>