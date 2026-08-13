@push('styles')
    <style>
        /* ===== HERO SECTION ===== */
        .hero-section {
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

            padding: 3rem 0;
            color: white;
            min-height: 500px;
            max-height: 500px;
            display: flex;
            align-items: center;
        }

        .hero-section .row {
            height: 100%;
        }

        .hero-section .col-md-6:last-child {
            position: relative;
        }

        .hero-image {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 460px;
            width: auto;
            max-height: none;
        }

        .hero-image-animate {
            opacity: 0;
            transform: translateY(-50%) translateX(40px);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .hero-image-animate.show {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .hero-title.show .hero-line {
            animation: heroPulse 3.2s ease-in-out infinite;
            transform-origin: left center;
        }

        .hero-title.show .hero-line:nth-child(2) {
            animation-delay: .35s;
        }

        @keyframes heroPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.03);
                opacity: .96;
            }
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }

        /* ===== SEARCH BOX ===== */
        .hero-search {
            background: white;
            border-radius: 16px;
            padding: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0;
            position: relative;
            z-index: 9999;
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
            background: linear-gradient(135deg, #1E3A8A, #2563EB);
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
            z-index: 9999;
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

        /* ===== VIDEO SECTION ===== */
        .video-section {
            padding: 4rem 0;
        }

        .video-header {
            margin-bottom: 1rem;
        }

        .video-header::after {
            content: "";
            display: block;
            width: 120px;
            height: 3px;
            margin: .9rem auto 0;
            border-radius: 999px;
            background:
                linear-gradient(90deg,
                    transparent 0%,
                    #1E3A8A 15%,
                    #3B82F6 50%,
                    #1E3A8A 85%,
                    transparent 100%);
        }

        .video-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2.5rem;
        }

        .video-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .video-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            cursor: pointer;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .video-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12)
        }

        .video-card .ratio {
            overflow: hidden;
        }

        .video-card iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .video-content {
            padding: 1.1rem 1.25rem 1.3rem;
        }

        .video-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.5;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: .3s;
        }

        .video-card:hover .video-title {
            color: #1E40AF;
        }

        .video-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: .85rem;
            border-top: 1px solid #edf2f7;
        }

        .video-tag {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: #2563EB;
            font-size: .85rem;
            font-weight: 600;
        }

        .video-source {
            color: #94a3b8;
            font-size: .85rem;
        }

        /* ===== VIDEO CAROUSEL ===== */
        #videoCarousel {
            position: relative;
            padding: 0 3.75rem;
        }

        #videoCarousel .carousel-item {
            padding: 10px 0 24px;
        }

        /* ===== Navigation ===== */
        .carousel-control-prev,
        .carousel-control-next {
            width: 56px;
            height: 56px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 0;
            box-shadow: none;
            opacity: 1;
            transition: all .25s ease;
            z-index: 20;
        }

        .carousel-control-prev {
            left: -42px;
        }

        .carousel-control-next {
            right: -42px;
        }

        .carousel-control-prev i,
        .carousel-control-next i {
            font-size: 34px;
            color: #2563EB;
            transition: all .25s ease;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            transform: translateY(-50%);
        }

        .carousel-control-prev:hover i,
        .carousel-control-next:hover i {
            color: #1D4ED8;
            transform: scale(1.03);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
            background-size: contain;
        }

        /* ===== CUSTOM INDICATOR ===== */
        .custom-indicators {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 1.8rem;
        }

        .custom-indicators button {
            position: relative;
            width: 42px;
            height: 14px;
            padding: 0;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: .3s ease;
        }

        .custom-indicators button::before {
            content: "";
            position: absolute;
            inset: 0;
            border: 2px solid #2F73D9;
            border-radius: 999px;
            transition: .3s ease;
        }

        .custom-indicators button::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 0;
            height: 0;
            background: #2F73D9;
            border-radius: 999px;
            transform: translate(-50%, -50%);
            transition: .3s ease;
        }

        .custom-indicators button.active::after {
            width: 26px;
            height: 5px;
        }

        .custom-indicators button:hover::before {
            border-color: #1F5CC6;
        }

        .custom-indicators button:hover::after {
            background: #1F5CC6;
        }

        .custom-indicators button:focus {
            outline: none;
            box-shadow: none;
        }

        /* ===== INFOGRAFIS SECTION ===== */
        .infografis-section {
            position: relative;
            padding: 4rem 0;
        }

        .infografis-header {
            margin-bottom: 1.6rem;
        }

        .infografis-header::after {
            content: "";
            display: block;
            width: 120px;
            height: 2.6px;
            margin: .9rem auto 0;
            border-radius: 999px;
            background:
                linear-gradient(90deg,
                    transparent 0%,
                    #1E3A8A 15%,
                    #3B82F6 50%,
                    #1E3A8A 85%,
                    transparent 100%);
        }

        .infografis-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2.5rem;
        }

        .infografis-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .infografis-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            cursor: pointer;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .infografis-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .infografis-media {
            overflow: hidden;
            flex-shrink: 0;
        }

        .infografis-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .infografis-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 1.25rem;
        }

        .infografis-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.5;
            min-height: 3.2rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: .8rem;
        }

        .infografis-card:hover .infografis-title {
            color: #1E40AF;
        }

        .infografis-desc {
            color: #64748b;
            font-size: .93rem;
            line-height: 1.7;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        @media(max-width:768px) {

            .infografis-section {
                padding: 3rem 0;
            }

            .infografis-img {
                height: 190px;
            }

        }

        .infografis-footer {
            margin-top: 1.2rem;
            padding-top: 1rem;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #2563EB;
            font-size: .85rem;
            font-weight: 600;
        }

        /* ===== GLOBAL ANIMATION ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-1 {
            transition-delay: 0.1s;
        }

        .delay-2 {
            transition-delay: 0.2s;
        }

        .delay-3 {
            transition-delay: 0.3s;
        }

        .delay-4 {
            transition-delay: 0.4s;
        }

        .delay-5 {
            transition-delay: 0.5s;
        }
    </style>
@endpush

@extends('layouts.app')

@section('title', 'Portal Data CKAN')

@section('content')

    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <h1 class="hero-title fade-up hero-auto">
                        <span class="d-block hero-line">SATU DATA KABUPATEN</span>
                        <span class="d-block hero-line">MURUNG RAYA</span>
                    </h1>
                    <p class="hero-description fade-up delay-1 hero-auto">
                        Silahkan ketik data yang ingin anda cari di dalam kotak pencarian
                    </p>
                    <div class="hero-search position-relative fade-up delay-2 hero-auto">
                        <form action="{{ route('frontend.datasets') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control search-input" id="heroSearchInput"
                                    placeholder="Cari dataset, topik, atau instansi..." autocomplete="off">

                                <button type="submit" class="btn btn-search">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </form>
                        <div class="autocomplete-dropdown" id="autocompleteDropdown" style="display: none;">
                            <div class="autocomplete-header">
                                <i class="fas fa-history"></i> Saran Pencarian
                            </div>

                            <div class="autocomplete-results" id="autocompleteResults"></div>

                            <div class="autocomplete-footer">
                                <a href="{{ route('frontend.datasets') }}" class="view-all-link">
                                    <i class="fas fa-th"></i> Lihat Semua Dataset
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/data.png') }}" alt="Hero Image"
                        class="img-fluid hero-image hero-image-animate hero-auto">
                </div>
            </div>
        </div>
    </div>

    <!-- ===== VIDEO SECTION ===== -->
    <div class="video-section">
        <div class="container">
            <div class="video-header text-center fade-up">
                <h2>Video Satu Data Murung Raya</h2>
            </div>
            <div id="videoCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($videos->chunk(3) as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach ($chunk as $item)
                                    <div class="col-lg-4 col-md-6">
                                        <a href="https://www.youtube.com/watch?v={{ $item->video }}" target="_blank"
                                            class="video-card-link">
                                            <div class="video-card fade-up">
                                                <div class="ratio ratio-16x9">
                                                    <iframe src="https://www.youtube.com/embed/{{ $item->video }}" allowfullscreen>
                                                    </iframe>
                                                </div>

                                                <div class="video-content">
                                                    <h5 class="video-title">
                                                        {{ $item->judul }}
                                                    </h5>

                                                    <div class="video-meta">
                                                        <span class="video-tag">
                                                            <i class="fa-solid fa-circle-play"></i>
                                                            Video
                                                        </span>

                                                        <span class="video-source">
                                                            YouTube
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="custom-indicators">
                    @foreach ($videos->chunk(3) as $key => $chunk)
                        <button type="button" data-bs-target="#videoCarousel" data-bs-slide-to="{{ $key }}"
                            class="{{ $key == 0 ? 'active' : '' }}">
                        </button>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#videoCarousel" data-bs-slide="prev">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#videoCarousel" data-bs-slide="next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- ===== INFOGRAFIS SECTION ===== -->
    <div class="infografis-section">
        <div class="container">
            <div class="infografis-header text-center fade-up">
                <h2>Infografis Satu Data Murung Raya</h2>
            </div>
            <div class="row g-4">
                @forelse ($infografis as $key => $item)
                    <div class="col-lg-3 col-md-6 fade-up delay-{{ $key + 1 }}">
                        <a href="{{ route('infografis.show', $item->id) }}" class="infografis-link">
                            <div class="infografis-card">
                                <div class="infografis-media">
                                    <img src="{{ $item->foto ? asset('storage/grafik/' . $item->foto) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                                        class="infografis-img" alt="{{ $item->judul }}">
                                </div>
                                <div class="infografis-body">
                                    <h5 class="infografis-title">
                                        {{ $item->judul }}
                                    </h5>
                                    <p class="infografis-desc">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 120, '...') }}
                                    </p>
                                    <div class="infografis-footer">
                                        <span>
                                            <i class="fa-regular fa-image"></i>
                                            Infografis
                                        </span>

                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fa-regular fa-folder-open fa-3x text-secondary mb-3"></i>
                            <h5>Belum Ada Infografis</h5>
                            <p class="text-muted mb-0">
                                Data infografis akan ditampilkan di sini ketika sudah tersedia.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>
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
                                                                                                                            <a href="{{ route('frontend.datasets') }}?q=${encodeURIComponent(item.title)}" 
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
                    maxSuggestions: 3, // ✅ Only show 3 suggestions
                });
            }
        });

        // ===== SCROLL ANIMATION =====
        document.addEventListener("DOMContentLoaded", function () {

            // ===== Indikator video =====
            const carousel = document.getElementById("videoCarousel");
            const indicators = document.querySelectorAll(".custom-indicators button");

            function setActive(index) {

                indicators.forEach((btn, i) => {

                    btn.classList.toggle("active", i === index);

                });

            }

            setActive(0);

            carousel.addEventListener("slid.bs.carousel", function (e) {

                setActive(e.to);

            });

            indicators.forEach((btn, index) => {

                btn.addEventListener("click", () => {

                    setActive(index);

                });

            });

            // ===== HERO: langsung tampil TANPA observer =====
            const heroElements = document.querySelectorAll(".hero-auto");
            heroElements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add("show");
                }, index * 150); // biar ada delay halus
            });

            // ===== NON-HERO: hanya muncul saat scroll =====
            const scrollElements = document.querySelectorAll(
                ".fade-up:not(.hero-auto), .hero-image-animate:not(.hero-auto)"
            );

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("show");
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: "0px 0px -100px 0px"
            });

            scrollElements.forEach(el => observer.observe(el));
        });
    </script>
@endpush