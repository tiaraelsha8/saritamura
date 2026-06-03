<!-- @push('styles')
    <style>
        /* ===== HERO SECTION ===== */
        .hero-section {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 5rem 0;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        /* ===== SEARCH BOX ===== */
        .hero-search {
            background: white;
            border-radius: 16px;
            padding: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .search-form .input-group {
            display: flex;
            gap: 0.5rem;
        }

        .search-form .form-control {
            flex: 1;
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 12px;
            outline: none;
            box-shadow: none;
        }

        .search-form .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
        }

        .search-form .btn-search {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .search-form .btn-search:hover {
            transform: translateY(-2px);
            color: white;
        }

        /* ===== AUTO-COMPLETE DROPDOWN ===== */
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0.5rem;
            right: 0.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-top: 0.5rem;
            z-index: 1000;
            overflow: hidden;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .autocomplete-header {
            padding: 0.75rem 1rem;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
        }

        .autocomplete-header i {
            margin-right: 0.5rem;
        }

        .autocomplete-results {
            max-height: 300px;
            overflow-y: auto;
        }

        .autocomplete-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem;
            border-bottom: 1px solid #f1f3f5;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .autocomplete-item:hover,
        .autocomplete-item.active {
            background: #e7f1ff;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item-icon {
            width: 40px;
            height: 40px;
            background: #e7f1ff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .autocomplete-item-icon i {
            color: #3b82f6;
            font-size: 1.2rem;
        }

        .autocomplete-item-content {
            flex: 1;
            min-width: 0;
        }

        .autocomplete-item-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: #1e293b;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .autocomplete-item-org {
            font-size: 0.8rem;
            color: #64748b;
        }

        .autocomplete-item-type {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 0.25rem;
        }

        .autocomplete-footer {
            padding: 0.75rem 1rem;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }

        .autocomplete-footer .view-all-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: block;
        }

        .autocomplete-footer .view-all-link:hover {
            color: #1e40af;
        }

        /* ===== LOADING STATE ===== */
        .autocomplete-loading {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }

        .autocomplete-loading .spinner-border {
            width: 2rem;
            height: 2rem;
            color: #3b82f6;
        }

        /* ===== NO RESULTS ===== */
        .autocomplete-no-results {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
        }

        .autocomplete-no-results i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #dee2e6;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .search-form .input-group {
                flex-direction: column;
            }

            .search-form .btn-search {
                width: 100%;
            }

            .autocomplete-dropdown {
                left: 0;
                right: 0;
                margin-left: 0;
                margin-right: 0;
                border-radius: 0 0 12px 12px;
            }
        }
    </style>
@endpush -->

@extends('layouts.app')

@section('title', 'Portal Data CKAN')

@section('content')

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
                <div class="hero-search position-relative">
                    <form action="{{ route('ckan.datasets') }}" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control search-input" id="heroSearchInput"
                                placeholder="Cari dataset, topik, atau instansi..." autocomplete="off"
                                aria-label="Cari dataset" aria-describedby="searchButton">
                            <button type="submit" class="btn btn-search" id="searchButton">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    <div class="autocomplete-dropdown" id="autocompleteDropdown" style="display: none;">
                        <div class="autocomplete-header">
                            <i class="fas fa-history"></i> Saran Pencarian
                        </div>
                        <div class="autocomplete-results" id="autocompleteResults">
                        </div>
                        <div class="autocomplete-footer">
                            <a href="{{ route('ckan.datasets') }}" class="view-all-link">
                                <i class="fas fa-th"></i> Lihat Semua Dataset
                            </a>
                        </div>
                    </div>
                </div>
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

