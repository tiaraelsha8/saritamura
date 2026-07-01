@extends('layouts.app')

@section('title', 'Daftar Organisasi')

@section('content')

    <div class="org-hero">
        <div class="container text-center">
            <h1 class="section-title text-white">
                <i class="fa-solid fa-building-columns"></i> Organisasi
            </h1>
            <p class="org-subtitle">
                Daftar Organisasi Yang Sudah Melakukan Kontribusi Dalam Daftar Data
            </p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4 gy-5 justify-content-center">

            @for ($i = 0; $i < 12; $i++)
                <div class="col-6 col-md-2 text-center org-item">
                    <img src="{{ asset('assets/images/default-logo.png') }}" class="org-logo" alt="Logo">
                </div>
            @endfor

        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn-more-info">
                <span>More Info</span>
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <style>
        .org-hero {
            background: repeating-linear-gradient(120deg,
                rgba(255, 255, 255, 0.06) 0px,
                rgba(255, 255, 255, 0.06) 1px,
                transparent 1px,
                transparent 35px),

            /* ===== PAGE HEADER ===== */
            .page-header {
                background:
                    repeating-linear-gradient(120deg,
                        rgba(255, 255, 255, 0.06) 0px,
                        rgba(255, 255, 255, 0.06) 1px,
                        transparent 1px,
                        transparent 35px),

                    repeating-linear-gradient(-120deg,
                        rgba(255, 255, 255, 0.04) 0px,
                        rgba(255, 255, 255, 0.04) 1px,
                        transparent 1px,
                        transparent 55px),

                    linear-gradient(120deg,
                        transparent 0%,
                        rgba(255, 255, 255, 0.08) 30%,
                        transparent 60%),

                    linear-gradient(135deg, #1E3A8A, #2563EB);

                padding: 2rem 0;
                color: white;
                align-items: center;
                overflow: hidden;
            }

            .org-hero.show {
                animation: fadeHero 0.8s ease;
            }

            .page-header .subtitle {
                opacity: .9;
                font-size: 1rem;
            }

            /* ===== GRID ===== */
            .org-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
                gap: 1.5rem;
            }

            @media (max-width:768px) {
                .org-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* ===== CARD ===== */
            .org-card {
                background: white;
                border-radius: 14px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
                overflow: hidden;
                transition: .25s;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .org-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
            }

            .org-card-header {
                padding: 1.5rem;
                border-bottom: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .org-title {
                font-size: 1.05rem;
                font-weight: 600;
                line-height: 1.5;
            }

            .org-title a {
                color: var(--text-primary);
                text-decoration: none;
            }

            .org-title a:hover {
                color: var(--primary-color);
            }

            .org-card-body {
                flex: 1;
                padding: 1.5rem;
            }

            .org-description {
                color: var(--text-secondary);
                line-height: 1.6;
                margin-bottom: 1rem;

                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .org-meta {
                display: flex;
                flex-direction: column;
                gap: .75rem;
                margin-bottom: 1rem;
            }

            .org-meta-item {
                display: flex;
                align-items: center;
                gap: .5rem;
            }

            .org-card-footer {
                padding: 1rem 1.5rem;
                border-top: 1px solid var(--border-color);
                background: #fafafa;
            }

            .org-card-footer .d-flex {
                gap: 1rem;
            }

            /* ===== STATS ===== */
            .stats-bar {
                background: white;
                border-radius: 14px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                box-shadow: 0 2px 12px rgba(0, 0, 0, .08);

                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .btn-more-info:hover {
                background: linear-gradient(135deg, #1E3A8A, #2563EB);
                color: white;
                transform: translateY(-3px) scale(1.03);
                box-shadow: 0 12px 30px rgba(220, 53, 69, 0.25);
            }

            .stat-value {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--primary-color);
            }

            .stat-label {
                color: var(--text-secondary);
                font-size: .9rem;
            }

            @media (max-width:768px) {
                .stats-bar {
                    grid-template-columns: 1fr;
                }
            }
    </style>

@section('content')

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1>
                <i class="fas fa-building me-2"></i>
                Organisasi
            </h1>

            <p class="subtitle mb-0">
                Daftar instansi dan organisasi penyedia data di Kabupaten Murung Raya
            </p>
        </div>
    </header>

    <div class="container py-4">

        @if (isset($error))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $error }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value">
                    {{ number_format($total) }}
                </div>
                <div class="stat-label">
                    Total Organisasi
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-value">
                    {{ number_format($organizations->sum('package_count')) }}
                </div>
                <div class="stat-label">
                    Total Dataset
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-value">
                    {{ number_format($organizations->filter(fn($o) => $o['package_count'] > 0)->count()) }}
                </div>
                <div class="stat-label">
                    Aktif Publikasi
                </div>
            </div>
        </div>

        @if ($organizations->count())

            <!-- GRID -->
            <div class="org-grid">

                @foreach ($organizations as $org)
                    <div class="org-card">

                        <!-- Header -->
                        <div class="org-card-header">

                            <div class="org-logo">
                                @if ($org['image_url'])
                                    <img src="{{ $org['image_url'] }}" alt="{{ $org['title'] }}"
                                        onerror="this.parentElement.innerHTML='<i class=\'fas fa-building org-logo-placeholder\'></i>'">
                                @else
                                    <i class="fas fa-building org-logo-placeholder"></i>
                                @endif
                            </div>

                            <h3 class="org-title">
                                <a href="{{ route('frontend.organization', $org['id']) }}">
                                    {{ $org['title'] }}
                                </a>
                            </h3>

                        </div>

                        <!-- Body -->
                        <div class="org-card-body">

                            <p class="org-description">
                                {{ $org['description'] ?: 'Belum ada deskripsi organisasi.' }}
                            </p>

                            <div class="org-meta">

                                @if ($org['address'])
                                    <div class="org-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>
                                            {{ Str::limit($org['address'], 40) }}
                                        </span>
                                    </div>
                                @endif

                                @if ($org['phone'])
                                    <div class="org-meta-item">
                                        <i class="fas fa-phone"></i>
                                        <span>
                                            {{ $org['phone'] }}
                                        </span>
                                    </div>
                                @endif

                                @if ($org['email'])
                                    <div class="org-meta-item">
                                        <i class="fas fa-envelope"></i>
                                        <span>
                                            {{ $org['email'] }}
                                        </span>
                                    </div>
                                @endif

                            </div>

                            @if ($org['package_count'] > 0)
                                <div class="org-dataset-count">
                                    <i class="fas fa-database"></i>
                                    <span>
                                        {{ $org['package_count'] }} dataset tersedia
                                    </span>
                                </div>
                            @endif

                        </div>

                        <!-- Footer -->
                        <div class="org-card-footer">

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                <div class="org-contact">
                                    @if ($org['website'])
                                        <a href="{{ $org['website'] }}" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                            Website
                                        </a>
                                    @endif
                                </div>

                                <a href="{{ route('frontend.organization', $org['id']) }}" class="btn-view-org">
                                    <i class="fas fa-arrow-right"></i>
                                    Lihat Dataset
                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-building"></i>

                <h4>Belum ada organisasi terdaftar</h4>

                <p class="mb-3">
                    Organisasi penyedia data akan muncul di sini setelah didaftarkan.
                </p>

                @if (auth()->check() && auth()->user()->is_sysadmin)
                    <a href="{{ config('ckan.base_url') }}/organization/new" target="_blank" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Organisasi di CKAN
                    </a>
                @endif
            </div>

        @endif

    </div>

@endsection
