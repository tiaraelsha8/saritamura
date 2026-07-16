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
        <div class="mx-auto infografis-content infografis-item">

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
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/grafik/' . $infografis->foto) }}" alt="{{ $infografis->judul }}"
                        class="infografis-img-detail">
                </div>
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

        .infografis-content-body {
            font-size: 1.08rem;
            line-height: 1.9;
            color: #334155;
        }

        .infografis-content-body p {
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .infografis-content-body h2,
        .infografis-content-body h3,
        .infografis-content-body h4 {
            margin: 2rem 0 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        .infografis-content-body img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        .infografis-content-body ul,
        .infografis-content-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .infografis-item p {
            font-size: 1.1rem;
            color: #1f2937;
            line-height: 1.7;
            text-align: justify;
            margin-bottom: 10px;
        }

        .infografis-title {
            font-size: 2rem;
            line-height: 1.3;
            font-weight: 700;
            color: #000000;
            margin-bottom: .75rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .infografis-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            align-items: center;
            color: #64748b;
            font-size: .9rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 18px;
            margin-bottom: 30px;
        }

        .infografis-img-detail {
            border-radius: 12px;
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelector(".grafs-hero")?.classList.add("show");

            const items = document.querySelectorAll(".infografis-item");

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
