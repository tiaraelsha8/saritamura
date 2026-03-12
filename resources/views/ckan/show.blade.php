@extends('layouts.app')

@section('title', $package['title'] ?? 'Detail Dataset')

@push('styles')
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* ===== BREADCRUMB ===== */
        .breadcrumb-section {
            background: white;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2rem;
        }

        .breadcrumb {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--text-secondary);
        }

        /* ===== DATASET HEADER ===== */
        .dataset-header {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .dataset-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .dataset-meta-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem 2rem;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .meta-item i {
            color: var(--primary-color);
            width: 18px;
            text-align: center;
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge-open {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-restricted {
            background: #fff3cd;
            color: #664d03;
        }

        /* ===== MAIN LAYOUT ===== */
        .dataset-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 1.5rem;
            align-items: start;
        }

        @media (max-width: 991px) {
            .dataset-container {
                grid-template-columns: 1fr;
            }

            .sidebar-info {
                order: 2;
            }

            .main-content {
                order: 1;
            }
        }

        /* ===== CONTENT SECTIONS ===== */
        .content-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .section-header {
            background: #f8f9fa;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header i {
            color: var(--primary-color);
        }

        .section-body {
            padding: 1.25rem;
        }

        .description-text {
            line-height: 1.7;
            color: var(--text-primary);
            white-space: pre-wrap;
        }

        /* ===== RESOURCES ===== */
        .resource-item {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
        }

        .resource-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.15);
        }

        .resource-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            gap: 1rem;
        }

        .resource-title {
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resource-title i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .resource-format {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .resource-description {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .resource-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .resource-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .resource-meta-item i {
            width: 16px;
            text-align: center;
        }

        .resource-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .resource-actions .btn {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }

        /* ===== SIDEBAR INFO ===== */
        .sidebar-info {
            position: sticky;
            top: 20px;
        }

        .info-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .info-card .section-header {
            background: #f8f9fa;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
        }

        .info-card .section-body {
            padding: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .info-value {
            color: var(--text-primary);
            text-align: right;
            word-break: break-word;
        }

        .organization-card {
            text-align: center;
            padding: 1rem;
        }

        .organization-logo {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin: 0 auto 0.75rem;
            border: 2px solid var(--border-color);
        }

        .organization-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .organization-type {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .tags-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .tag-pill {
            background: #e7f1ff;
            color: var(--primary-color);
            padding: 0.3rem 0.7rem;
            border-radius: 20px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .tag-pill:hover {
            background: var(--primary-color);
            color: white;
        }

        /* ===== ACTIVITY TIMELINE ===== */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border-color);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.25rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.65rem;
            top: 0.3rem;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 2px solid white;
        }

        .timeline-date {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .timeline-event {
            font-size: 0.9rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        /* ===== SHARE BUTTONS ===== */
        .share-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .share-btn {
            flex: 1;
            min-width: 80px;
            padding: 0.6rem;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            color: white;
            font-size: 0.85rem;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .share-btn:hover {
            opacity: 0.9;
            color: white;
        }

        .share-btn.facebook {
            background: #1877f2;
        }

        .share-btn.twitter {
            background: #1da1f2;
        }

        .share-btn.whatsapp {
            background: #25d366;
        }

        .share-btn.linkedin {
            background: #0077b5;
        }

        /* ===== CITATION BOX ===== */
        .citation-box {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: var(--text-primary);
            margin-top: 0.5rem;
        }

        /* ===== LOADING STATE ===== */
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* ===== ACTION BUTTONS ===== */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .action-buttons .btn {
            flex: 1;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .dataset-title {
                font-size: 1.4rem;
            }

            .dataset-header {
                padding: 1.25rem;
            }

            .resource-header {
                flex-direction: column;
            }

            .resource-actions {
                width: 100%;
            }

            .resource-actions .btn {
                flex: 1;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('ckan.index') }}"><i class="fas fa-home"></i> Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('ckan.datasets') }}">Dataset</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ Str::limit($package['title'] ?? $package['name'], 50) }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mb-5">
        <!-- Dataset Header -->
        <header class="dataset-header">
            <h1 class="dataset-title">
                {{ $package['title'] ?? $package['name'] }}
            </h1>

            <div class="dataset-meta-bar">
                @if($package['organization'])
                    <div class="meta-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $package['organization']['title'] ?? $package['organization']['name'] }}</span>
                    </div>
                @endif

                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Diperbarui {{ \Carbon\Carbon::parse($package['metadata_modified'])->diffForHumans() }}</span>
                </div>

                <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($package['metadata_views'] ?? 0) }} kali dilihat</span>
                </div>

                @if($package['license_id'])
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>{{ $package['license_title'] ?? $package['license_id'] }}</span>
                    </div>
                @endif

                <div class="ms-auto">
                    @if($package['private'])
                        <span class="badge badge-status badge-restricted">
                            <i class="fas fa-lock"></i> Akses Terbatas
                        </span>
                    @else
                        <span class="badge badge-status badge-open">
                            <i class="fas fa-globe"></i> Akses Terbuka
                        </span>
                    @endif
                </div>
            </div>
        </header>

        <div class="dataset-container">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Description -->
                <section class="content-section">
                    <div class="section-header">
                        <i class="fas fa-info-circle"></i>
                        <span>Deskripsi</span>
                    </div>
                    <div class="section-body">
                        <div class="description-text">
                            {!! nl2br(e($package['notes'] ?? 'Tidak ada deskripsi tersedia.')) !!}
                        </div>

                        @if(!empty($package['tags']))
                            <div class="mt-4">
                                <h6 class="mb-3 text-muted"><i class="fas fa-tags"></i> Tag:</h6>
                                <div class="tags-cloud">
                                    @foreach($package['tags'] as $tag)
                                        <a href="{{ route('ckan.datasets', ['q' => is_array($tag) ? ($tag['name'] ?? $tag) : $tag]) }}"
                                            class="tag-pill">
                                            {{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                <!-- Resources/Files -->
                <section class="content-section">
                    <div class="section-header">
                        <i class="fas fa-file-alt"></i>
                        <span>Resource & File ({{ count($package['resources'] ?? []) }})</span>
                    </div>
                    <div class="section-body">
                        @forelse($package['resources'] ?? [] as $index => $resource)
                            <div class="resource-item">
                                <div class="resource-header">
                                    <div class="resource-title">
                                        <i class="fas fa-file-download"></i>
                                        <span>{{ $resource['name'] ?? 'Resource ' . ($index + 1) }}</span>
                                    </div>
                                    <span class="resource-format">
                                        {{ strtoupper($resource['format'] ?? 'UNKNOWN') }}
                                    </span>
                                </div>

                                @if($resource['description'])
                                    <div class="resource-description">
                                        {{ $resource['description'] }}
                                    </div>
                                @endif

                                <div class="resource-meta">
                                    @if($resource['size'])
                                        <div class="resource-meta-item">
                                            <i class="fas fa-hdd"></i>
                                            <span>{{ number_format($resource['size'] / 1024 / 1024, 2) }} MB</span>
                                        </div>
                                    @endif

                                    @if($resource['created'])
                                        <div class="resource-meta-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ \Carbon\Carbon::parse($resource['created'])->format('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if($resource['mimetype'])
                                        <div class="resource-meta-item">
                                            <i class="fas fa-file-code"></i>
                                            <span>{{ $resource['mimetype'] }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="resource-actions">
                                    @if($resource['url'])
                                        <a href="{{ $resource['url'] }}" class="btn btn-primary" target="_blank" download>
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    @endif

                                    @if($resource['datastore_active'] ?? false)
                                        <!-- ✅ NEW: Preview Button -->
                                        <a href="{{ route('ckan.resource.preview', ['datasetId' => $package['id'], 'resourceId' => $resource['id']]) }}"
                                            class="btn btn-outline-success" target="_blank">
                                            <i class="fas fa-table"></i> Preview Data
                                        </a>
                                    @endif

                                    <button class="btn btn-outline-secondary"
                                        onclick="copyResourceLink('{{ $resource['url'] ?? '' }}')">
                                        <i class="fas fa-link"></i> Salin Link
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Belum ada resource/file yang diunggah untuk dataset ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <!-- Additional Information -->
                @if(!empty($package['extras']))
                    <section class="content-section">
                        <div class="section-header">
                            <i class="fas fa-list-alt"></i>
                            <span>Informasi Tambahan</span>
                        </div>
                        <div class="section-body">
                            <div class="row">
                                @foreach($package['extras'] as $extra)
                                    <div class="col-md-6 mb-3">
                                        <div class="info-row">
                                            <span class="info-label">{{ ucfirst(str_replace('_', ' ', $extra['key'])) }}</span>
                                            <span class="info-value">{{ $extra['value'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            </main>

            <!-- Sidebar -->
            <aside class="sidebar-info">
                <!-- Organization Info -->
                @if($package['organization'])
                    <div class="info-card">
                        <div class="section-header">
                            <i class="fas fa-building"></i>
                            <span>Penerbit</span>
                        </div>
                        <div class="section-body">
                            <div class="organization-card">
                                @if($package['organization']['image_url'] ?? false)
                                    <img src="{{ $package['organization']['image_url'] }}" alt="Logo" class="organization-logo"
                                        onerror="this.style.display='none'">
                                @else
                                    <div
                                        class="organization-logo d-flex align-items-center justify-content-center bg-light text-muted">
                                        <i class="fas fa-building fa-3x"></i>
                                    </div>
                                @endif
                                <div class="organization-name">
                                    {{ $package['organization']['title'] ?? $package['organization']['name'] }}
                                </div>
                                <div class="organization-type">
                                    {{ $package['organization']['type'] ?? 'Organisasi' }}
                                </div>
                                @if($package['organization']['description'])
                                    <small class="text-muted mt-2 d-block">
                                        {{ Str::limit($package['organization']['description'], 100) }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Metadata Details -->
                <div class="info-card">
                    <div class="section-header">
                        <i class="fas fa-database"></i>
                        <span>Metadata</span>
                    </div>
                    <div class="section-body">
                        <div class="info-row">
                            <span class="info-label">ID Dataset</span>
                            <span class="info-value" style="font-family: monospace; font-size: 0.8rem;">
                                {{ Str::limit($package['id'], 20) }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Dibuat</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($package['metadata_created'])->format('d M Y') }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Terakhir Diperbarui</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($package['metadata_modified'])->format('d M Y') }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Dilihat</span>
                            <span class="info-value">
                                {{ number_format($package['metadata_views'] ?? 0) }} kali
                            </span>
                        </div>

                        @if($package['version'])
                            <div class="info-row">
                                <span class="info-label">Versi</span>
                                <span class="info-value">{{ $package['version'] }}</span>
                            </div>
                        @endif

                        @if($package['state'])
                            <div class="info-row">
                                <span class="info-label">Status</span>
                                <span class="info-value">
                                    <span class="badge {{ $package['state'] === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($package['state']) }}
                                    </span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="info-card">
                    <div class="section-header">
                        <i class="fas fa-history"></i>
                        <span>Aktivitas</span>
                    </div>
                    <div class="section-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($package['metadata_created'])->format('d M Y, H:i') }}
                                </div>
                                <div class="timeline-event">
                                    Dataset dibuat
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($package['metadata_modified'])->format('d M Y, H:i') }}
                                </div>
                                <div class="timeline-event">
                                    Terakhir diperbarui
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share -->
                <div class="info-card">
                    <div class="section-header">
                        <i class="fas fa-share-alt"></i>
                        <span>Bagikan</span>
                    </div>
                    <div class="section-body">
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                class="share-btn facebook" target="_blank">
                                <i class="fab fa-facebook-f"></i> FB
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($package['title']) }}"
                                class="share-btn twitter" target="_blank">
                                <i class="fab fa-twitter"></i> TW
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($package['title'] . ' - ' . request()->url()) }}"
                                class="share-btn whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i> WA
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}"
                                class="share-btn linkedin" target="_blank">
                                <i class="fab fa-linkedin-in"></i> LI
                            </a>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm w-100 mt-2"
                            onclick="copyToClipboard('{{ request()->url() }}')">
                            <i class="fas fa-copy"></i> Salin Link
                        </button>
                    </div>
                </div>

                <!-- Citation -->
                <div class="info-card">
                    <div class="section-header">
                        <i class="fas fa-quote-left"></i>
                        <span>Kutipan</span>
                    </div>
                    <div class="section-body">
                        <small class="text-muted d-block mb-2">Gunakan format ini untuk mengutip dataset:</small>
                        <div class="citation-box">
                            {{ $package['organization']['title'] ?? 'Unknown' }}
                            ({{ \Carbon\Carbon::parse($package['metadata_created'])->format('Y') }}).
                            <em>{{ $package['title'] }}</em>.
                            Diakses dari {{ config('app.url') }}/dataset/{{ $package['id'] }}
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if(auth()->check() && (auth()->user()->is_sysadmin || auth()->id() == ($package['creator_user_id'] ?? null)))
                    <div class="action-buttons">
                        <a href="{{ route('ckan.edit', $package['id']) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>

                    <form id="delete-form" action="{{ route('ckan.destroy', $package['id']) }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Copy resource link to clipboard
        function copyResourceLink(url) {
            if (!url) {
                alert('Link tidak tersedia');
                return;
            }

            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin ke clipboard!');
            }).catch(err => {
                console.error('Gagal menyalin:', err);
                alert('Gagal menyalin link');
            });
        }

        // Copy URL to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link berhasil disalin!');
            }).catch(err => {
                console.error('Gagal menyalin:', err);
            });
        }

        // Open data preview (DataStore)
        function openDataPreview(resourceId) {
            // Implementasi preview data dari DataStore
            // Bisa menggunakan modal atau redirect ke halaman preview
            alert('Preview data untuk resource: ' + resourceId);
            // Contoh: window.open('/datastore/' + resourceId, '_blank');
        }

        // Confirm delete
        function confirmDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus dataset ini? Tindakan ini tidak dapat dibatalkan.')) {
                document.getElementById('delete-form').submit();
            }
        }

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Track view (optional - untuk analytics)
        @auth
            fetch('{{ route("ckan.track-view", $package["id"]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).catch(err => console.error('Track view error:', err));
        @endauth
    </script>
@endpush