@extends('layouts.app')

@section('title', 'Infografis')

@section('content')
    <div class="grafs-hero">
        <div class="container text-center">
            <h1 class="section-title text-white">
                <i class="fa-solid fa-chart-simple"></i> Infografis
            </h1>
            <p class="grafs-subtitle">
                Visualisasi data untuk memahami informasi secara cepat dan akurat
            </p>
        </div>
    </div>
    <div class="container py-5">
        <div class="row g-5">

            <!-- CONTENT -->
            <div class="col-lg-8">
                <div class="infografis-content infografis-item">
                    <h1 class="infografis-title">
                        {{ $infografis->judul }}
                    </h1>
                    <div class="infografis-meta">
                        <span>
                            <i class="fa-solid fa-user"></i>
                            {{ $infografis->penulis }}
                        </span>
                        <span>
                            <i class="fa-solid fa-calendar-days"></i>
                            {{ $infografis->created_at->format('d M Y') }}
                        </span>
                    </div>
                    @if ($infografis->foto)
                        <img src="{{ asset('storage/grafik/' . $infografis->foto) }}" class="infografis-img-detail"
                            alt="{{ $infografis->judul }}">
                    @endif
                    <div class="infografis-content-body">
                        {!! $infografis->deskripsi !!}
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('frontend.infografis') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar-box">
                    <h4 class="sidebar-title">
                        Infografis Lainnya
                    </h4>
                    @foreach ($infografisLainnya as $item)
                        <a href="{{ route('infografis.show', $item->id) }}" class="sidebar-post">
                            <img src="{{ asset('storage/grafik/' . $item->foto) }}" alt="{{ $item->judul }}">
                            <div>
                                <h6>
                                    {{ Str::limit($item->judul, 70) }}
                                </h6>
                                <span>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .grafs-hero {
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

            padding: 2.5rem 0;
            color: white;
            align-items: center;
            overflow: hidden;
            opacity: 0;
        }

        .grafs-hero.show {
            animation: fadeHero .65s ease forwards;
        }

        @keyframes fadeHero {

            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        .section-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .grafs-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            margin: 0;
        }

        .infografis-item {
            opacity: 0;
            transform: translateY(24px);
        }

        .infografis-item.show {
            animation: fadeUp .55s ease forwards;
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

        .infografis-content {
            max-width: 860px;
            margin: 0 auto;
            color: #334155;
        }

        .infografis-title {
            font-size: 2.15rem;
            line-height: 1.35;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
            letter-spacing: -.4px;
        }

        .infografis-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            align-items: center;
            color: #64748b;
            font-size: .92rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 2rem;
        }

        .infografis-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .infografis-meta i {
            color: #2563eb;
        }

        .infografis-img-detail {
            width: 100%;
            border-radius: 12px;
            display: block;
            margin-bottom: 2.2rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        .infografis-content-body {
            font-size: 1.06rem;
            line-height: 1.9;
            color: #475569;
        }

        .infografis-content-body p {
            margin-bottom: 1.6rem;
            text-align: justify;
        }

        .infografis-content-body h2,
        .infografis-content-body h3,
        .infografis-content-body h4 {
            margin: 2.2rem 0 1rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.5;
        }

        .infografis-content-body img {
            max-width: 100%;
            border-radius: 12px;
            margin: 1.5rem 0;
        }

        .infografis-content-body ul,
        .infografis-content-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        /* ===== SIDEBAR ===== */
        .sidebar-box {
            padding-left: 1.5rem;
            opacity: 0;
            transform: translateY(24px);
        }

        .sidebar-box.show {
            animation: fadeUp .55s ease forwards;
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
            padding-bottom: .8rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .sidebar-post {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            text-decoration: none;
            color: #111827;
            padding: 14px 0;
            border-bottom: 1px solid #edf2f7;
            transition: all .25s ease;
        }

        .sidebar-post:last-child {
            border-bottom: none;
        }

        .sidebar-post:hover {
            transform: translateX(4px);
            opacity: .95;
        }

        .sidebar-post:hover h6 {
            color: #2563eb;
        }

        .sidebar-post img {
            width: 115px;
            height: 82px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
        }

        .sidebar-post h6 {
            margin-bottom: 8px;
            font-size: .95rem;
            font-weight: 600;
            line-height: 1.5;
            color: #1f2937;
            transition: .25s;
        }

        .sidebar-post span {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .82rem;
            color: #64748b;
        }

        .sidebar-post i {
            color: #2563eb;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelector(".grafs-hero")?.classList.add("show");

            const items = document.querySelectorAll(".infografis-item, .sidebar-box");

            const observer = new IntersectionObserver((entries, observer) => {

                entries.forEach((entry, index) => {

                    if (entry.isIntersecting) {

                        setTimeout(() => {
                            entry.target.classList.add("show");
                        }, index * 80);

                        observer.unobserve(entry.target);

                    }

                });

            }, {
                threshold: .15
            });

            items.forEach(item => observer.observe(item));

        });
    </script>
@endsection
