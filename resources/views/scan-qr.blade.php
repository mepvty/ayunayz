<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Barcode - AYU-NE</title>

    {{-- Iconify: library ikon --}}
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

    {{-- Google Fonts: font Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Reset semua margin/padding bawaan browser */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        /* Background halaman: gradient pink muda, min-height 100vh biar ga pendek */
        body { 
            background: linear-gradient(180deg, #ffe8ed 0%, #fff5f5 50%, #ffe8ed 100%); 
            background-attachment: fixed; 
            color: #3b1a1a;
            min-height: 100vh;
        }

        /* Wrapper utama konten halaman */
        .container {
            max-width: 1100px;
            margin: 24px auto;
            padding: 0 20px;
        }

        /* Card putih utama yang membungkus seluruh konten */
        .card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(224,112,128,0.12);
            max-width: 1100px;
            margin: 0 auto;
            margin-top: 45px;
            overflow: hidden;
        }

        /* ==========================================
           STEP INDICATOR
           3 dot di atas menunjukkan progress:
           Dot 1 = Upload Foto, Dot 2 = Scan QR (aktif), Dot 3 = Sukses
           ========================================== */
        .step-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        /* Dot tidak aktif: bulat kecil abu */
        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f5e0e0;
        }

        /* Dot aktif: lonjong merah */
        .step-dot.active {
            background: #e07080;
            width: 28px;
            border-radius: 50px;
        }

        h1 { font-size: 24px; font-weight: 800; color: #3b1a1a; margin-bottom: 8px; }
        .subtitle { font-size: 14px; color: #9a6a6a; margin-bottom: 32px; }

        /* Input teks kode manual: border dashed merah */
        .input-kode {
            width: 100%;
            padding: 14px 20px;
            border: 2px dashed #e07080;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            margin-bottom: 16px;
            transition: border 0.2s;
            color: #3b1a1a;
        }
        .input-kode:focus { border-color: #e07080; background: #fff5f7; }
        .input-kode::placeholder { color: #c4a0a0; }

        /* Pesan error validasi kode QR */
        .error-msg { color: #e07080; font-size: 13px; margin-bottom: 16px; }
    </style>
</head>
<body>
    {{-- Navbar diambil dari file layouts/navigation.blade.php --}}
    @include('layouts.navigation')

    <div class="container">
        <div class="card">

            {{-- Step indicator: dot ke-2 aktif karena ini halaman step 2 --}}
            <div class="step-indicator">
                <div class="step-dot"></div>          {{-- Step 1: Upload Foto (sudah lewat) --}}
                <div class="step-dot active"></div>   {{-- Step 2: Scan QR (halaman ini) --}}
                <div class="step-dot"></div>          {{-- Step 3: Sukses (belum) --}}
            </div>

            <h1>Scan Barcode Drop Box</h1>
            <p class="subtitle">Scan barcode yang ada di drop box AYU-NE atau input kode manual</p>

            {{-- Layout 2 kolom: kiri (scanner + input) lebih lebar, kanan (info + tombol) lebih kecil --}}
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: stretch;">

                {{-- ==========================================
                     KOLOM KIRI
                     Berisi tombol buka kamera, video scanner, divider, input manual
                     ========================================== --}}
                <div>

                    {{-- Tombol buka kamera QR: muncul saat kamera belum aktif --}}
                    <div id="btnScanWrap" style="margin-bottom:16px;">
                        <button type="button" onclick="startScanner()"
                            style="width:100%; min-height:195px; padding:10px; border:2px dashed #e07080; border-radius:12px; background:white; color:#9a6a6a; font-size:14px; cursor:pointer; font-family:'Poppins',sans-serif; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                            <iconify-icon icon="solar:qr-code-linear" style="font-size:48px; color:#e07080;"></iconify-icon>
                            <span>Gunakan Kamera untuk Barcode</span>
                            <span style="font-size:12px; color:#c4a0a0;">Arahkan kamera ke Barcode</span>
                        </button>
                    </div>

                    {{-- Box video kamera: tersembunyi dulu, muncul saat kamera aktif --}}
                    <div id="qr-box" style="display:none; margin-bottom:16px;">
                        <video id="qr-video" style="width:100%; min-height:160px; max-height:195px; border-radius:12px; object-fit:cover;"></video>
                    </div>

                    {{-- Divider pemisah antara kamera dan input manual --}}
                    <div style="display:flex; align-items:center; gap:12px; margin:16px 0; color:#c4a0a0; font-size:13px;">
                        <div style="flex:1; height:1px; background:#f5e0e0;"></div>
                        atau input kode manual
                        <div style="flex:1; height:1px; background:#f5e0e0;"></div>
                    </div>

                    {{-- Form input kode manual
                         Action: route proses-qr (RecyclingController@prosesQR)
                         Validasi: qr_code harus diisi dan valid --}}
                    <form method="POST" action="{{ route('proses-qr') }}">
                        @csrf
                        <input type="text" name="qr_code" class="input-kode"
                            placeholder="Masukkan kode drop box..."
                            id="kodeInput"
                            value="{{ old('qr_code') }}"
                            style="border-radius:12px;">

                        {{-- Tampilkan error validasi kalau kode salah --}}
                        @error('qr_code')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror

                        {{-- Area submit tersembunyi (tidak dipakai, submit ada di form kanan) --}}
                        <div style="display:none;" id="submitArea"></div>
                    </form>
                </div>

                {{-- ==========================================
                     KOLOM KANAN
                     Berisi info cara scan + tombol Konfirmasi
                     ========================================== --}}
                <div style="display:flex; flex-direction:column; justify-content:flex-start; gap:16px; height:100%;">

                    {{-- Box info cara scan --}}
                    <div style="background:#fff5f7; border-radius:12px; padding:16px 20px;">
                        <h3 style="font-size:16px; font-weight:700; color:#3b1a1a; margin-bottom:12px;">Cara Scan Barcode</h3>
                        <p style="font-size:13px; color:#7a4a4a; line-height:1.8;">
                            ✿ Arahkan kamera ke Barcode di drop box<br>
                            ✿ Atau input kode yang tertera di drop box<br>
                            ✿ Pastikan kode sesuai dengan lokasi drop box
                        </p>
                    </div>

                    {{-- Form tombol Konfirmasi
                         Punya hidden input kodeHidden yang diisi via JS
                         Tombol disabled dulu, aktif setelah kode terisi --}}
                    <form method="POST" action="{{ route('proses-qr') }}">
                        @csrf
                        {{-- Input hidden: diisi otomatis dari kodeInput atau hasil scan QR --}}
                        <input type="hidden" name="qr_code" id="kodeHidden">
                        <button type="submit"
                            id="btnKonfirmasi"
                            disabled
                            style="width:100%; padding:18px; background:#f0d5d5; color:#c4a0a0; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:not-allowed; font-family:'Poppins',sans-serif; box-shadow:none;">
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Library jsQR untuk membaca QR code dari video kamera --}}
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>

    <script>
        // Status apakah kamera sedang aktif scanning atau tidak
        let scanning = false;

        // Fungsi membuka kamera dan mulai scanning QR
        async function startScanner() {
            const video = document.getElementById('qr-video');
            const qrBox = document.getElementById('qr-box');
            const btnScanWrap = document.getElementById('btnScanWrap');
            try {
                // Minta akses kamera belakang (environment)
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                video.srcObject = stream;
                video.style.display = 'block';
                qrBox.style.display = 'block';       // tampilkan video
                btnScanWrap.style.display = 'none';  // sembunyikan tombol buka kamera
                video.play();
                scanning = true;
                scanFrame(video); // mulai loop scan
            } catch (err) {
                alert('Kamera tidak bisa diakses, gunakan input manual ya!');
            }
        }

        // Fungsi loop: tiap frame video dicek apakah ada QR code
        function scanFrame(video) {
            if (!scanning) return;

            // Gambar frame video ke canvas untuk dibaca jsQR
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);

            // Coba baca QR code dari frame
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {
                // QR berhasil dibaca: isi input + aktifkan tombol
                scanning = false;
                document.getElementById('kodeInput').value = code.data;
                document.getElementById('kodeHidden').value = code.data;
                video.srcObject.getTracks().forEach(t => t.stop()); // matikan kamera
                document.getElementById('qr-box').style.display = 'none';
                document.getElementById('btnScanWrap').style.display = 'block';
                cekDanAktifkan();
            } else {
                // Belum ada QR: lanjut ke frame berikutnya
                requestAnimationFrame(() => scanFrame(video));
            }
        }

        // Fungsi mengaktifkan tombol Konfirmasi (ubah tampilan dari disabled ke aktif)
        function aktifkanTombol() {
            const btn = document.getElementById('btnKonfirmasi');
            btn.disabled = false;
            btn.style.background = 'linear-gradient(135deg, #f4a0aa 0%, #e07080 100%)';
            btn.style.color = 'white';
            btn.style.cursor = 'pointer';
            btn.style.boxShadow = '0 4px 16px rgba(224,112,128,0.3)';
        }

        // Fungsi cek apakah input kode sudah terisi, kalau iya aktifkan tombol
        function cekDanAktifkan() {
            const val = document.getElementById('kodeInput').value.trim();
            if (val !== '') {
                document.getElementById('kodeHidden').value = val;
                aktifkanTombol();
            }
        }

        // Aktifkan tombol saat user mengetik kode manual
        document.getElementById('kodeInput').addEventListener('input', function() {
            document.getElementById('kodeHidden').value = this.value;
            if (this.value.trim() !== '') {
                aktifkanTombol();
            }
        });

        // Cek saat halaman pertama load (untuk old value kalau ada error validasi)
        document.addEventListener('DOMContentLoaded', cekDanAktifkan);
    </script>
</body>
</html>