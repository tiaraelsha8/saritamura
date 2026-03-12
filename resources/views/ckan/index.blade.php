@extends('layouts.app')

@section('title', 'Portal Data CKAN')

@section('content')
    {{-- 🔍 DEBUG SECTION (Hapus setelah fix) --}}
    <div class="alert alert-info mb-4">
        <h6>🔍 Debug Info:</h6>
        <pre class="mb-0 small">
            Stats: {{ json_encode($stats ?? 'NULL', JSON_PRETTY_PRINT) }}
            Recent Packages Count: {{ count($recentPackages ?? []) }}
            Organizations Count: {{ count($organizations ?? []) }}
                </pre>
    </div>

    <div class="container py-5">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">Portal Data CKAN</h1>
                <p class="lead text-muted">Akses dan kelola data terbuka dengan mudah</p>
                <a href="{{ route('ckan.create') }}" class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-plus"></i> Tambah Dataset
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h2 class="text-primary">{{ $stats['package_count'] ?? 0 }}</h2>
                        <p class="text-muted">Dataset</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h2 class="text-success">{{ $stats['organization_count'] ?? 0 }}</h2>
                        <p class="text-muted">Organisasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h2 class="text-info">{{ $stats['group_count'] ?? 0 }}</h2>
                        <p class="text-muted">Grup</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h2 class="text-warning">{{ $stats['resource_count'] ?? 0 }}</h2>
                        <p class="text-muted">Resource</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('ckan.search') }}" method="GET" class="card p-4 shadow-sm">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" placeholder="Cari dataset..."
                            value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Packages -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Dataset Terbaru</h2>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Dataset Terbaru</h2>
                        <div>
                            <a href="{{ route('ckan.datasets') }}" class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-table"></i> Lihat Semua dalam Tabel
                            </a>
                            <a href="{{ route('ckan.search') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-search"></i> Cari
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('ckan.search') }}" class="btn btn-outline-primary">Lihat Semua</a>
                </div>
            </div>

            @forelse($recentPackages as $package)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('ckan.show', $package['id']) }}" class="text-decoration-none">
                                    {{ $package['title'] ?? $package['name'] }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($package['notes'] ?? 'Tidak ada deskripsi', 150) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-building"></i>
                                    {{ $package['organization']['title'] ?? 'Tanpa Organisasi' }}
                                </small>
                                <span class="badge bg-primary">
                                    {{ $package['resources'] ? count($package['resources']) : 0 }} Resource
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <small class="text-muted">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($package['metadata_modified'])->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Belum ada dataset. <a href="{{ route('ckan.create') }}">Tambah dataset pertama</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Organizations -->
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="mb-4">Organisasi</h2>
            </div>

            @forelse(array_slice($organizations, 0, 6) as $org)
                <div class="col-md-2 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <a href="{{ route('ckan.organization', $org['id']) }}" class="text-decoration-none">
                                <h6 class="card-title">{{ Str::limit($org['title'] ?? $org['name'], 20) }}</h6>
                                <small class="text-muted">{{ $org['package_count'] ?? 0 }} dataset</small>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">Belum ada organisasi</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection