@php
    use App\Helpers\VisitorCounter;
    $statistik = VisitorCounter::count();
@endphp
<footer class="footer-section py-4">
    <div class="footer-particles"></div>
    <div class="container">
        <div class="row align-items-start text-white">

            <!-- KIRI -->
            <div class="col-md-4 mb-2">
                <h5 class="footer-title">Satu Data Kabupaten Murung Raya</h5>
                <div class="footer-info-row">
                    <span class="label">Alamat</span>
                    <span class="separator">:</span>
                    Jl. Letjen Suprapto
                </div>

                <div class="footer-info-row">
                    <span class="label">Email</span>
                    <span class="separator">:</span>
                    <span class="value">diskominfo@murungrayakab.go.id</span>
                </div>
                <div class="footer-info-row">
                    <span class="label">Telepon</span>
                    <span class="separator">:</span>
                    <span class="value">0853-7777-8888</span>
                </div>
            </div>

            <!-- TENGAH -->
            <div class="col-md-4 mb-1 d-flex justify-content-center">
                <div class="statistik-wrapper">

                    <h5 class="footer-title d-flex align-items-center gap-2">
                        <i class="bi bi-bar-chart-fill"></i>
                        DATA STATISTIK
                    </h5>

                    <div class="stat-row">
                        <span class="label">Total Pengunjung</span>
                        <span class="separator">:</span>
                        <span class="value">
                            {{ $statistik['total'] ?? 0 }}
                        </span>
                    </div>

                    <div class="stat-row">
                        <span class="label">Pengunjung Hari Ini</span>
                        <span class="separator">:</span>
                        <span class="value">
                            {{ $statistik['today'] ?? 0 }}
                        </span>
                    </div>

                    <div class="stat-row">
                        <span class="label">Pengunjung Online</span>
                        <span class="separator">:</span>
                        <span class="value">
                            {{ $statistik['online'] ?? 0 }}
                        </span>
                    </div>

                </div>
            </div>

            <!-- KANAN -->
            <div class="col-md-4 mb-1 text-md-end text-center">
                <h5 class="footer-title">Media Sosial Satu Data Kabupaten Murung Raya</h5>

                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <div class="text-center mt-2 pt-3 border-top border-white">
            <small class="d-block text-white">
                &copy; {{ date('Y') }} Tim Pengembang Dinas Komunikasi, Informatika, Statistik dan Persandian
                Kabupaten
                Murung Raya
            </small>
        </div>
    </div>
</footer>

<style>
    /* ===== FOOTER ===== */
    .footer-section {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #1E3A8A, #2563EB);
        margin-top: auto;
    }

    .footer-section .container {
        position: relative;
        z-index: 2;
    }

    .footer-section .col-md-4 {
        min-width: 0;
    }

    .footer-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .footer-particles {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }

    .footer-particles::before,
    .footer-particles::after {
        content: "";
        position: absolute;
        width: 200%;
        height: 200%;
        background-image:
            radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 40px 40px;
        animation: moveParticles 25s linear infinite;
        filter:
            drop-shadow(0 0 2px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 6px rgba(255, 255, 255, 0.4)) drop-shadow(0 0 12px rgba(255, 255, 255, 0.2));
        animation: moveParticles 25s linear infinite,
            glowPulse 6s ease-in-out infinite;
    }

    .footer-particles::before {
        background-image:
            radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px),
            radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
    }

    .footer-particles::after {
        background-image:
            radial-gradient(rgba(255, 255, 255, 0.15) 2px, transparent 2px);
        opacity: 0.6;
        background-size: 70px 70px;
        animation-duration: 45s;
    }

    @keyframes moveParticles {
        from {
            transform: translate(0, 0);
        }

        to {
            transform: translate(-200px, -200px);
        }
    }

    @keyframes glowPulse {

        0%,
        100% {
            filter:
                drop-shadow(0 0 2px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 6px rgba(255, 255, 255, 0.4)) drop-shadow(0 0 12px rgba(255, 255, 255, 0.2));
        }

        50% {
            filter:
                drop-shadow(0 0 4px rgba(255, 255, 255, 0.9)) drop-shadow(0 0 10px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));
        }
    }

    .footer-info-row {
        display: grid;
        grid-template-columns: 90px 10px 1fr;
        gap: 6px;
    }

    .stat-row {
        display: grid;
        grid-template-columns: 180px 10px 1fr;
        gap: 6px;
    }

    .label {
        white-space: nowrap;
    }

    .separator {
        text-align: center;
    }

    .value {
        text-align: left;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    .social-icons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    .social-icons a {
        color: white;
        font-size: 50px;
        transition: 0.2s;
        text-decoration: none;
    }

    .social-icons a:hover {
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .social-icons {
            justify-content: center;
        }

        .statistik-wrapper {
            width: 100%;
        }
    }
</style>
