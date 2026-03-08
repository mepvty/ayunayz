@extends('layouts.guest')
{{-- Pakai layout guest yang tadi kita buat --}}

@section('content')

    {{-- ================================ --}}
    {{-- SECTION 1: HERO --}}
    {{-- ================================ --}}
    <section style="background: linear-gradient(135deg, #F5EDE3 0%, #F0D9CC 100%); padding: 100px 0;">
        <div class="container">
            <div class="row align-items-center">

                {{-- Teks kiri --}}
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span style="background-color: #6D2E46; color: white; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                        🌿 Sustainable Beauty Platform
                    </span>

                    <h1 style="font-size: 48px; color: #2A1520; margin-top: 20px; line-height: 1.2;">
                        Selamatkan Bumi <br>
                        <span style="color: #6D2E46;">Melalui Kecantikan</span> <br>
                        Berkelanjutan
                    </h1>

                    <p style="color: #666; font-size: 18px; margin: 24px 0; line-height: 1.7;">
                        Jual beli produk kosmetik preloved, daur ulang kemasan bekas, dan dapatkan reward koin — semua dalam satu platform!
                    </p>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-berry btn-lg">
                            Mulai Sekarang
                        </a>
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-berry btn-lg">
                            Lihat Produk
                        </a>
                    </div>

                    {{-- Stats kecil --}}
                    <div class="d-flex gap-4 mt-5">
                        <div>
                            <h4 style="color: #6D2E46; font-weight: 700; margin: 0;">77%</h4>
                            <small style="color: #888;">Sampah kosmetik tidak diolah</small>
                        </div>
                        <div>
                            <h4 style="color: #6D2E46; font-weight: 700; margin: 0;">82.5%</h4>
                            <small style="color: #888;">Tidak tahu cara daur ulang</small>
                        </div>
                        <div>
                            <h4 style="color: #6D2E46; font-weight: 700; margin: 0;">100%</h4>
                            <small style="color: #888;">Komitmen kami untuk bumi</small>
                        </div>
                    </div>
                </div>

                {{-- Ilustrasi kanan --}}
                <div class="col-lg-6 text-center">
                    <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: 0 20px 60px rgba(109,46,70,0.15);">
                        <div style="font-size: 80px; margin-bottom: 16px;">♻️</div>
                        <h4 style="color: #6D2E46;">Bergabung dengan AYU-NE</h4>
                        <p style="color: #888; font-size: 14px;">Jadilah bagian dari gerakan kecantikan berkelanjutan Indonesia</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <div style="background: #F5EDE3; padding: 12px 20px; border-radius: 12px; text-align: center;">
                                <div style="font-size: 24px;">🛍️</div>
                                <small style="color: #6D2E46; font-weight: 600;">Belanja</small>
                            </div>
                            <div style="background: #F5EDE3; padding: 12px 20px; border-radius: 12px; text-align: center;">
                                <div style="font-size: 24px;">♻️</div>
                                <small style="color: #6D2E46; font-weight: 600;">Daur Ulang</small>
                            </div>
                            <div style="background: #F5EDE3; padding: 12px 20px; border-radius: 12px; text-align: center;">
                                <div style="font-size: 24px;">🪙</div>
                                <small style="color: #6D2E46; font-weight: 600;">Dapat Koin</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================ --}}
    {{-- SECTION 2: PREVIEW PRODUK --}}
    {{-- ================================ --}}
    <section style="padding: 80px 0; background: white;">
        <div class="container">

            {{-- Judul section --}}
            <div class="text-center mb-5">
                <h2 style="color: #2A1520;">Produk Preloved Terbaru</h2>
                <p style="color: #888;">Temukan produk skincare & makeup bekas pakai berkualitas dengan harga terjangkau</p>
            </div>

            {{-- Grid produk --}}
            <div class="row g-4">
                @forelse($produkTerbaru as $produk)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">

                            {{-- Foto produk --}}
                            <div style="background: #F5EDE3; height: 180px; display: flex; align-items: center; justify-content: center;">
                                @if($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}"
                                         style="width: 100%; height: 180px; object-fit: cover;">
                                @else
                                    <span style="font-size: 48px;">🧴</span>
                                @endif
                            </div>

                            {{-- Info produk --}}
                            <div style="padding: 16px;">
                                {{-- Badge kondisi --}}
                                <span style="
                                    background: {{ $produk->kondisi == 'baru' ? '#d4edda' : ($produk->kondisi == 'seperti baru' ? '#fff3cd' : '#f8d7da') }};
                                    color: {{ $produk->kondisi == 'baru' ? '#155724' : ($produk->kondisi == 'seperti baru' ? '#856404' : '#721c24') }};
                                    padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                    {{ ucfirst($produk->kondisi) }}
                                </span>

                                <h6 style="color: #2A1520; margin: 8px 0 4px; font-size: 14px;">
                                    {{ $produk->nama_produk }}
                                </h6>

                                <p style="color: #6D2E46; font-weight: 700; font-size: 16px; margin: 0;">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>

                                <p style="color: #888; font-size: 12px; margin: 4px 0 12px;">
                                    <i class="bi bi-person"></i> {{ $produk->user->name }}
                                </p>

                                <a href="{{ route('produk.show', $produk->id) }}"
                                   style="display: block; text-align: center; background: #6D2E46; color: white; padding: 8px; border-radius: 8px; font-size: 13px; text-decoration: none; font-weight: 600;">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Kalau belum ada produk --}}
                    <div class="col-12 text-center" style="padding: 40px;">
                        <div style="font-size: 48px; margin-bottom: 16px;">🛍️</div>
                        <h5 style="color: #888;">Belum ada produk tersedia</h5>
                        <p style="color: #aaa;">Jadilah yang pertama jual produk preloved kamu!</p>
                        <a href="{{ route('register') }}" class="btn btn-berry">Mulai Jualan</a>
                    </div>
                @endforelse
            </div>

            {{-- Tombol lihat semua --}}
            @if(count($produkTerbaru) > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-berry btn-lg">
                        Lihat Semua Produk →
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- ================================ --}}
    {{-- SECTION 3: FITUR --}}
    {{-- ================================ --}}
    <section style="padding: 80px 0; background: #F5EDE3;">
        <div class="container">

            <div class="text-center mb-5">
                <h2 style="color: #2A1520;">Kenapa AYU-NE?</h2>
                <p style="color: #888;">Tiga fitur utama yang terintegrasi dalam satu ekosistem</p>
            </div>

            <div class="row g-4">

                {{-- Fitur 1 --}}
                <div class="col-md-4">
                    <div style="background: white; border-radius: 20px; padding: 40px; text-align: center; height: 100%; box-shadow: 0 4px 20px rgba(109,46,70,0.08);">
                        <div style="background: #F5EDE3; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                            🛍️
                        </div>
                        <h4 style="color: #6D2E46;">Ayu Belanja</h4>
                        <p style="color: #888; font-size: 15px; line-height: 1.7;">
                            Jual beli produk kosmetik preloved secara aman dan terverifikasi. Tidak perlu khawatir penipuan — semua transaksi terlindungi!
                        </p>
                        <div style="background: #F5EDE3; border-radius: 12px; padding: 16px; margin-top: 20px;">
                            <small style="color: #6D2E46; font-weight: 600;">✨ Dapat 10 Ayu Koin per transaksi!</small>
                        </div>
                    </div>
                </div>

                {{-- Fitur 2 --}}
                <div class="col-md-4">
                    <div style="background: #6D2E46; border-radius: 20px; padding: 40px; text-align: center; height: 100%; box-shadow: 0 4px 20px rgba(109,46,70,0.3);">
                        <div style="background: rgba(255,255,255,0.2); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                            ♻️
                        </div>
                        <h4 style="color: white;">Ayu Daur Ulang</h4>
                        <p style="color: rgba(255,255,255,0.8); font-size: 15px; line-height: 1.7;">
                            Temukan lokasi drop-off terdekat untuk daur ulang kemasan kosmetikmu. Cukup kumpulkan, foto, dan drop-off!
                        </p>
                        <div style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 16px; margin-top: 20px;">
                            <small style="color: white; font-weight: 600;">✨ Dapat 25 Ayu Koin per drop-off!</small>
                        </div>
                    </div>
                </div>

                {{-- Fitur 3 --}}
                <div class="col-md-4">
                    <div style="background: white; border-radius: 20px; padding: 40px; text-align: center; height: 100%; box-shadow: 0 4px 20px rgba(109,46,70,0.08);">
                        <div style="background: #F5EDE3; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                            🪙
                        </div>
                        <h4 style="color: #6D2E46;">Ayu Koin</h4>
                        <p style="color: #888; font-size: 15px; line-height: 1.7;">
                            Kumpulkan koin dari setiap aktivitas dan tukarkan dengan diskon belanja. Makin aktif, makin banyak keuntungannya!
                        </p>
                        <div style="background: #F5EDE3; border-radius: 12px; padding: 16px; margin-top: 20px;">
                            <small style="color: #6D2E46; font-weight: 600;">✨ Tukar koin untuk diskon belanja!</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================================ --}}
    {{-- SECTION 4: CTA --}}
    {{-- ================================ --}}
    <section style="padding: 80px 0; background: #2A1520;">
        <div class="container text-center">
            <h2 style="color: white; font-size: 40px;">
                Siap Jadi Bagian dari <br>
                <span style="color: #A26769;">Gerakan Kecantikan Berkelanjutan?</span>
            </h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 18px; margin: 24px auto; max-width: 600px;">
                Bergabung dengan ribuan pengguna yang sudah memilih gaya hidup cantik yang ramah lingkungan.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-lg" style="background: #6D2E46; color: white; padding: 14px 36px; border-radius: 12px; font-weight: 600; font-size: 16px;">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('produk.index') }}" class="btn btn-lg" style="background: transparent; color: white; border: 2px solid rgba(255,255,255,0.4); padding: 14px 36px; border-radius: 12px; font-weight: 600; font-size: 16px;">
                    Lihat Produk Dulu
                </a>
            </div>
        </div>
    </section>

@endsection

{{-- blm bljr iniii --}}