<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand custom-brand" href="{{ route('frontend.home') }}">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/images/logo-murung-raya.webp') }}" class="brand-logo">
                <div class="d-flex flex-column">
                    <span class="brand-title">Saritamura</span>
                    <small class="brand-subtitle">Satu Data Murung Raya</small>
                </div>

            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link custom-nav" href="{{ route('frontend.home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav" href="{{ route('frontend.datasets') }}">
                        Datasets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav" href="{{ route('frontend.infografis') }}">
                        Infografis
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav" href="{{ route('frontend.organizations') }}">
                        Daftar Organisasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link custom-nav" href="{{ route('frontend.sipd-walidata') }}">
                        SIPD Walidata
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 8px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .navbar:hover {
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        padding-top: 0;
        padding-bottom: 0;
    }

    .navbar-brand .d-flex {
        line-height: 1.1;
    }

    .navbar-light .navbar-nav .nav-link.custom-nav {
        color: #1D4ED8 !important;
    }

    .navbar-light .navbar-nav .nav-link.custom-nav:hover {
        color: #1E40AF !important;
    }

    .navbar-light .navbar-nav .nav-link.custom-nav.active {
        color: #1E40AF !important;
        font-weight: 600;
    }

    .brand-logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 10px;
    }

    .custom-brand {
        margin-right: 20px;
        color: #1D4ED8 !important;
        transform: none !important;
        text-decoration: none !important;
        transition: none !important;
    }

    .custom-brand:hover,
    .custom-brand:focus,
    .custom-brand:active {
        color: #1D4ED8 !important;
        transform: none !important;
        text-decoration: none !important;
    }

    .brand-title {
        font-size: 1.4rem;
        font-weight: 700;
    }

    .brand-subtitle {
        font-size: 0.85rem;
        line-height: 1.1;
        opacity: 0.85;
        margin-top: 2px;
        color: #050505
    }

    .custom-nav {
        color: #2563EB;
        font-weight: 500;
        transition: all 0.25s ease;
        position: relative;
        display: inline-block;
    }

    .custom-nav:hover {
        color: #1E3A8A;
        transform: translateY(0.5px);
    }

    .custom-nav::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 0;
        height: 2px;
        background-color: #2563EB;
        transition: width 0.25s ease;
    }

    .custom-nav:hover::after {
        width: 100%;
    }

    .nav-item:not(:last-child) {
        margin-right: 15px;
    }
</style>
