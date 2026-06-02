@extends('layouts.app')

@section('title', 'Daftar Organisasi')

@section('content')

    <div class="org-hero">
        <div class="container text-center">
            <h1 class="section-title text-white">
                <i class="fa-solid fa-building-columns"></i> Organisasi
            </h1>
            <p class="org-subtitle">
                Daftar Organisasi Yang Sudah Melakukan Kontribusi Dalam Daftar Data
            </p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4 gy-5 justify-content-center">

            @for ($i = 0; $i < 12; $i++)
                <div class="col-6 col-md-2 text-center org-item">
                    <img src="{{ asset('assets/images/default-logo.png') }}" class="org-logo" alt="Logo">
                </div>
            @endfor

        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn-more-info">
                <span>More Info</span>
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <style>
        .org-hero {
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

            padding: 2rem 0;
            color: white;
            align-items: center;
            overflow: hidden;
        }

        .org-hero.show {
            animation: fadeHero 0.8s ease;
        }

        @keyframes fadeHero {
            from {
                opacity: 0.7;
                transform: scale(1.02);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .org-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            margin: 0;
        }

        .org-logo {
            max-height: 150px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .org-logo:hover {
            transform: scale(1.08);
            filter: brightness(1.1);
        }

        .btn-more-info {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 28px;
            background: white;
            color: #1D4ED8;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border: 2px solid transparent;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .btn-more-info:hover {
            background: linear-gradient(135deg, #1E3A8A, #2563EB);
            color: white;
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.25);
        }

        .btn-more-info i {
            transition: transform 0.3s ease;
        }

        .btn-more-info:hover i {
            transform: translateX(4px);
        }

        .org-item {
            opacity: 0;
            transform: translateY(25px) scale(0.95);
            transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .org-item.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .org-logo {
            max-height: 150px;
            object-fit: contain;
            transition: transform 0.4s ease, filter 0.4s ease;
        }

        .org-item:hover .org-logo {
            transform: scale(1.08);
            filter: brightness(1.1);
        }

        .org-hero .section-title,
        .org-hero .org-subtitle {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .org-hero.show .section-title {
            opacity: 1;
            transform: translateY(0);
        }

        .org-hero.show .org-subtitle {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.15s;
        }
    </style>

    <script>
        const hero = document.querySelector('.org-hero');

        if (hero) {
            const heroObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        hero.classList.add('show');
                    }
                });
            }, {
                threshold: 0.3
            });

            heroObserver.observe(hero);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll(".org-item");

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {

                        const index = Array.from(items).indexOf(entry.target);

                        setTimeout(() => {
                            entry.target.classList.add("show");
                        }, index * 80);

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            items.forEach(item => observer.observe(item));
        });
    </script>

@endsection
