<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYU-NE — Sustainable Beauty</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <style>
        /* Warna AYU-NE */
        :root {
            --berry: #6D2E46;
            --rose: #A26769;
            --cream: #F5EDE3;
            --dark: #2A1520;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--dark);
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        .btn-berry {
            background-color: var(--berry);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-berry:hover {
            background-color: var(--dark);
            color: white;
        }

        .btn-outline-berry {
            border: 2px solid var(--berry);
            color: var(--berry);
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            background: transparent;
        }

        .btn-outline-berry:hover {
            background-color: var(--berry);
            color: white;
        }

        /* Navbar */
        .navbar-ayune {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 16px 0;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--berry) !important;
        }

        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            margin: 0 8px;
        }

        .nav-link:hover {
            color: var(--berry) !important;
        }

        /* Footer */
        .footer-ayune {
            background-color: var(--dark);
            color: var(--cream);
            padding: 48px 0 24px;
        }

        .footer-ayune a {
            color: var(--rose);
            text-decoration: none;
        }

        .footer-ayune a:hover {
            color: white;
        }
    </style>

    {{-- Style tambahan dari halaman masing-masing --}}
    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-ayune sticky-top">
        <div class="container">

            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('landing') }}">
                🌿 AYU-NE
            </a>

            {{-- Hamburger untuk mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('produk.index') }}">Belanja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lokasi-dropoff.index') }}">Daur Ulang</a>
                    </li>
                </ul>

                {{-- Tombol Login/Register --}}
                <div class="d-flex gap-2">
                    @guest
                        {{-- Belum login → tampilkan tombol masuk & daftar --}}
                        <a href="{{ route('login') }}" class="btn-outline-berry btn">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-berry btn">Daftar</a>
                    @endguest

                    @auth
                        {{-- Sudah login → tampilkan tombol dashboard --}}
                        <a href="{{ route('dashboard') }}" class="btn-berry btn">Dashboard</a>
                    @endauth
                </div>
            </div>

        </div>
    </nav>

    {{-- KONTEN HALAMAN --}}
    <main>
        @yield('content')
        {{-- Ini yang diisi oleh tiap halaman yang pakai layout ini --}}
    </main>

    {{-- FOOTER --}}
    <footer class="footer-ayune">
        <div class="container">
            <div class="row">

                {{-- Kolom 1: Brand --}}
                <div class="col-md-4 mb-4">
                    <h5 style="color: var(--cream); font-family: 'Playfair Display', serif;">
                        🌿 AYU-NE
                    </h5>
                    <p style="color: #B0B0B0; font-size: 14px;">
                        Platform kecantikan berkelanjutan untuk generasi yang peduli bumi. Jual beli preloved, daur ulang kemasan, dapat reward!
                    </p>
                </div>

                {{-- Kolom 2: Navigasi --}}
                <div class="col-md-4 mb-4">
                    <h6 style="color: var(--rose); font-weight: 600;">Navigasi</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('landing') }}">Home</a></li>
                        <li><a href="{{ route('produk.index') }}">Belanja Preloved</a></li>
                        <li><a href="{{ route('lokasi-dropoff.index') }}">Lokasi Daur Ulang</a></li>
                        <li><a href="{{ route('register') }}">Daftar Sekarang</a></li>
                    </ul>
                </div>

                {{-- Kolom 3: Kontak --}}
                <div class="col-md-4 mb-4">
                    <h6 style="color: var(--rose); font-weight: 600;">Hubungi Kami</h6>
                    <p style="color: #B0B0B0; font-size: 14px;">
                        <i class="bi bi-envelope"></i> hello@ayune.id<br>
                        <i class="bi bi-instagram"></i> @ayune.id<br>
                        <i class="bi bi-tiktok"></i> @ayune.id
                    </p>
                </div>

            </div>

            {{-- Copyright --}}
            <hr style="border-color: #3D2030;">
            <p class="text-center" style="color: #B0B0B0; font-size: 12px;">
                © 2025 AYU-NE. Dibuat dengan 💚 untuk bumi yang lebih baik.
            </p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script tambahan dari halaman masing-masing --}}
    @stack('scripts')

</body>
</html>

{{-- BELUM BLJR INIII --}}