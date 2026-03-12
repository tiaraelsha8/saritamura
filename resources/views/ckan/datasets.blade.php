@extends('layouts.app')

@section('title', 'Daftar Dataset - Satu Data Kalteng')

@push('styles')
<style>
    /* ===== THEME COLORS (Satu Data Kalteng Style) ===== */
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

    .search-box {
        background: white;
        border-radius: 8px;
        padding: 0.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 1rem;
    }

    .search-box .form-control {
        border: none;
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .search-box .form-control:focus {
        box-shadow: none;
    }

    .search-box .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }

    /* ===== LAYOUT ===== */
    .datasets-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 991px) {
        .datasets-container {
            grid-template-columns: 1fr;
        }
        .sidebar {
            order: 2;
        }
        .main-content {
            order: 1;
        }
    }

    /* ===== SIDEBAR FILTERS ===== */
    .sidebar {
        position: sticky;
        top: 20px;
    }

    .filter-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .filter-card .card-header {
        background: #f8f9fa;
        border-bottom: 1px solid var(--border-color);
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .filter-card .card-header:hover {
        background: #e9ecef;
    }

    .filter-card .card-body {
        padding: 1rem;
        max-height: 250px;
        overflow-y: auto;
    }

    .filter-item {
        display: flex;
        align-items: center;
        padding: 0.4rem 0;
        font-size: 0.9rem;
        color: var(--text-primary);
        cursor: pointer;
    }

    .filter-item:hover {
        color: var(--primary-color);
    }

    .filter-item input {
        margin-right: 0.5rem;
    }

    .filter-count {
        margin-left: auto;
        font-size: 0.8rem;
        color: var(--text-secondary);
        background: #e9ecef;
        padding: 0.1rem 0.5rem;
        border-radius: 20px;
    }

    .filter-actions {
        padding: 0.75rem 1rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        gap: 0.5rem;
    }

    .filter-actions .btn {
        flex: 1;
        font-size: 0.85rem;
        padding: 0.4rem;
    }

    /* ===== DATASET CARDS ===== */
    .datasets-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .datasets-count {
        font-size: 0.95rem;
        color: var(--text-secondary);
    }

    .view-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .view-controls select {
        font-size: 0.9rem;
        padding: 0.4rem 2rem 0.4rem 0.75rem;
    }

    .view-toggle .btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.9rem;
    }

    .view-toggle .btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .dataset-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid transparent;
    }

    .dataset-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        border-left-color: var(--primary-color);
    }

    .dataset-card .dataset-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .dataset-card .dataset-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: color 0.2s;
    }

    .dataset-card .dataset-title a:hover {
        color: var(--primary-color);
    }

    .dataset-card .dataset-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .dataset-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem 1.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0.75rem;
    }

    .dataset-meta-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .dataset-meta-item i {
        width: 16px;
        text-align: center;
        color: var(--primary-color);
    }

    .dataset-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-bottom: 1rem;
    }

    .dataset-tag {
        background: #e7f1ff;
        color: var(--primary-color);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dataset-tag:hover {
        background: #cfe2ff;
    }

    .dataset-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-color);
    }

    .dataset-org {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .dataset-org img {
        width: 24px;
        height: 24px;
        border-radius: 4px;
        object-fit: cover;
    }

    .dataset-actions .btn {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
    }

    .badge-license {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .badge-open {
        background: #d1e7dd;
        color: #0f5132;
    }

    .badge-restricted {
        background: #fff3cd;
        color: #664d03;
    }

    /* ===== PAGINATION ===== */
    .pagination-container {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-top: 1rem;
    }

    .pagination .page-link {
        color: var(--primary-color);
        border-color: var(--border-color);
        padding: 0.5rem 0.85rem;
        font-size: 0.9rem;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-link:hover {
        background: #e7f1ff;
        border-color: #b6d4fe;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .empty-state .btn {
        margin-top: 1rem;
    }

    /* ===== LOADING STATE ===== */
    .loading-card {
        background: white;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .loading-line {
        height: 1rem;
        background: #e9ecef;
        border-radius: 4px;
        margin-bottom: 0.5rem;
    }

    .loading-line.short { width: 60%; }
    .loading-line.medium { width: 80%; }
    .loading-line.long { width: 100%; }
</style>
@endpush

@section('content')
<!-- Page Header -->
<header class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1><i class="fas fa-database"></i> Dataset</h1>
                <p class="subtitle mb-0">Temukan dan eksplorasi data terbuka dari Pemerintah Provinsi Kalimantan Tengah</p>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('ckan.datasets') }}" method="GET" class="search-box">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" 
                               value="{{ $filters['q'] ?? '' }}"
                               placeholder="Cari dataset, topik, atau instansi...">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container mb-5">
    @if(isset($error))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="datasets-container">
        <!-- Sidebar Filters -->
    <form method="GET" action="{{ route('ckan.datasets') }}" id="filterForm">
    <!-- Sidebar Filters -->
    <aside class="sidebar">
        <!-- Organization Filter -->
        <div class="filter-card">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filterOrg">
                <span><i class="fas fa-building"></i> Organisasi</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div id="filterOrg" class="collapse show">
                <div class="card-body">
                    @foreach($organizations as $org)
                    <label class="filter-item">
                        <input type="checkbox" 
                               name="organizations[]" 
                               value="{{ $org['name'] }}"
                               
                               id="org-{{ $org['id'] }}"
                               {{ in_array($org['id'], $filters['organizations'] ?? []) ? 'checked' : '' }}
                               onchange="applyFilter()">
                        <span class="text-truncate" style="max-width: 150px;">
                            {{ $org['title'] ?? $org['name'] }}
                        </span>
                        <span class="filter-count">{{ $org['package_count'] ?? 0 }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="filter-actions">
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="clearFilters()">
                        <i class="fas fa-undo"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        <!-- Tags Filter -->
        <div class="filter-card">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#filterTags">
                <span><i class="fas fa-tags"></i> Tags</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div id="filterTags" class="collapse show">
                <div class="card-body">
                    @forelse($popularTags ?? [] as $tag)
                    <label class="filter-item">
                        <input type="checkbox" 
                               name="tags[]" 
                               value="{{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}"
                               id="tag-{{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}"
                               {{ in_array(is_array($tag) ? ($tag['name'] ?? $tag) : $tag, $filters['tags'] ?? []) ? 'checked' : '' }}
                               onchange="applyFilter()">
                        <span>{{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}</span>
                        <span class="filter-count">{{ $tag['count'] ?? 0 }}</span>
                    </label>
                    @empty
                    <small class="text-muted">Memuat tags...</small>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Hidden input untuk preserve other filters -->
        <input type="hidden" name="q" value="{{ $filters['q'] ?? '' }}">
        <input type="hidden" name="sort" value="{{ $filters['sort'] ?? '' }}">
        <input type="hidden" name="per_page" value="{{ $filters['per_page'] ?? 10 }}">
    </aside>
</form>

        <!-- Main Content: Dataset List -->
        <main class="main-content">
            <!-- Header Controls -->
            <div class="datasets-header">
                <div class="datasets-count">
                    <strong>{{ number_format($pagination['total'] ?? 0) }}</strong> dataset ditemukan
                    @if($filters['q'])
                    <span class="text-muted">untuk "<strong>{{ $filters['q'] }}</strong>"</span>
                    @endif
                </div>
                <div class="view-controls">
                    <select name="sort" class="form-select form-select-sm" style="width: auto;" onchange="this.form?.submit()">
                        <option value="metadata_modified desc" {{ ($filters['sort'] ?? '') == 'metadata_modified desc' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="metadata_modified asc" {{ ($filters['sort'] ?? '') == 'metadata_modified asc' ? 'selected' : '' }}>
                            Terlama
                        </option>
                        <option value="title_string asc" {{ ($filters['sort'] ?? '') == 'title_string asc' ? 'selected' : '' }}>
                            Judul A-Z
                        </option>
                        <option value="views_recent desc" {{ ($filters['sort'] ?? '') == 'views_recent desc' ? 'selected' : '' }}>
                            Paling Dilihat
                        </option>
                    </select>
                    <select name="per_page" class="form-select form-select-sm" style="width: auto;" onchange="this.form?.submit()">
                        <option value="10" {{ ($filters['per_page'] ?? 10) == 10 ? 'selected' : '' }}>10/hal</option>
                        <option value="25" {{ ($filters['per_page'] ?? 10) == 25 ? 'selected' : '' }}>25/hal</option>
                        <option value="50" {{ ($filters['per_page'] ?? 10) == 50 ? 'selected' : '' }}>50/hal</option>
                    </select>
                </div>
            </div>

            <!-- Dataset Cards -->
            @forelse($datasets as $dataset)
            <article class="dataset-card">
                <!-- Title -->
                <h3 class="dataset-title">
                    <a href="{{ route('ckan.show', $dataset['id']) }}">
                        {{ $dataset['title'] ?? $dataset['name'] }}
                    </a>
                </h3>

                <!-- Description -->
                <p class="dataset-description">
                    {{ $dataset['notes'] ?? 'Tidak ada deskripsi tersedia.' }}
                </p>

                <!-- Tags -->
                @if(!empty($dataset['tags']))
                <div class="dataset-tags">
                    @foreach(array_slice($dataset['tags'], 0, 4) as $tag)
                    <a href="{{ route('ckan.datasets', array_merge($filters, ['q' => is_array($tag) ? ($tag['name'] ?? $tag) : $tag])) }}" 
                       class="dataset-tag">
                        {{ is_array($tag) ? ($tag['name'] ?? $tag) : $tag }}
                    </a>
                    @endforeach
                    @if(count($dataset['tags']) > 4)
                    <span class="dataset-tag" style="background: #dee2e6; color: #495057;">
                        +{{ count($dataset['tags']) - 4 }}
                    </span>
                    @endif
                </div>
                @endif

                <!-- Metadata -->
                <div class="dataset-meta">
                    <div class="dataset-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Updated: {{ \Carbon\Carbon::parse($dataset['metadata_modified'])->format('d M Y') }}</span>
                    </div>
                    <div class="dataset-meta-item">
                        <i class="fas fa-file"></i>
                        <span>{{ count($dataset['resources'] ?? []) }} resource</span>
                    </div>
                    <div class="dataset-meta-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ $dataset['metadata_views'] ?? 0 }} views</span>
                    </div>
                    @if($dataset['license_id'])
                    <div class="dataset-meta-item">
                        <i class="fas fa-certificate"></i>
                        <span class="badge badge-license {{ $dataset['private'] ? 'badge-restricted' : 'badge-open' }}">
                            {{ $dataset['license_title'] ?? $dataset['license_id'] }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="dataset-footer">
                    <div class="dataset-org">
                        @if($dataset['organization'])
                            @if($dataset['organization']['image_url'] ?? false)
                            <img src="{{ $dataset['organization']['image_url'] }}" alt="" onerror="this.style.display='none'">
                            @endif
                            <span>
                                {{ $dataset['organization']['title'] ?? $dataset['organization']['name'] }}
                            </span>
                        @else
                            <i class="fas fa-building"></i> Tanpa organisasi
                        @endif
                    </div>
                    <div class="dataset-actions">
                        <a href="{{ route('ckan.show', $dataset['id']) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <!-- Empty State -->
            <div class="filter-card">
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h5>Tidak ada dataset ditemukan</h5>
                    <p class="mb-3">Coba ubah kata kunci pencarian atau hapus filter untuk melihat hasil lebih banyak.</p>
                    <a href="{{ route('ckan.datasets') }}" class="btn btn-primary">
                        <i class="fas fa-undo"></i> Reset Pencarian
                    </a>
                    @if(auth()->check())
                    <a href="{{ route('ckan.create') }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-plus"></i> Tambah Dataset
                    </a>
                    @endif
                </div>
            </div>
            @endforelse

            <!-- Pagination -->
            @if(($pagination['total'] ?? 0) > 0)
            <div class="pagination-container">
                <nav>
                    <ul class="pagination justify-content-center mb-0">
                        {{-- Previous --}}
                        @if($pagination['current_page'] > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('ckan.datasets', array_merge($filters, ['page' => $pagination['current_page'] - 1])) }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                            <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('ckan.datasets', array_merge($filters, ['page' => $i])) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        {{-- Next --}}
                        @if($pagination['current_page'] < $pagination['last_page'])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('ckan.datasets', array_merge($filters, ['page' => $pagination['current_page'] + 1])) }}">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
                <div class="text-center text-muted small mt-2">
                    Halaman {{ $pagination['current_page'] }} dari {{ $pagination['last_page'] }}
                    • Menampilkan {{ $pagination['from'] }}-{{ $pagination['to'] }} dari {{ $pagination['total'] }} dataset
                </div>
            </div>
            @endif
        </main>
    </div>
</div>

@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    document.querySelectorAll('input[type="checkbox"][onchange]').forEach(input => {
        input.addEventListener('change', function() {
            // Reset to page 1 when filter changes
            const form = this.closest('form') || document.querySelector('form');
            if (form) {
                const pageInput = form.querySelector('input[name="page"]');
                if (pageInput) pageInput.value = 1;
                form.submit();
            }
        });
    });

    // Clear specific filter
    window.clearFilter = function(filterName) {
        const form = document.querySelector('form');
        if (form) {
            // Remove all checkboxes for this filter
            form.querySelectorAll(`input[name="${filterName}[]"], input[name="${filterName}"]`).forEach(el => {
                el.checked = false;
            });
            form.querySelector('input[name="page"]')?.remove();
            form.submit();
        }
    };

    // Collapsible filter sections (mobile friendly)
    document.querySelectorAll('.filter-card .card-header').forEach(header => {
        header.addEventListener('click', function(e) {
            if (window.innerWidth < 992) {
                const target = this.getAttribute('data-bs-target');
                const collapse = document.querySelector(target);
                if (collapse) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapse) || new bootstrap.Collapse(collapse);
                    bsCollapse.toggle();
                }
            }
        });
    });
});
</script>
@endpush

@push('scripts')
<script>
// Apply filter when checkbox changes
function applyFilter() {
    // Reset to page 1 when filter changes
    const form = document.getElementById('filterForm');
    
    // Update hidden inputs with current values
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        const existingQ = new URLSearchParams(window.location.search).get('q');
        if (existingQ && !searchInput.value) {
            searchInput.value = existingQ;
        }
    }
    
    // Submit form
    form.submit();
}

// Clear all filters
function clearFilters() {
    const form = document.getElementById('filterForm');
    
    // Uncheck all checkboxes
    form.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });
    
    // Clear search input
    const searchInput = form.querySelector('input[name="q"]');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Submit to clear
    form.submit();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add click handler to search box to preserve filters
    const searchForm = document.querySelector('form[role="search"]');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Merge filter form values
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                const filterInputs = filterForm.querySelectorAll('input[name]:not([type="hidden"])');
                filterInputs.forEach(input => {
                    if (input.checked || input.type !== 'checkbox') {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = input.name;
                        hiddenInput.value = input.value;
                        searchForm.appendChild(hiddenInput);
                    }
                });
            }
        });
    }
});
</script>
@endpush