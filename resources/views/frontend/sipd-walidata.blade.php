@extends('layouts.app')

@section('title', 'SIPD Walidata')

@section('content')

    <header class="page-header">
        <div class="container">
            <h1 class="section-title text-white">
                <i class="fas fa-folder-open me-2"></i>
                Dokumen SIPD Walidata
            </h1>

            <p class="subtitle mb-0">
                Pusat dokumen dan pengelolaan data SIPD Walidata Kabupaten Murung Raya
            </p>
        </div>
    </header>

    <div class="container py-5">

        <div class="document-wrapper">

            {{-- Header --}}
            <div class="top-area">

                <div>
                    <h4 class="mb-1">
                        Daftar Dokumen
                    </h4>

                    <small class="text-muted">
                        Total {{ $dokumen->total() }} dokumen tersedia
                    </small>
                </div>

                {{-- Search --}}
                <form method="GET" action="{{ route('frontend.sipd-walidata') }}" class="search-box">
                    <i class="fas fa-search"></i>

                    <input type="text" name="search" placeholder="Cari nama terus tekan enter..."
                        value="{{ request('search') }}">
                </form>

            </div>

            {{-- Filter Keterangan --}}
            <div class="mb-3">
                <form method="GET" action="{{ route('frontend.sipd-walidata') }}">
                    <div class="row">

                        <div class="col-md-4">
                            <select name="keterangan" class="form-select" onchange="this.form.submit()">

                                <option value="">
                                    -- Semua Keterangan --
                                </option>

                                @foreach ($allKeterangan as $keterangan)
                                    <option value="{{ $keterangan }}"
                                        {{ request('keterangan') == $keterangan ? 'selected' : '' }}>
                                        {{ $keterangan }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </form>
            </div>

            <div class="table-responsive">

                <table class="table document-table align-middle">

                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Dokumen</th>
                            <th width="250">Keterangan</th>
                            <th width="150">Tanggal</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($dokumen as $key => $item)
                            <tr>

                                <td>
                                    {{ $dokumen->firstItem() + $key }}
                                </td>

                                <td>

                                    @php
                                        $ext = strtolower(pathinfo($item->file ?? '', PATHINFO_EXTENSION));
                                    @endphp

                                    <div class="doc-info">

                                        <div class="doc-icon">
                                            @if (in_array($ext, ['xls', 'xlsx', 'csv']))
                                                <i class="fas fa-file-excel text-success"></i>
                                            @else
                                                <i class="fas fa-file-pdf text-danger"></i>
                                            @endif
                                        </div>

                                        <div>
                                            <div class="doc-title">
                                                {{ $item->nama_dok }}
                                            </div>

                                            @if ($item->file)
                                                <small class="text-muted">
                                                    {{ strtoupper($ext) }}
                                                </small>
                                            @endif
                                        </div>

                                    </div>

                                </td>

                                <td>
                                    <div class="badge-category">
                                        {{ $item->keterangan }}
                                    </div>
                                </td>

                                <td>
                                    {{ $item->created_at->format('d M Y') }}
                                </td>

                                <td>

                                    @if ($item->file)
                                        <a href="{{ route('download.sipd-walidata', $item->id) }}" target="_blank"
                                            class="btn-download">

                                            <i class="fas fa-download"></i>
                                            Download

                                        </a>
                                    @else
                                        <span class="text-muted">
                                            Belum ada file
                                        </span>
                                    @endif

                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data dokumen
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $dokumen->links() }}
            </div>

        </div>

    </div>

    <style>
        .page-header {
            background:
                repeating-linear-gradient(120deg,
                    rgba(255, 255, 255, .06) 0px,
                    rgba(255, 255, 255, .06) 1px,
                    transparent 1px,
                    transparent 35px),

                repeating-linear-gradient(-120deg,
                    rgba(255, 255, 255, .04) 0px,
                    rgba(255, 255, 255, .04) 1px,
                    transparent 1px,
                    transparent 55px),

                linear-gradient(120deg,
                    transparent 0%,
                    rgba(255, 255, 255, .08) 30%,
                    transparent 60%),

                linear-gradient(135deg, #1E3A8A, #2563EB);

            color: white;
            padding: 2.5rem 0;
            overflow: hidden;
            opacity: 0;
        }

        @keyframes heroFade {

            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header.show {
            animation: heroFade .65s ease forwards;
        }

        .section-title {
            font-weight: 700;
        }

        .subtitle {
            opacity: .9;
        }

        .document-wrapper {
            background: #fff;
            border-radius: 24px;
            padding: 30px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow:
                0 1px 2px rgba(0, 0, 0, .04),
                0 10px 25px rgba(15, 23, 42, .08),
                0 30px 60px rgba(15, 23, 42, .08);
            position: relative;
            z-index: 10;
            opacity: 0;
            transform: translateY(24px);
        }

        .document-wrapper.show {
            animation: fadeUp .55s ease forwards;
        }

        .top-area {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 30px;
            gap: 20px;
        }

        .search-box {
            position: relative;
            width: 320px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 42px;

            border: 1px solid #E2E8F0;
            border-radius: 12px;

            background: white;
            transition: .3s;
        }

        .search-box input:focus {
            outline: none;

            border-color: #2563EB;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .1);
        }

        .document-table {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .document-table thead th {

            background: #F8FAFC;

            color: #64748B;

            font-size: .9rem;
            font-weight: 600;

            padding: 18px;

            border: none;

            position: sticky;
            top: 0;
            z-index: 1;
        }

        .document-table thead th:first-child {
            border-top-left-radius: 12px;
        }

        .document-table thead th:last-child {
            border-top-right-radius: 12px;
        }

        .document-table td {
            padding: 18px;
            border: none;
            vertical-align: middle;
        }

        .document-table tbody tr {
            border-bottom: 1px solid #EEF2F7;
            transition: .25s;
            opacity: 0;
            transform: translateY(18px);
        }

        .document-table tbody tr.show {
            animation: fadeUp .45s ease forwards;
        }

        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .document-table tbody tr:nth-child(even) {
            background: #FAFBFC;
        }

        .document-table tbody tr:hover {
            background: #F1F5F9;
        }

        .doc-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .doc-icon {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #FEE2E2;
            color: #DC2626;

            font-size: 20px;
        }

        .doc-title {
            font-weight: 600;
            color: #1E293B;
        }

        .badge-category {
            background: #DBEAFE;
            color: #1D4ED8;

            padding: 6px 14px;

            border-radius: 30px;

            font-size: .75rem;
        }

        .badge-status {
            background: #DCFCE7;
            color: #166534;

            padding: 6px 14px;

            border-radius: 30px;

            font-size: .75rem;
        }

        .btn-download {

            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 9px 15px;

            border-radius: 10px;

            background:
                linear-gradient(135deg,
                    #1E3A8A,
                    #2563EB);

            border: 1px solid rgba(255, 255, 255, .15);

            color: white;
            text-decoration: none;

            transition: .3s;
        }

        .btn-download:hover {

            transform: translateY(-2px);

            color: white;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .3);
        }

        @media(max-width:768px) {

            .top-area {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                width: 100%;
            }

        }
    </style>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelector('.page-header')?.classList.add('show');

                setTimeout(() => {
                    document.querySelector('.document-wrapper')?.classList.add('show');
                }, 120);

                document.querySelectorAll('.document-table tbody tr').forEach((row, index) => {
                    setTimeout(() => {
                        row.classList.add('show');
                    }, 250 + (index * 45));
                });

            });
        </script>
    @endpush
@endsection
