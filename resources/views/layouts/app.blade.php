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
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif;
            background: var(--light-bg);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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
            bottom: 30px;
            right: 30px;
            z-index: 999;
            width: 60px;
            height: 60px;
            background: transparent;
            border: none;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(16px);
            transition: opacity .3s ease, transform .3s ease;
        }

        #backToTopBtn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        #backToTopBtn svg {
            position: absolute;
            inset: 0;
            width: 60px;
            height: 60px;
            transform: rotate(-90deg);
        }

        #backToTopBtn i {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #000;
            transition: transform .25s ease;
        }

        #backToTopBtn:hover i {
            transform: translateY(-3px);
        }

        #progressRing {
            stroke: #000;
            transition: stroke-dashoffset .15s linear;
        }
    </style>

    @stack('styles')
</head>

<body>

    <button onclick="scrollToTop()" id="backToTopBtn" title="Kembali ke atas">
        <svg viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="34" stroke="#000" stroke-width="3" fill="none"
                opacity=".18" />

            <circle id="progressRing" cx="50" cy="50" r="34" stroke="#000" stroke-width="3"
                fill="none" stroke-linecap="round" />
        </svg>
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- Navbar --}}
    @include('partial.navbar')

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partial.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btn = document.getElementById("backToTopBtn");
        const circle = document.getElementById("progressRing");

        const radius = 34;
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