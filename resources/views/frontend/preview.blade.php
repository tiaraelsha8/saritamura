@extends('layouts.app')

@section('title', 'Preview Data - ' . ($resource['name'] ?? 'Resource'))

@push('styles')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

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

        /* ===== PAGE HEADER ===== */
        .preview-header {
            background: white;
            border-radius: 8px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .preview-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .preview-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .preview-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge-format {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ===== CONTAINERS ===== */
        .table-container,
        .chart-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .table-controls,
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-search {
            position: relative;
            max-width: 300px;
        }

        .table-search input {
            padding-left: 2.5rem;
        }

        .table-search i {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .table-actions,
        .chart-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* ===== DATATABLES ===== */
        .dataTables_wrapper .dataTables_length select {
            padding: 0.375rem 2rem 0.375rem 0.75rem;
            border-radius: 6px;
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin: 0 0.1rem;
            border-radius: 4px;
            color: var(--primary-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e7f1ff !important;
        }

        .data-table {
            width: 100% !important;
        }

        .data-table thead th {
            background: #f8f9fa;
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
        }

        .data-table thead th.sorting_asc::after,
        .data-table thead th.sorting_desc::after {
            content: '';
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 0.5rem;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
        }

        .data-table thead th.sorting_asc::after {
            border-bottom: 5px solid var(--primary-color);
        }

        .data-table thead th.sorting_desc::after {
            border-top: 5px solid var(--primary-color);
        }

        .data-table tbody td {
            font-size: 0.9rem;
            color: var(--text-primary);
            vertical-align: middle;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* ===== CHART STYLES ===== */
        .chart-section {
            margin-top: 2rem;
        }

        .chart-header {
            background: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .chart-header h6 {
            margin: 0;
            font-weight: 600;
        }

        .chart-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .chart-controls .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
        }

        .chart-controls .form-select {
            font-size: 0.9rem;
        }

        .chart-container {
            position: relative;
            height: 400px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
        }

        /* ===== LOADING STATES ===== */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 8px;
            flex-direction: column;
        }

        .loading-spinner {
            text-align: center;
        }

        .loading-spinner .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-color);
        }

        /* Progress bar */
        .loading-progress {
            width: 200px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            border-radius: 2px;
            animation: progress 1.5s ease-in-out infinite;
            width: 30%;
        }

        @keyframes progress {
            0% {
                transform: translateX(-100%);
            }

            50% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .loading-timer {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Chart loading */
        .chart-loading {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 8px;
        }

        .chart-loading .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-color);
        }

        /* Error states */
        .empty-state,
        .chart-error {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i,
        .chart-error i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        /* Chart tip */
        .chart-tip {
            background: #e7f1ff;
            border-left: 4px solid var(--primary-color);
            padding: 0.75rem 1rem;
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--text-primary);
            margin-top: 1rem;
        }

        /* Export dropdown */
        .export-dropdown .dropdown-menu {
            min-width: 200px;
        }

        .export-dropdown .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .table-controls,
            .chart-header,
            .chart-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-search {
                max-width: 100%;
            }

            .data-table {
                font-size: 0.85rem;
            }

            .data-table tbody td {
                max-width: 150px;
            }

            .chart-container {
                height: 300px;
            }

            .chart-controls {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('ckan.index') }}"><i class="fas fa-home"></i> Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ckan.datasets') }}">Dataset</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('ckan.show', $package['id']) }}">{{ Str::limit($package['title'], 40) }}</a></li>
                <li class="breadcrumb-item active">Preview Data</li>
            </ol>
        </nav>

        <!-- Header -->
        <header class="preview-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h1 class="preview-title"><i class="fas fa-table"></i> Preview: {{ $resource['name'] ?? 'Resource' }}
                    </h1>
                    <div class="preview-meta">
                        <div class="preview-meta-item">
                            <i class="fas fa-file"></i>
                            <span class="badge-format">{{ strtoupper($resource['format'] ?? 'UNKNOWN') }}</span>
                        </div>
                        @if ($resource['size'])
                            <div class="preview-meta-item">
                                <i class="fas fa-hdd"></i>
                                <span>{{ number_format($resource['size'] / 1024 / 1024, 2) }} MB</span>
                            </div>
                        @endif
                        @if ($resource['created'])
                                        <div class="preview-meta-item">
                                            <i class="fas fa-clock"></i>
                                            <span>Ditambahkan {{ \Carbon\Carbon::parse($resource['created'])->format('d M Y') }}</span>
                            </div>
                        @endif
                </div>
            </div>
            <div>
                <a href="{{ route('frontend.show', $package['id']) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dataset
                </a>
            </div>
    </div>
    @if($resource['description'])
        <p class="text-muted mb-0 mt-3">{{ $resource['description'] }}</p>
    @endif
    </header>

    @if (!$hasDataStore)
        <!-- DataStore Not Available -->
        <div class="table-container">
            <div class="empty-state">
                <i class="fas fa-database"></i>
                <h5>DataStore Tidak Tersedia</h5>
                <p class="mb-3">Resource ini belum diproses oleh DataStore. Preview tabel dan grafik hanya tersedia untuk
                    file CSV, XLSX, atau format tabular lainnya yang sudah di-load ke DataStore.</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <strong>Admin:</strong> Jalankan perintah berikut untuk memproses
                    file ini:
                    <code
                        class="d-block mt-2 bg-light p-2 rounded">ckan -c production.ini xloader submit {{ $resource['id'] }}</code>
                </div>
                <a href="{{ $resource['url'] ?? '#' }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Unduh File Langsung
                </a>
            </div>
        </div>
    @else
        <!-- Data Table Container -->
        <div class="table-container position-relative" id="tableContainer">
            <!-- Loading Overlay dengan Progress -->
            <div class="loading-overlay" id="loadingOverlay" style="display: none;">
                <div class="loading-spinner">
                    <div class="loading-progress">
                        <div class="loading-progress-bar"></div>
                    </div>
                    <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
                    <p class="mt-2 mb-1 text-muted">Memuat data...</p>
                    <small class="loading-timer" id="loadingTimer">0s</small>
                </div>
            </div>

            <div class="table-controls">
                <div class="table-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="tableSearch" class="form-control form-control-sm" placeholder="Cari dalam tabel...">
                </div>
                <div class="table-actions">
                    <select id="recordsPerPage" class="form-select form-select-sm" style="width: auto;">
                        <option value="10">10 / halaman</option>
                        <option value="25" selected>25 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                    </select>
                    <div class="dropdown export-dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#" onclick="exportData('csv'); return false;"><i
                                        class="fas fa-file-csv"></i> Export sebagai CSV</a></li>
                            <li><a class="dropdown-item" href="#" onclick="exportData('json'); return false;"><i
                                        class="fas fa-file-code"></i> Export sebagai JSON</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ $resource['url'] ?? '#' }}" target="_blank"><i
                                        class="fas fa-file-download"></i> Unduh File Asli</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" onclick="loadData()" title="Refresh data"><i
                            class="fas fa-sync-alt"></i></button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-hover data-table" style="width: 100%;">
                    <thead><!-- Headers will be populated by JS --></thead>
                    <tbody><!-- Data will be populated by JS --></tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 text-muted small" id="paginationInfo">
                <span>Memuat data...</span><span></span>
            </div>
        </div>

        <!-- Chart/Graph Section -->
        <div class="chart-section">
            <div class="chart-header">
                <h6><i class="fas fa-chart-bar"></i> Visualisasi Data</h6>
                <div class="chart-actions">
                    <select id="chartType" class="form-select form-select-sm" style="width: auto;" onchange="renderChart()">
                        <option value="bar">📊 Bar Chart</option>
                        <option value="line">📈 Line Chart</option>
                        <option value="pie">🥧 Pie Chart</option>
                        <option value="doughnut">🍩 Doughnut Chart</option>
                        <option value="radar">🎯 Radar Chart</option>
                    </select>
                    <button class="btn btn-outline-primary btn-sm" onclick="loadChartData()"><i class="fas fa-sync-alt"></i>
                        Refresh</button>
                </div>
            </div>

            <div class="chart-controls">
                <div>
                    <label class="form-label">Kolom X (Label)</label>
                    <select id="chartXColumn" class="form-select form-select-sm" onchange="renderChart()">
                        <option value="">Pilih kolom...</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Kolom Y (Value)</label>
                    <select id="chartYColumn" class="form-select form-select-sm" onchange="renderChart()">
                        <option value="">Pilih kolom...</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Limit Data</label>
                    <select id="chartLimit" class="form-select form-select-sm" onchange="renderChart()">
                        <option value="10">10 data</option>
                        <option value="25" selected>25 data</option>
                        <option value="50">50 data</option>
                        <option value="100">100 data</option>
                        <option value="all">Semua Data</option>
                    </select>
                </div>
            </div>

            <div class="chart-container">
                <canvas id="dataChart"></canvas>
                <div class="chart-loading" id="chartLoading" style="display: none;">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>

            <div class="chart-tip">
                <i class="fas fa-lightbulb"></i> <strong>Tip:</strong> Pilih kolom numerik untuk sumbu Y (nilai) dan kolom
                teks/tanggal untuk sumbu X (label) agar grafik lebih bermakna.
            </div>
        </div>

        <!-- Data Info Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Data</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Total Records</small>
                        <strong id="totalRecords">-</strong>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Total Columns</small>
                        <strong id="totalColumns">-</strong>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">DataStore Active</small>
                        <strong><span class="badge bg-success">Yes</span></strong>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection

