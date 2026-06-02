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
        <div class="infografis-item mb-5">
            <h3 class="infografis-title">Statistik Jumlah Dataset Kabupaten Murung Raya</h3>
            <div class="infografis-meta mb-3">
                oleh: Diskominfo Murung Raya | 12 Januari 2025
            </div>
            <div class="row align-items-start">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/infografis5.png') }}" class="img-fluid infografis-img-detail"
                        alt="">
                </div>
                <div class="col-md-7">
                    <p>
                        Infografis ini menampilkan perkembangan jumlah dataset yang tersedia dalam portal Satu Data
                        Kabupaten Murung Raya. Data menunjukkan peningkatan signifikan setiap tahunnya sebagai hasil dari
                        komitmen pemerintah daerah dalam meningkatkan keterbukaan data.
                    </p>
                    <p>
                        Dengan semakin banyaknya dataset yang tersedia, masyarakat, peneliti, dan instansi dapat
                        memanfaatkan data tersebut untuk analisis, pengambilan keputusan, serta pengembangan inovasi
                        berbasis data.
                    </p>
                </div>
            </div>
        </div>
        <div class="infografis-item mb-5">
            <h3 class="infografis-title">Distribusi Dataset Berdasarkan Organisasi</h3>
            <div class="infografis-meta mb-3">
                oleh: Diskominfo Murung Raya | 20 Februari 2025
            </div>

            <div class="row align-items-start">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/infografis5.png') }}" class="img-fluid infografis-img-detail"
                        alt="">
                </div>
                <div class="col-md-7">
                    <p>
                        Infografis ini menggambarkan kontribusi masing-masing organisasi perangkat daerah dalam penyediaan
                        dataset. Beberapa organisasi menjadi penyumbang utama karena memiliki data sektoral yang lebih luas.
                    </p>
                    <p>
                        Informasi ini penting untuk mengidentifikasi kesenjangan data serta mendorong organisasi lain agar
                        lebih aktif dalam berbagi data secara terbuka.
                    </p>
                </div>
            </div>
        </div>
        <div class="infografis-item mb-5">
            <h3 class="infografis-title">Jenis Format Dataset yang Tersedia</h3>
            <div class="infografis-meta mb-3">
                oleh: Diskominfo Murung Raya | 5 Maret 2025
            </div>
            <div class="row align-items-start">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/infografis5.png') }}" class="img-fluid infografis-img-detail"
                        alt="">
                </div>
                <div class="col-md-7">
                    <p>
                        Data dalam portal tersedia dalam berbagai format seperti CSV, Excel, dan PDF. Format terbuka seperti
                        CSV menjadi pilihan utama karena mudah diolah kembali oleh pengguna.
                    </p>
                    <p>
                        Keberagaman format ini memastikan bahwa data dapat diakses oleh berbagai kalangan, mulai dari
                        pengguna umum hingga analis data profesional.
                    </p>
                </div>
            </div>
        </div>
        <div class="infografis-item mb-5">
            <h3 class="infografis-title">Tren Penggunaan dan Akses Dataset</h3>
            <div class="infografis-meta mb-3">
                oleh: Diskominfo Murung Raya | 18 Maret 2025
            </div>
            <div class="row align-items-start">
                <div class="col-md-5">
                    <img src="{{ asset('assets/images/infografis5.png') }}" class="img-fluid infografis-img-detail"
                        alt="">
                </div>
                <div class="col-md-7">
                    <p>
                        Infografis ini menunjukkan tren peningkatan akses dataset oleh masyarakat. Hal ini mencerminkan
                        meningkatnya kesadaran akan pentingnya data dalam kehidupan sehari-hari.
                    </p>
                    <p>
                        Pemerintah daerah terus berupaya meningkatkan kualitas dan kuantitas data agar lebih relevan dan
                        bermanfaat bagi publik.
                    </p>
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

            padding: 2rem 0;
            color: white;
            align-items: center;
            overflow: hidden;
        }

        .grafs-hero.show {
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

        .grafs-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            margin: 0;
        }

        .infografis-item {
            padding-bottom: 30px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .infografis-item:hover {
            transform: translateY(-3px);
        }

        .infografis-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .infografis-item:last-child {
            margin-bottom: 0 !important;
            padding-bottom: 0;
            border-bottom: none;
        }

        .infografis-item p {
            font-size: 1.1rem;
            color: #1f2937;
            line-height: 1.7;
            text-align: justify;
            margin-bottom: 10px;
        }

        .infografis-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #000000;
            margin-bottom: 5px;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .infografis-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #1E3A8A, #2563EB);
            margin-top: 6px;
        }

        .infografis-meta {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 15px;
        }


        .infografis-img-detail {
            border-radius: 12px;
            width: 100%;
            height: 100%;
            max-height: 260px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .grafs-hero .section-title {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .grafs-hero.show .section-title {
            opacity: 1;
            transform: translateY(0);
        }

        .grafs-subtitle {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .grafs-hero.show .grafs-subtitle {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 0.15s;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll(".infografis-item");

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {

                        setTimeout(() => {
                            entry.target.classList.add("show");
                        }, index * 150);

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            items.forEach(item => observer.observe(item));
        });

        document.addEventListener("DOMContentLoaded", function() {
            const hero = document.querySelector('.grafs-hero');

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

        });
    </script>
@endsection