@push('scripts')
    <script>
        // Auto-Complete Search Class
        class AutocompleteSearch {
            constructor(config) {
                this.input = document.getElementById(config.inputId);
                this.dropdown = document.getElementById(config.dropdownId);
                this.resultsContainer = document.getElementById(config.resultsId);
                this.apiUrl = config.apiUrl;
                this.delay = config.delay || 300;
                this.minChars = config.minChars || 2;
                this.maxSuggestions = config.maxSuggestions || 3;

                this.timeout = null;
                this.abortController = null;
                this.selectedIndex = -1;
                this.suggestions = [];

                this.init();
            }

            init() {
                if (!this.input) return;

                // Listen for input
                this.input.addEventListener('input', (e) => this.onInput(e));

                // Listen for keyboard navigation
                this.input.addEventListener('keydown', (e) => this.onKeydown(e));

                // Close dropdown on click outside
                document.addEventListener('click', (e) => {
                    if (!this.input.contains(e.target) && !this.dropdown.contains(e.target)) {
                        this.hideDropdown();
                    }
                });

                // Hide on blur (with delay to allow click)
                this.input.addEventListener('blur', () => {
                    setTimeout(() => this.hideDropdown(), 200);
                });
            }

            onInput(e) {
                const query = e.target.value.trim();

                // Clear previous timeout
                if (this.timeout) clearTimeout(this.timeout);

                // Hide if query is too short
                if (query.length < this.minChars) {
                    this.hideDropdown();
                    return;
                }

                // Debounce search
                this.timeout = setTimeout(() => {
                    this.search(query);
                }, this.delay);
            }

            onKeydown(e) {
                if (!this.dropdown.style.display || this.dropdown.style.display === 'none') {
                    return;
                }

                const items = this.dropdown.querySelectorAll('.autocomplete-item');

                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        this.selectedIndex = Math.min(this.selectedIndex + 1, items.length - 1);
                        this.highlightSelection(items);
                        break;

                    case 'ArrowUp':
                        e.preventDefault();
                        this.selectedIndex = Math.max(this.selectedIndex - 1, 0);
                        this.highlightSelection(items);
                        break;

                    case 'Enter':
                        e.preventDefault();
                        if (this.selectedIndex >= 0 && items[this.selectedIndex]) {
                            items[this.selectedIndex].click();
                        }
                        break;

                    case 'Escape':
                        this.hideDropdown();
                        break;
                }
            }

            highlightSelection(items) {
                items.forEach((item, index) => {
                    if (index === this.selectedIndex) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            }

            async search(query) {
                // Cancel previous request
                if (this.abortController) {
                    this.abortController.abort();
                }
                this.abortController = new AbortController();

                this.showLoading();

                try {
                    const params = new URLSearchParams({
                        q: query,
                        limit: this.maxSuggestions,
                    });

                    const response = await fetch(`${this.apiUrl}?${params}`, {
                        signal: this.abortController.signal,
                    });

                    const result = await response.json();

                    if (!result.success) {
                        throw new Error(result.error || 'Search failed');
                    }

                    this.suggestions = result.suggestions || [];
                    this.renderSuggestions(this.suggestions);

                } catch (error) {
                    if (error.name === 'AbortError') return;
                    console.error('Autocomplete error:', error);
                    this.showError();
                }
            }

            showLoading() {
                this.resultsContainer.innerHTML = `
                                                                                                <div class="autocomplete-loading">
                                                                                                    <div class="spinner-border" role="status"></div>
                                                                                                    <p class="mt-2 mb-0">Mencari...</p>
                                                                                                </div>
                                                                                            `;
                this.showDropdown();
            }

            showError() {
                this.resultsContainer.innerHTML = `
                                                                                                <div class="autocomplete-no-results">
                                                                                                    <i class="fas fa-exclamation-circle"></i>
                                                                                                    <p class="mb-0">Gagal memuat saran</p>
                                                                                                </div>
                                                                                            `;
            }

            renderSuggestions(suggestions) {
                if (!suggestions || suggestions.length === 0) {
                    this.resultsContainer.innerHTML = `
                                                                                                    <div class="autocomplete-no-results">
                                                                                                        <i class="fas fa-search"></i>
                                                                                                        <p class="mb-0">Tidak ada saran ditemukan</p>
                                                                                                    </div>
                                                                                                `;
                    this.showDropdown();
                    return;
                }

                let html = '';

                suggestions.forEach((item, index) => {
                    html += `
                                                                                                    <a href="{{ route('ckan.datasets') }}?q=${encodeURIComponent(item.title)}" 
                                                                                                       class="autocomplete-item"
                                                                                                       data-index="${index}">
                                                                                                        <div class="autocomplete-item-icon">
                                                                                                            <i class="fas fa-database"></i>
                                                                                                        </div>
                                                                                                        <div class="autocomplete-item-content">
                                                                                                            <div class="autocomplete-item-title">${this.escapeHtml(item.title)}</div>
                                                                                                            ${item.organization ? `<div class="autocomplete-item-org"><i class="fas fa-building"></i> ${this.escapeHtml(item.organization)}</div>` : ''}
                                                                                                            <span class="autocomplete-item-type"><i class="fas fa-tag"></i> Dataset</span>
                                                                                                        </div>
                                                                                                    </a>
                                                                                                `;
                });

                this.resultsContainer.innerHTML = html;
                this.selectedIndex = -1;
                this.showDropdown();
            }

            showDropdown() {
                if (this.dropdown) {
                    this.dropdown.style.display = 'block';
                }
            }

            hideDropdown() {
                if (this.dropdown) {
                    this.dropdown.style.display = 'none';
                }
                this.selectedIndex = -1;
            }

            escapeHtml(text) {
                if (!text) return '';
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, m => map[m]);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('heroSearchInput')) {
                window.autocompleteSearch = new AutocompleteSearch({
                    inputId: 'heroSearchInput',
                    dropdownId: 'autocompleteDropdown',
                    resultsId: 'autocompleteResults',
                    apiUrl: "{{ route('ckan.api.autocomplete') }}",
                    delay: 300,
                    minChars: 2,
                    maxSuggestions: 10,  // ✅ Only show 3 suggestions
                });
            }
        });
    </script>
@endpush