@push('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        // ===== GLOBAL VARIABLES =====
        let dataTable;
        let currentData = [];
        let currentFields = [];
        let chartData = [];
        let chartInstance = null;
        let resourceId = '{{ $resource["id"] }}';
        let datasetId = '{{ $package["id"] }}';
        let apiEndpoint = '{{ route("ckan.resource.api", ["datasetId" => ":datasetId", "resourceId" => ":resourceId"]) }}'.replace(':datasetId', datasetId).replace(':resourceId', resourceId);
        let ckanApiUrl = '{{ config("ckan.api_url") }}';
        let apiKey = '{{ config("ckan.api_key") }}';

        // ✅ Client-side cache for API responses
        const apiCache = new Map();
        const CACHE_TTL = 30000; // 30 seconds

        // ✅ Helper: Fetch with cache
        async function fetchWithCache(key, fetchFn) {
            const cached = apiCache.get(key);
            if (cached && Date.now() - cached.timestamp < CACHE_TTL) {
                console.log('📦 Cache hit:', key);
                return cached.data;
            }
            console.log('🔄 Cache miss, fetching:', key);
            const data = await fetchFn();
            apiCache.set(key, { data: data, timestamp: Date.now() });
            // Clean old cache (keep last 5)
            if (apiCache.size > 5) {
                const oldestKey = apiCache.keys().next().value;
                apiCache.delete(oldestKey);
            }
            return data;
        }

        // ✅ Debounce for chart render
        let chartRenderTimeout;

        document.addEventListener('DOMContentLoaded', function () {
            @if($hasDataStore)
                loadData();
                // Chart will load after table data is ready (reuse data)

                document.getElementById('recordsPerPage').addEventListener('change', loadData);
                document.getElementById('tableSearch').addEventListener('input', (e) => debounceLoadData(e.target.value, 300));
            @endif
                                                                                    });

        // ===== TABLE FUNCTIONS =====
        let searchTimeout;

        function debounceLoadData(searchTerm, delay) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => loadData(1, searchTerm), delay);
        }

        async function loadData(page = 1, search = '') {
            const overlay = document.getElementById('loadingOverlay');
            const timerEl = document.getElementById('loadingTimer');
            let loadStartTime = Date.now();
            let timerInterval;

            // Show loading with timer
            overlay.style.display = 'flex';
            timerInterval = setInterval(() => {
                if (timerEl) {
                    const seconds = Math.floor((Date.now() - loadStartTime) / 1000);
                    timerEl.textContent = `${seconds}s`;
                }
            }, 1000);

            // ✅ Timeout controller
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 15000); // 15 seconds

            try {
                const limit = parseInt(document.getElementById('recordsPerPage').value);

                // ✅ Use cached fetch
                const cacheKey = `table_${resourceId}_${page}_${limit}_${search}`;
                const result = await fetchWithCache(cacheKey, async () => {
                    const url = new URL(apiEndpoint);
                    url.searchParams.set('page', page);
                    url.searchParams.set('limit', limit);
                    if (search) url.searchParams.set('search', search);

                    const response = await fetch(url.toString(), { signal: controller.signal });
                    clearTimeout(timeoutId);
                    return response.json();
                });

                if (!result.success) throw new Error(result.error || 'Failed to load data');

                currentData = result.data;
                currentFields = result.fields;

                document.getElementById('totalRecords').textContent = result.pagination.total.toLocaleString();
                document.getElementById('totalColumns').textContent = currentFields.length;

                renderTable(result);
                updatePaginationInfo(result.pagination);

                // ✅ Load chart AFTER table data (reuse same data)
                if (typeof loadChartData === 'function') {
                    loadChartData();
                }

            } catch (error) {
                if (error.name === 'AbortError') {
                    showErrorMessage('Request timeout. Server terlalu lambat merespon.');
                } else {
                    console.error('Error loading table ', error);
                    showErrorMessage(error.message);
                }
            } finally {
                clearTimeout(timeoutId);
                clearInterval(timerInterval);
                overlay.style.display = 'none';
            }
        }

        function renderTable(result) {
            const table = document.getElementById('dataTable');

            // Destroy existing instance
            if (dataTable) {
                dataTable.destroy();
            }

            // Build columns
            const columns = currentFields.map(field => ({
                data: field.id,
                title: field.label || field.id,
                responsivePriority: 1,
                render: function (data, type, row) {
                    if (data === null || data === undefined) return '<span class="text-muted">-</span>';
                    if (type === 'display' && typeof data === 'string' && data.length > 100) {
                        return `<span title="${escapeHtml(data)}">${escapeHtml(data.substring(0, 100))}...</span>`;
                    }
                    return escapeHtml(data);
                }
            }));

            // Initialize DataTable
            dataTable = $(table).DataTable({
                data: result.data,
                columns: columns,
                paging: false,
                searching: false,
                ordering: true,
                responsive: true,
                language: {
                    emptyTable: "Tidak ada data tersedia",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                }
            });
        }

        function updatePaginationInfo(pagination) {
            const infoEl = document.getElementById('paginationInfo');
            const from = (pagination.page - 1) * pagination.limit + 1;
            const to = Math.min(pagination.page * pagination.limit, pagination.total);

            infoEl.innerHTML = `
                                                                                            <span>Menampilkan ${from.toLocaleString()} - ${to.toLocaleString()} dari ${pagination.total.toLocaleString()} records</span>
                                                                                            <span>
                                                                                                ${pagination.page > 1 ? `<button class="btn btn-sm btn-outline-secondary me-1" onclick="loadData(${pagination.page - 1})">← Prev</button>` : '<button class="btn btn-sm btn-outline-secondary me-1" disabled>← Prev</button>'}
                                                                                                Page ${pagination.page} of ${pagination.total_pages}
                                                                                                ${pagination.page < pagination.total_pages ? `<button class="btn btn-sm btn-outline-secondary ms-1" onclick="loadData(${pagination.page + 1})">Next →</button>` : '<button class="btn btn-sm btn-outline-secondary ms-1" disabled>Next →</button>'}
                                                                                            </span>
                                                                                        `;
        }

        function showErrorMessage(message) {
            document.getElementById('dataTable').innerHTML = `
                                                                                            <tbody><tr><td colspan="100%" class="text-center py-5 text-danger">
                                                                                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                                                                                <p class="mb-0"><strong>Error:</strong> ${escapeHtml(message)}</p>
                                                                                                <small class="text-muted">Coba refresh atau periksa koneksi Anda</small>
                                                                                                <div class="mt-3"><button class="btn btn-outline-primary btn-sm" onclick="loadData()"><i class="fas fa-sync-alt"></i> Coba Lagi</button></div>
                                                                                            </td></tr></tbody>
                                                                                        `;
        }

        function exportData(format) {
            const limit = 1000;
            fetch(`${apiEndpoint}?limit=${limit}&format=${format}`)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `data-${resourceId}.${format}`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                })
                .catch(error => {
                    console.error('Export error:', error);
                    alert('Gagal export  ' + error.message);
                });
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        // ===== CHART FUNCTIONS =====
        async function loadChartData() {
            const chartLoading = document.getElementById('chartLoading');

            // ✅ FIX: Reuse table data if already loaded (no double fetch!)
            if (currentData && currentData.length > 0) {
                console.log('♻️ Reusing table data for chart - no extra API call!');
                chartData = currentData;
                populateChartSelectors();
                autoSelectChartColumns();
                renderChart();
                return;
            }

            // Only fetch if table data not available yet
            chartLoading.style.display = 'flex';

            try {
                // ✅ Use smaller limit for chart (faster)
                const response = await fetch(`${ckanApiUrl}/api/3/action/datastore_search`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': apiKey,
                    },
                    body: JSON.stringify({
                        resource_id: resourceId,
                        limit: 50,  // ✅ Smaller limit for chart
                        include_total: false,
                    }),
                });

                const result = await response.json();

                if (!result.success) throw new Error(result.error?.message || 'Failed to load chart data');

                chartData = result.result?.records || [];
                currentFields = result.result?.fields || [];

                populateChartSelectors();
                autoSelectChartColumns();
                renderChart();

            } catch (error) {
                console.error('Chart data load error:', error);
                showChartError(error.message);
            } finally {
                chartLoading.style.display = 'none';
            }
        }

        function populateChartSelectors() {
            const xSelect = document.getElementById('chartXColumn');
            const ySelect = document.getElementById('chartYColumn');

            if (!xSelect || !ySelect) return;

            xSelect.innerHTML = '<option value="">Pilih kolom...</option>';
            ySelect.innerHTML = '<option value="">Pilih kolom...</option>';

            currentFields.forEach(field => {
                const fieldName = field.id;
                const fieldType = field.type || 'text';

                const option = document.createElement('option');
                option.value = fieldName;
                option.textContent = `${fieldName} (${fieldType})`;
                xSelect.appendChild(option.cloneNode(true));
                ySelect.appendChild(option);
            });
        }

        function autoSelectChartColumns() {
            const xSelect = document.getElementById('chartXColumn');
            const ySelect = document.getElementById('chartYColumn');

            if (!xSelect || !ySelect || currentFields.length === 0) return;

            const numericFields = currentFields.filter(f =>
                ['int', 'integer', 'float', 'numeric', 'number'].includes(f.type?.toLowerCase())
            );
            const textFields = currentFields.filter(f =>
                ['text', 'string', 'date', 'timestamp'].includes(f.type?.toLowerCase())
            );

            if (numericFields.length > 0) ySelect.value = numericFields[0].id;
            if (textFields.length > 0) xSelect.value = textFields[0].id;
            else if (currentFields.length > 0) xSelect.value = currentFields[0].id;
        }

        // ✅ Debounced chart render
        function renderChart() {
            if (chartRenderTimeout) clearTimeout(chartRenderTimeout);
            chartRenderTimeout = setTimeout(() => _renderChart(), 100);
        }

        function _renderChart() {
            const canvas = document.getElementById('dataChart');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const chartType = document.getElementById('chartType')?.value || 'bar';
            const xColumn = document.getElementById('chartXColumn')?.value;
            const yColumn = document.getElementById('chartYColumn')?.value;
            const limitValue = document.getElementById('chartLimit')?.value || '25';
            const limit = limitValue === 'all' ? chartData.length : parseInt(limitValue);

            if (!xColumn || !yColumn || chartData.length === 0) {
                showChartError('Pilih kolom X dan Y untuk menampilkan grafik');
                return;
            }

            const slicedData = chartData.slice(0, limit);
            const labels = slicedData.map(row => row[xColumn] ?? 'N/A');
            const data = slicedData.map(row => {
                const value = row[yColumn];
                return typeof value === 'number' ? value : parseFloat(value) || 0;
            });

            if (chartInstance) chartInstance.destroy();

            // ✅ FIX: Different tooltip callback for different chart types
            const isPieOrDoughnut = chartType === 'pie' || chartType === 'doughnut';
            const isRadar = chartType === 'radar';

            chartInstance = new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: yColumn,
                        data,
                        backgroundColor: getChartColors(chartType, data.length),
                        borderColor: getChartBorderColor(chartType),
                        borderWidth: 2,
                        fill: chartType === 'line',
                        tension: chartType === 'line' ? 0.4 : 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: isPieOrDoughnut,
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                // ✅ FIX: Different label callback for different chart types
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) label += ': ';

                                    // ✅ Pie/Doughnut: use context.parsed (not .y)
                                    if (isPieOrDoughnut) {
                                        const value = context.parsed ?? context.raw ?? 0;
                                        label += new Intl.NumberFormat('id-ID').format(value);
                                    }
                                    // ✅ Radar: use context.parsed.r
                                    else if (isRadar) {
                                        const value = context.parsed?.r ?? context.raw ?? 0;
                                        label += new Intl.NumberFormat('id-ID').format(value);
                                    }
                                    // ✅ Bar/Line: use context.parsed.y
                                    else {
                                        const value = context.parsed?.y ?? context.raw ?? 0;
                                        label += new Intl.NumberFormat('id-ID').format(value);
                                    }

                                    return label;
                                }
                            }
                        }
                    },
                    scales: isPieOrDoughnut || isRadar ? {} : {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                autoSkip: true,
                                maxTicksLimit: 20,
                            }
                        }
                    }
                }
            });
        }

        function getChartColors(type, count) {
            const colors = {
                bar: ['rgba(13, 110, 253, 0.7)', 'rgba(25, 135, 84, 0.7)', 'rgba(255, 193, 7, 0.7)', 'rgba(220, 53, 69, 0.7)', 'rgba(108, 117, 125, 0.7)'],
                pie: ['rgba(13, 110, 253, 0.8)', 'rgba(25, 135, 84, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(220, 53, 69, 0.8)', 'rgba(108, 117, 125, 0.8)', 'rgba(13, 202, 240, 0.8)', 'rgba(253, 126, 20, 0.8)'],
                line: 'rgba(13, 110, 253, 0.2)',
                doughnut: ['rgba(13, 110, 253, 0.8)', 'rgba(25, 135, 84, 0.8)', 'rgba(255, 193, 7, 0.8)', 'rgba(220, 53, 69, 0.8)'],
                radar: 'rgba(13, 110, 253, 0.2)',
            };
            if (type === 'pie' || type === 'doughnut') return colors[type];
            if (type === 'bar') return Array(count).fill(0).map((_, i) => colors.bar[i % colors.bar.length]);
            return colors[type];
        }

        function getChartBorderColor(type) {
            const colors = {
                bar: 'rgba(13, 110, 253, 1)',
                line: 'rgba(13, 110, 253, 1)',
                pie: '#fff',
                doughnut: '#fff',
                radar: 'rgba(13, 110, 253, 1)',
            };
            return colors[type] || 'rgba(13, 110, 253, 1)';
        }

        function showChartError(message) {
            const container = document.querySelector('.chart-container');
            if (container) {
                container.innerHTML = `
                                                                                                <div class="chart-error">
                                                                                                    <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                                                                                    <p class="mb-0">${message}</p>
                                                                                                    <button class="btn btn-outline-primary btn-sm mt-3" onclick="loadChartData()"><i class="fas fa-sync-alt"></i> Coba Lagi</button>
                                                                                                </div>
                                                                                            `;
            }
        }

        // Copy cell value on click
        document.addEventListener('click', function (e) {
            if (e.target.closest('#dataTable tbody td')) {
                const cell = e.target.closest('td');
                const text = cell.textContent.trim();
                if (text && text !== '-') {
                    navigator.clipboard.writeText(text).then(() => {
                        cell.style.backgroundColor = '#d1e7dd';
                        setTimeout(() => { cell.style.backgroundColor = ''; }, 300);
                    });
                }
            }
        });
    </script>
@endpush