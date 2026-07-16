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
        <div class="mx-auto d-flex flex-column gap-4 infografis-container">
            @forelse ($infografis as $item)
                <div class="infografis-item">
                    <div class="row align-items-center g-4">

                        <div class="col-lg-4 image-col">

                            <div class="infografis-image-wrapper">

                                <img src="{{ $item->foto ? asset('storage/grafik/' . $item->foto) : 'https://via.placeholder.com/600x400?text=No+Image' }}"
                                    class="infografis-img-detail" alt="{{ $item->judul }}" loading="lazy">

                            </div>

                        </div>

                        <div class="col-lg-8 content-col">

                            <h3>
                                <a href="{{ route('infografis.show', $item->id) }}" class="infografis-title">
                                    {{ $item->judul }}
                                </a>
                            </h3>

                            <div class="infografis-meta">

                                <span>
                                    <i class="fa-solid fa-user"></i>
                                    {{ $item->penulis }}
                                </span>

                                <span>
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $item->created_at->format('d M Y') }}
                                </span>

                            </div>

                            <p class="infografis-description">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 150, '...') }}
                            </p>

                            <a href="{{ route('infografis.show', $item->id) }}" class="btn-detail">

                                Selengkapnya
                                <i class="fa-solid fa-arrow-right ms-2"></i>

                            </a>

                        </div>

                    </div>
                </div>

            @empty
                <div class="alert alert-info">
                    Data infografis belum tersedia.
                </div>
            @endforelse

            {{-- PAGINATION --}}
            @if ($infografis->hasPages())
                <div class="pagination-wrapper d-flex justify-content-center">
                    {{ $infografis->links('pagination::bootstrap-4') }}
                </div>
            @endif
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

        .infografis-container {
            max-width: 1320px;
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
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow:
                0 2px 8px rgba(15, 23, 42, .05),
                0 10px 20px rgba(15, 23, 42, .06);
            opacity: 0;
            transform: translateY(18px);
            transition:
                opacity .55s ease,
                transform .55s ease,
                box-shadow .3s ease;
        }

        .infografis-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .infografis-item:hover {
            box-shadow:
                0 1px 2px rgba(0, 0, 0, .04),
                0 10px 25px rgba(15, 23, 42, .08),
                0 30px 60px rgba(15, 23, 42, .08);
        }

        .infografis-image-wrapper {
            background: #f8fafc;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #eef2f7;
            position: relative;
        }

        .infografis-img-detail {
            display: block;
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        .infografis-description {
            color: #334155;
            font-size: 1rem;
            line-height: 1.5;
            text-align: justify;
            margin-bottom: 24px;
        }

        .infografis-title {
            display: inline-block;
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            line-height: 1.45;
            text-decoration: none;
            transition: color .25s ease;
        }

        .infografis-title:hover {
            color: #0d6efd;
            cursor: pointer;
        }

        .infografis-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 18px 0;
            color: #64748b;
            font-size: .88rem;
        }

        .infografis-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .infografis-meta i {
            color: #2563EB;
            opacity: .8;
        }

        .btn-detail {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 9px 16px;
            font-size: .84rem;
            font-weight: 600;
            line-height: 1.5;
            text-decoration: none;
            border: 1px solid #0d6efd;
            border-radius: 8px;
            background-color: #fff;
            color: #0d6efd;
            transition:
                background-color .25s ease,
                color .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .btn-detail:hover {
            background: #2563EB;
            color: #fff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, .18);
        }

        .btn-detail i {
            transition: transform .25s ease;
        }

        .btn-detail:hover i {
            transform: translateX(3px);
        }

        .pagination-wrapper {
            margin-top: 24px;
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
