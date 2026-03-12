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

        /* ===== DATA TABLE CONTAINER ===== */
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .table-controls {
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

        .table-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* ===== DATATABLES OVERRIDES ===== */
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

        /* ===== TABLE STYLES ===== */
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

        /* ===== LOADING STATE ===== */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 8px;
        }

        .loading-spinner {
            text-align: center;
        }

        .loading-spinner .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-color);
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

        /* ===== EXPORT BUTTONS ===== */
        .export-dropdown .dropdown-menu {
            min-width: 200px;
        }

        .export-dropdown .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .table-controls {
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
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('ckan.index') }}"><i class="fas fa-home"></i> Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ckan.datasets') }}">Dataset</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ckan.show', $package['id']) }}">
                        {{ Str::limit($package['title'], 40) }}
                    </a>
                </li>
                <li class="breadcrumb-item active">Preview Data</li>
            </ol>
        </nav>

        <!-- Header -->
        <header class="preview-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h1 class="preview-title">
                        <i class="fas fa-table"></i> Preview: {{ $resource['name'] ?? 'Resource' }}
                    </h1>
                    <div class="preview-meta">
                        <div class="preview-meta-item">
                            <i class="fas fa-file"></i>
                            <span class="badge-format">{{ strtoupper($resource['format'] ?? 'UNKNOWN') }}</span>
                        </div>
                        @if($resource['size'])
                            <div class="preview-meta-item">
                                <i class="fas fa-hdd"></i>
                                <span>{{ number_format($resource['size'] / 1024 / 1024, 2) }} MB</span>
                            </div>
                        @endif
                        @if($resource['created'])
                            <div class="preview-meta-item">
                                <i class="fas fa-clock"></i>
                                <span>Ditambahkan {{ \Carbon\Carbon::parse($resource['created'])->format('d M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    <a href="{{ route('ckan.show', $package['id']) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dataset
                    </a>
                </div>
            </div>

            @if($resource['description'])
                <p class="text-muted mb-0 mt-3">{{ $resource['description'] }}</p>
            @endif
        </header>

        @if(!$hasDataStore)
            <!-- DataStore Not Available -->
            <div class="table-container">
                <div class="empty-state">
                    <i class="fas fa-database"></i>
                    <h5>DataStore Tidak Tersedia</h5>
                    <p class="mb-3">
                        Resource ini belum diproses oleh DataStore.
                        Preview tabel hanya tersedia untuk file CSV, XLSX, atau format tabular lainnya yang sudah di-load ke
                        DataStore.
                    </p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Admin:</strong> Jalankan perintah berikut untuk memproses file ini:
                        <code class="d-block mt-2 bg-light p-2 rounded">
                                                                                                            ckan -c production.ini xloader submit {{ $resource['id'] }}
                                                                                                        </code>
                    </div>
                    <a href="{{ $resource['url'] ?? '#' }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Unduh File Langsung
                    </a>
                </div>
            </div>
        @else
            <!-- Data Table Container -->
            <div class="table-container position-relative" id="tableContainer">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="loading-spinner">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0 text-muted">Memuat data...</p>
                    </div>
                </div>

                <!-- Table Controls -->
                <div class="table-controls">
                    <!-- Search -->
                    <div class="table-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="tableSearch" class="form-control form-control-sm"
                            placeholder="Cari dalam tabel...">
                    </div>

                    <!-- Actions -->
                    <div class="table-actions">
                        <!-- Records per page -->
                        <select id="recordsPerPage" class="form-select form-select-sm" style="width: auto;">
                            <option value="10">10 / halaman</option>
                            <option value="25" selected>25 / halaman</option>
                            <option value="50">50 / halaman</option>
                            <option value="100">100 / halaman</option>
                        </select>

                        <!-- Export Dropdown -->
                        <div class="dropdown export-dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportData('csv'); return false;">
                                        <i class="fas fa-file-csv"></i> Export sebagai CSV
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportData('json'); return false;">
                                        <i class="fas fa-file-code"></i> Export sebagai JSON
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ $resource['url'] ?? '#' }}" target="_blank">
                                        <i class="fas fa-file-download"></i> Unduh File Asli
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Refresh -->
                        <button class="btn btn-outline-secondary btn-sm" onclick="loadData()" title="Refresh data">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover data-table" style="width: 100%;">
                        <thead>
                            <!-- Headers will be populated by JS -->
                        </thead>
                        <tbody>
                            <!-- Data will be populated by JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="d-flex justify-content-between align-items-center mt-3 text-muted small" id="paginationInfo">
                    <span>Memuat data...</span>
                    <span></span>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        // Global variables
        let dataTable;
        let currentData = [];
        let currentFields = [];
        let resourceId = '{{ $resource["id"] }}';
        let datasetId = '{{ $package["id"] }}';
        let apiEndpoint = '{{ route("ckan.resource.api", ["datasetId" => ":datasetId", "resourceId" => ":resourceId"]) }}'.replace(':datasetId', datasetId).replace(':resourceId', resourceId);

        document.addEventListener('DOMContentLoaded', function () {
            @if($hasDataStore)
                // Initialize
                loadData();

                // Event listeners
                document.getElementById('recordsPerPage').addEventListener('change', function () {
                    loadData();
                });

                document.getElementById('tableSearch').addEventListener('input', function (e) {
                    debounceLoadData(e.target.value, 300);
                });
            @endif
                                            });

        // Debounced search
        let searchTimeout;
        function debounceLoadData(searchTerm, delay) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                loadData(1, searchTerm);
            }, delay);
        }

        // Load data from API
        async function loadData(page = 1, search = '') {
            const container = document.getElementById('tableContainer');
            const overlay = document.getElementById('loadingOverlay');
            const table = document.getElementById('dataTable');

            // Show loading
            overlay.style.display = 'flex';

            try {
                const limit = parseInt(document.getElementById('recordsPerPage').value);

                // Build URL
                const url = new URL(apiEndpoint);
                url.searchParams.set('page', page);
                url.searchParams.set('limit', limit);
                if (search) url.searchParams.set('search', search);

                // Fetch data
                const response = await fetch(url.toString());
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Failed to load data');
                }

                // Store data
                currentData = result.data;
                currentFields = result.fields;

                // Update info
                document.getElementById('totalRecords').textContent = result.pagination.total.toLocaleString();
                document.getElementById('totalColumns').textContent = currentFields.length;

                // Render table
                renderTable(result);

                // Update pagination info
                updatePaginationInfo(result.pagination);

            } catch (error) {
                console.error('Error loading data:', error);
                showErrorMessage(error.message);
            } finally {
                // Hide loading
                overlay.style.display = 'none';
            }
        }

        // Render DataTable
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
                paging: false,  // We handle pagination manually
                searching: false,  // We handle search manually
                ordering: true,
                responsive: true,
                language: {
                    emptyTable: "Tidak ada data tersedia",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                },
                drawCallback: function (settings) {
                    // Add click handlers for sorting
                    $('.sorting').on('click', function () {
                        const colIdx = $(this).index();
                        const field = currentFields[colIdx];
                        if (field) {
                            // Reload with sort
                            const currentSort = new URL(apiEndpoint).searchParams.get('sort') || '';
                            const newSort = field.id + (currentSort.includes('desc') ? ' asc' : ' desc');
                            loadData(1, document.getElementById('tableSearch').value);
                        }
                    });
                }
            });
        }

        // Update pagination info display
        function updatePaginationInfo(pagination) {
            const infoEl = document.getElementById('paginationInfo');
            const from = (pagination.page - 1) * pagination.limit + 1;
            const to = Math.min(pagination.page * pagination.limit, pagination.total);

            infoEl.innerHTML = `
                                                    <span>Menampilkan ${from.toLocaleString()} - ${to.toLocaleString()} dari ${pagination.total.toLocaleString()} records</span>
                                                    <span>
                                                        ${pagination.page > 1 ?
                    `<button class="btn btn-sm btn-outline-secondary me-1" onclick="loadData(${pagination.page - 1})">← Prev</button>` :
                    '<button class="btn btn-sm btn-outline-secondary me-1" disabled>← Prev</button>'
                }
                                                        Page ${pagination.page} of ${pagination.total_pages}
                                                        ${pagination.page < pagination.total_pages ?
                    `<button class="btn btn-sm btn-outline-secondary ms-1" onclick="loadData(${pagination.page + 1})">Next →</button>` :
                    '<button class="btn btn-sm btn-outline-secondary ms-1" disabled>Next →</button>'
                }
                                                    </span>
                                                `;
        }

        // Show error message in table
        function showErrorMessage(message) {
            const table = document.getElementById('dataTable');
            table.innerHTML = `
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="100%" class="text-center py-5 text-danger">
                                                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                                                <p class="mb-0"><strong>Error:</strong> ${escapeHtml(message)}</p>
                                                                <small class="text-muted">Coba refresh atau periksa koneksi Anda</small>
                                                                <div class="mt-3">
                                                                    <button class="btn btn-outline-primary btn-sm" onclick="loadData()">
                                                                        <i class="fas fa-sync-alt"></i> Coba Lagi
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                `;
        }

        // Export data
        function exportData(format) {
            const limit = 1000;  // Max for export

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
                    alert('Gagal export data: ' + error.message);
                });
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        // Copy cell value on click (optional)
        document.addEventListener('click', function (e) {
            if (e.target.closest('#dataTable tbody td')) {
                const cell = e.target.closest('td');
                const text = cell.textContent.trim();
                if (text && text !== '-') {
                    navigator.clipboard.writeText(text).then(() => {
                        // Visual feedback
                        cell.style.backgroundColor = '#d1e7dd';
                        setTimeout(() => {
                            cell.style.backgroundColor = '';
                        }, 300);
                    });
                }
            }
        });
    </script>
@endpush