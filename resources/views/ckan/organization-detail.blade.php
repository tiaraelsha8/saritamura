@extends('layouts.app')

@section('title', $organization['title'] ?? 'Detail Organisasi')

@push('styles')
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* ===== ORG HEADER ===== */
        .org-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .org-header-content {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .org-logo-large {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .org-logo-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .org-logo-large i {
            font-size: 3rem;
            color: var(--text-secondary);
        }

        .org-info h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .org-stats {
            display: flex;
            gap: 2rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }

        .org-stat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        .org-stat i {
            color: var(--primary-color);
            width: 20px;
            text-align: center;
        }

        .org-description {
            color: var(--text-primary);
            line-height: 1.7;
            margin: 1rem 0;
        }

        .org-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .contact-item i {
            color: var(--primary-color);
            width: 20px;
        }

        .contact-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        /* ===== DATASETS SECTION ===== */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section-header h2 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dataset-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .dataset-grid {
                grid-template-columns: 1fr;
            }
        }

        .dataset-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
            border-left: 4px solid transparent;
        }

        .dataset-card:hover {
            transform: translateY(-2px);
            border-left-color: var(--primary-color);
        }

        .dataset-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .dataset-title a {
            color: var(--text-primary);
            text-decoration: none;
        }

        .dataset-title a:hover {
            color: var(--primary-color);
        }

        .dataset-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .dataset-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .dataset-meta-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .dataset-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.75rem;
        }

        .dataset-tag {
            background: #e7f1ff;
            color: var(--primary-color);
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* ===== PAGINATION ===== */
        .pagination-container {
            margin-top: 2rem;
            text-align: center;
        }

        .pagination .page-link {
            color: var(--primary-color);
            border-color: var(--border-color);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* ===== EMPTY STATE ===== */
        .empty-datasets {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .empty-datasets i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ckan.index') }}"><i class="fas fa-home"></i> Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ckan.organizations') }}">Organisasi</a></li>
                <li class="breadcrumb-item active">{{ $organization['title'] }}</li>
            </ol>
        </nav>

        <!-- Organization Header -->
        <header class="org-header">
            <div class="org-header-content">
                <div class="org-logo-large">
                    @if($organization['image_url'])
                        <img src="{{ $organization['image_url'] }}" alt="{{ $organization['title'] }}"
                            onerror="this.parentElement.innerHTML='<i class=\'fas fa-building\'></i>'">
                    @else
                        <i class="fas fa-building"></i>
                    @endif
                </div>
                <div class="org-info" style="flex: 1; min-width: 250px;">
                    <h1>{{ $organization['title'] }}</h1>

                    <div class="org-stats">
                        <div class="org-stat">
                            <i class="fas fa-database"></i>
                            <span>{{ $organization['package_count'] ?? 0 }} dataset</span>
                        </div>
                        @if($organization['created'])
                            <div class="org-stat">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Bergabung {{ \Carbon\Carbon::parse($organization['created'])->format('M Y') }}</span>
                            </div>
                        @endif
                    </div>

                    <p class="org-description">
                        {{ $organization['description'] }}
                    </p>

                    <div class="org-contact-grid">
                        @if($organization['address'])
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $organization['address'] }}</span>
                            </div>
                        @endif
                        @if($organization['phone'])
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $organization['phone'] }}">{{ $organization['phone'] }}</a>
                            </div>
                        @endif
                        @if($organization['email'])
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $organization['email'] }}">{{ $organization['email'] }}</a>
                            </div>
                        @endif
                        @if($organization['website'])
                            <div class="contact-item">
                                <i class="fas fa-globe"></i>
                                <a href="{{ $organization['website'] }}" target="_blank">Website</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Datasets Section -->
        <section>
            <div class="section-header">
                <h2><i class="fas fa-database"></i> Dataset dari {{ $organization['title'] }}</h2>
                @if($pagination['total'] > 0)
                    <span class="text-muted small">
                        {{ $pagination['total'] }} dataset ditemukan
                    </span>
                @endif
            </div>

            @forelse($datasets as $dataset)
                <div class="dataset-card">
                    <h3 class="dataset-title">
                        <a href="{{ route('ckan.show', $dataset['id']) }}">
                            {{ $dataset['title'] }}
                        </a>
                    </h3>
                    <p class="dataset-description">
                        {{ $dataset['notes'] }}
                    </p>

                    @if(!empty($dataset['tags']))
                        <div class="dataset-tags">
                            @foreach(array_slice($dataset['tags'], 0, 3) as $tag)
                                <span class="dataset-tag">
                                    {{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="dataset-meta">
                        <div class="dataset-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($dataset['metadata_modified'])->format('d M Y') }}</span>
                        </div>
                        <div class="dataset-meta-item">
                            <i class="fas fa-file"></i>
                            <span>{{ $dataset['resource_count'] }} file</span>
                        </div>
                        @if($dataset['license_id'])
                            <div class="dataset-meta-item">
                                <i class="fas fa-certificate"></i>
                                <span>{{ $dataset['license_id'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-datasets">
                    <i class="fas fa-inbox"></i>
                    <h5>Belum ada dataset</h5>
                    <p class="mb-3">{{ $organization['title'] }} belum mempublikasikan dataset.</p>
                    @if(auth()->check() && auth()->user()->is_sysadmin)
                        <a href="{{ config('ckan.base_url') }}/dataset/new?owner_org={{ $organization['id'] }}" target="_blank"
                            class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Dataset
                        </a>
                    @endif
                </div>
            @endforelse

            <!-- Pagination -->
            @if($pagination['total'] > 0 && $pagination['last_page'] > 1)
                <div class="pagination-container">
                    <nav>
                        <ul class="pagination justify-content-center">
                            @if($pagination['current_page'] > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('ckan.organization', [$organization['id'], 'page' => $pagination['current_page'] - 1]) }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">←</span></li>
                            @endif

                            @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ route('ckan.organization', [$organization['id'], 'page' => $i]) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            @if($pagination['current_page'] < $pagination['last_page'])
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('ckan.organization', [$organization['id'], 'page' => $pagination['current_page'] + 1]) }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">→</span></li>
                            @endif
                        </ul>
                    </nav>
                    <small class="text-muted">
                        Halaman {{ $pagination['current_page'] }} dari {{ $pagination['last_page'] }}
                    </small>
                </div>
            @endif
        </section>
    </div>
@endsection