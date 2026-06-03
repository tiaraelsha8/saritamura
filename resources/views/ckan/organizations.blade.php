@extends('layouts.app')

@section('title', 'Daftar Organisasi - Satu Data Murung Raya')

@push('styles')
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header .subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        /* ===== ORG GRID ===== */
        .org-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .org-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== ORG CARD ===== */
        .org-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .org-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .org-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .org-logo {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            object-fit: cover;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .org-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .org-logo-placeholder {
            color: var(--text-secondary);
            font-size: 1.5rem;
        }

        .org-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.4;
        }

        .org-title a {
            color: inherit;
            text-decoration: none;
        }

        .org-title a:hover {
            color: var(--primary-color);
        }

        .org-card-body {
            padding: 1.5rem;
            flex: 1;
        }

        .org-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .org-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem 1.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .org-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .org-meta-item i {
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }

        .org-dataset-count {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #e7f1ff;
            color: var(--primary-color);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .org-card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: #fafafa;
        }

        .org-contact {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .org-contact a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .org-contact a:hover {
            text-decoration: underline;
        }

        .btn-view-org {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-view-org:hover {
            background: var(--primary-dark);
            color: white;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state .btn {
            margin-top: 1rem;
        }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }
    </style>
@endpush

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1><i class="fas fa-building"></i> Organisasi</h1>
            <p class="subtitle mb-0">Daftar instansi dan organisasi penyedia data di Kabupaten Murung Raya</p>
        </div>
    </header>

    <div class="container mb-5">
        @if(isset($error))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($total) }}</div>
                <div class="stat-label">Total Organisasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">
                    {{ number_format($organizations->sum('package_count')) }}
                </div>
                <div class="stat-label">Total Dataset</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">
                    {{ number_format($organizations->filter(fn($o) => $o['package_count'] > 0)->count()) }}
                </div>
                <div class="stat-label">Aktif Publikasi</div>
            </div>
        </div>

        <!-- Organizations Grid -->
        @forelse($organizations as $org)
            <div class="org-card">
                <!-- Card Header -->
                <div class="org-card-header">
                    <div class="org-logo">
                        @if($org['image_url'])
                            <img src="{{ $org['image_url'] }}" alt="{{ $org['title'] }}"
                                onerror="this.parentElement.innerHTML='<i class=\'fas fa-building org-logo-placeholder\'></i>'">
                        @else
                            <i class="fas fa-building org-logo-placeholder"></i>
                        @endif
                    </div>
                    <h3 class="org-title">
                        <a href="{{ route('ckan.organization', $org['id']) }}">
                            {{ $org['title'] }}
                        </a>
                    </h3>
                </div>

                <!-- Card Body -->
                <div class="org-card-body">
                    <p class="org-description">
                        {{ $org['description'] }}
                    </p>

                    <div class="org-meta">
                        @if($org['address'])
                            <div class="org-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ Str::limit($org['address'], 30) }}</span>
                            </div>
                        @endif
                        @if($org['phone'])
                            <div class="org-meta-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $org['phone'] }}</span>
                            </div>
                        @endif
                        @if($org['email'])
                            <div class="org-meta-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $org['email'] }}</span>
                            </div>
                        @endif
                    </div>

                    @if($org['package_count'] > 0)
                        <div class="org-dataset-count">
                            <i class="fas fa-database"></i>
                            <span>{{ $org['package_count'] }} dataset tersedia</span>
                        </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="org-card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="org-contact">
                            @if($org['website'])
                                <a href="{{ $org['website'] }}" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Website
                                </a>
                            @endif
                        </div>
                        <a href="{{ route('ckan.organization', $org['id']) }}" class="btn-view-org">
                            <i class="fas fa-arrow-right"></i> Lihat Dataset
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-building"></i>
                <h4>Belum ada organisasi terdaftar</h4>
                <p class="mb-3">Organisasi penyedia data akan muncul di sini setelah didaftarkan.</p>
                @if(auth()->check() && auth()->user()->is_sysadmin)
                    <a href="{{ config('ckan.base_url') }}/organization/new" target="_blank" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Organisasi di CKAN
                    </a>
                @endif
            </div>
        @endforelse
    </div>
@endsection