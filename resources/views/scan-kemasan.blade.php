<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Kemasan - AYU-NE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #fff; color: #3b1a1a; }

        .navbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 40px; border-bottom: 1px solid #f5e0e0;
            background: white; position: sticky; top: 0; z-index: 100;
        }
        .nav-logo img { height: 36px; width: auto; object-fit: contain; }
        .nav-links { display: flex; gap: 36px; list-style: none; }
        .nav-links a { text-decoration: none; font-size: 14px; font-weight: 500; color: #7a4a4a; transition: color 0.2s; }
        .nav-links a:hover { color: #e07080; }
        .nav-right { display: flex; align-items: center; gap: 18px; }
        .search-box { display: flex; align-items: center; background: #f9f0f2; border-radius: 50px; padding: 8px 16px; gap: 8px; width: 220px; }
        .search-box input { border: none; background: transparent; outline: none; font-size: 13px; color: #3b1a1a; width: 100%; font-family: 'Poppins', sans-serif; }
        .search-box input::placeholder { color: #c4a0a0; }
        .nav-icon { position: relative; cursor: pointer; font-size: 20px; color: #7a4a4a; text-decoration: none; }
        .badge { position: absolute; top: -6px; right: -6px; background: #e07080; color: white; font-size: 9px; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f4a0aa; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: white; text-decoration: none; }

        /* CONTENT */
        .content { max-width: 700px; margin: 0 auto; padding: 48px 20px; text-align: center; }

        h1 { font-size: 26px; font-weight: 800; color: #3b1a1a; margin-bottom: 28px; }

        /* TABS */
        .tab-wrap { display: flex; justify-content: center; gap: 12px; margin-bottom: 36px; }
        .tab-btn {
            display: flex; align-items: center; gap: 8px; padding: 12px 28px;
            border-radius: 50px; border: 1.5px solid #f0d5d5; background: white;
            font-size: 14px; font-weight: 500; color: #7a4a4a; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: all 0.2s;
        }
        .tab-btn.active { background: #f4a0aa; color: white; border-color: #f4a0aa; font-weight: 600; }
        .tab-btn:hover:not(.active) { border-color: #f4a0aa; color: #e07080; }

        /* SCAN VIEW */
        .scan-view { display: none; }
        .scan-view.active { display: block; }

        .scan-box-wrap { position: relative; width: 300px; height: 300px; margin: 0 auto 20px auto; }
        .scan-box { width: 100%; height: 100%; background: #f9f5f5; border-radius: 12px; position: relative; overflow: hidden; }
        .scan-line { position: absolute; left: 0; right: 0; height: 2px; background: #f4a0aa; animation: scanMove 2s ease-in-out infinite; }
        @keyframes scanMove { 0% { top: 10%; } 50% { top: 85%; } 100% { top: 10%; } }
        .corner { position: absolute; width: 28px; height: 28px; }
        .corner-tl { top: -2px; left: -2px; border-top: 3px solid #f4a0aa; border-left: 3px solid #f4a0aa; border-radius: 4px 0 0 0; }
        .corner-tr { top: -2px; right: -2px; border-top: 3px solid #f4a0aa; border-right: 3px solid #f4a0aa; border-radius: 0 4px 0 0; }
        .corner-bl { bottom: -2px; left: -2px; border-bottom: 3px solid #f4a0aa; border-left: 3px solid #f4a0aa; border-radius: 0 0 0 4px; }
        .corner-br { bottom: -2px; right: -2px; border-bottom: 3px solid #f4a0aa; border-right: 3px solid #f4a0aa; border-radius: 0 0 4px 0; }

        .scan-hint { font-size: 13.5px; color: #7a4a4a; margin-top: 20px; margin-bottom: 24px; }

        .btn-aktifkan {
            padding: 14px 48px; background: #f4a0aa; color: white; border: none;
            border-radius: 50px; font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: background 0.2s;
            display: block; margin: 0 auto 16px auto;
        }
        .btn-aktifkan:hover { background: #e8858f; }

        .link-manual { font-size: 13px; color: #e07080; font-weight: 500; cursor: pointer; display: inline-block; margin-top: 16px; }
        .link-manual:hover { opacity: 0.7; }

        /* FORM KONFIRMASI (muncul setelah klik Aktifkan Kamera) */
        .form-konfirmasi {
            display: none;
            background: #fff5f6;
            border-radius: 16px;
            padding: 24px;
            margin-top: 28px;
            text-align: left;
        }
        .form-konfirmasi.show { display: block; }

        .valid-label {
            display: flex; align-items: center; gap: 8px;
            color: #2ecc71; font-size: 14px; font-weight: 600; margin-bottom: 20px;
        }

        .field-label { font-size: 13px; font-weight: 700; color: #3b1a1a; margin-bottom: 8px; }

        .field-select {
            width: 100%; padding: 13px 16px;
            border: 1.5px solid #f0d5d5; border-radius: 10px;
            font-size: 14px; color: #3b1a1a; outline: none;
            font-family: 'Poppins', sans-serif; background: white;
            appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23c4a0a0' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            cursor: pointer;
            margin-bottom: 20px;
            transition: border 0.2s;
        }
        .field-select:focus { border-color: #e8a0a8; }

        .jumlah-wrap { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
        .qty-btn {
            width: 36px; height: 36px; border-radius: 10px;
            border: 1.5px solid #f0d5d5; background: white;
            font-size: 18px; cursor: pointer; display: flex;
            align-items: center; justify-content: center; color: #7a4a4a;
            font-family: 'Poppins', sans-serif; transition: all 0.2s;
        }
        .qty-btn:hover { border-color: #f4a0aa; color: #e07080; }
        .qty-num { font-size: 18px; font-weight: 700; color: #3b1a1a; min-width: 24px; text-align: center; }

        .btn-konfirmasi {
            width: 100%; padding: 15px; background: #f4a0aa; color: white;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 700;
            cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.2s;
        }
        .btn-konfirmasi:hover { background: #e8858f; }

        /* MANUAL VIEW */
        .manual-view { display: none; }
        .manual-view.active { display: block; }
        .manual-label { font-size: 16px; font-weight: 700; color: #3b1a1a; margin-bottom: 12px; }
        .manual-input {
            width: 100%; padding: 16px 20px; border: 1.5px solid #f0d5d5;
            border-radius: 12px; font-size: 15px; color: #3b1a1a; outline: none;
            font-family: 'Poppins', sans-serif; text-align: center; letter-spacing: 1px;
            transition: border 0.2s; margin-bottom: 8px;
        }
        .manual-input::placeholder { color: #d4a0a0; letter-spacing: 0; }
        .manual-input:focus { border-color: #e8a0a8; }
        .manual-hint { font-size: 12.5px; color: #b4a0a0; margin-bottom: 28px; }
        .btn-verifikasi {
            width: 100%; padding: 16px; background: #f4a0aa; color: white;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 700;
            cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.2s;
        }
        .btn-verifikasi:hover { background: #e8858f; }

        /* SUCCESS PAGE */
        .success-page {
            display: none;
            min-height: 100vh;
            background: linear-gradient(160deg, #f0fff4 0%, #e8f5e9 50%, #f9fffe 100%);
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 60px 20px;
            text-align: center;
        }
        .success-page.show { display: flex; }

        .check-circle {
            width: 90px; height: 90px; border-radius: 50%;
            border: 3px solid #2ecc71; display: flex;
            align-items: center; justify-content: center;
            font-size: 40px; color: #2ecc71; margin-bottom: 28px;
        }

        .success-title { font-size: 28px; font-weight: 800; color: #3b1a1a; margin-bottom: 10px; }
        .success-desc { font-size: 14px; color: #7a6a6a; margin-bottom: 36px; }

        .koin-box {
            border: 1.5px solid #e0e0e0; border-radius: 16px;
            padding: 28px 40px; background: white;
            margin-bottom: 36px; min-width: 320px;
        }

        .koin-icon { font-size: 36px; margin-bottom: 12px; }
        .koin-title { font-size: 20px; font-weight: 800; color: #3b1a1a; margin-bottom: 6px; }
        .koin-total { font-size: 13px; color: #9a6a6a; }

        .success-buttons { display: flex; gap: 14px; }

        .btn-lihat-koin {
            padding: 14px 28px; background: #f4a0aa; color: white;
            border: none; border-radius: 50px; font-size: 14px; font-weight: 700;
            cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.2s;
            text-decoration: none;
        }
        .btn-lihat-koin:hover { background: #e8858f; }

        .btn-daur-lagi {
            padding: 14px 28px; background: white; color: #3b1a1a;
            border: 1.5px solid #e0e0e0; border-radius: 50px; font-size: 14px; font-weight: 700;
            cursor: pointer; font-family: 'Poppins', sans-serif; transition: all 0.2s;
            text-decoration: none;
        }
        .btn-daur-lagi:hover { border-color: #f4a0aa; color: #e07080; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="mainNavbar">
    <div class="nav-logo">
        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/AYU-NE.png') }}" alt="AYU-NE"></a>
    </div>
    <ul class="nav-links">
        <li><a href="{{ route('dashboard') }}">Home</a></li>
        <li><a href="{{ route('ayu-belanja') }}">Ayu Belanja</a></li>
        <li><a href="{{ route('ayu-daur-ulang') }}">Ayu Daur Ulang</a></li>
        <li><a href="{{ route('ayu-koin') }}">Ayu Koin</a></li>
    </ul>
    <div class="nav-right">
        <div class="search-box"><span>🔍</span><input type="text" placeholder="Cari produk..."></div>
        <a href="{{ route('notifikasi') }}" class="nav-icon">🔔<div class="badge">•</div></a>
        <a href="{{ route('keranjang') }}" class="nav-icon">🛒<div class="badge">2</div></a>
        <a href="{{ route('profil') }}" class="avatar">A</a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="content" id="mainContent">
    <h1>Scan & Input Kemasan</h1>

    <!-- TABS -->
    <div class="tab-wrap">
        <button class="tab-btn active" id="tabScan" onclick="switchTab('scan')">📷 Scan QR Barcode</button>
        <button class="tab-btn" id="tabManual" onclick="switchTab('manual')">✏️ Input Kode Manual</button>
    </div>

    <!-- SCAN VIEW -->
    <div class="scan-view active" id="scanView">
        <div class="scan-box-wrap">
            <div class="scan-box">
                <div class="scan-line"></div>
            </div>
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>
        </div>

        <p class="scan-hint">Arahkan kamera ke QR/barcode kemasan kosmetikmu</p>

        <button class="btn-aktifkan" onclick="aktifkanKamera()">Aktifkan Kamera</button>
        <a class="link-manual" onclick="switchTab('manual')">Tidak bisa scan? Input kode manual →</a>

        <!-- FORM KONFIRMASI -->
        <div class="form-konfirmasi" id="formKonfirmasi">
            <div class="valid-label">✅ Kode valid!</div>

            <div class="field-label">Jenis Kemasan</div>
            <select class="field-select">
                <option>Botol</option>
                <option>Tube</option>
                <option>Pump</option>
                <option>Sachet</option>
                <option>Compact</option>
                <option>Lainnya</option>
            </select>

            <div class="field-label">Jumlah</div>
            <div class="jumlah-wrap">
                <button class="qty-btn" onclick="kurangQty()">−</button>
                <span class="qty-num" id="qtyNum">1</span>
                <button class="qty-btn" onclick="tambahQty()">+</button>
            </div>

            <button class="btn-konfirmasi" onclick="konfirmasiDropOff()">Konfirmasi Drop-Off</button>
        </div>
    </div>

    <!-- MANUAL VIEW -->
    <div class="manual-view" id="manualView">
        <p class="manual-label">Masukkan Kode Unik Kemasan</p>
        <input type="text" class="manual-input" placeholder="Contoh: AYU-2026-XXXXX" maxlength="20" oninput="this.value = this.value.toUpperCase()">
        <p class="manual-hint">Kode unik ada di bagian bawah kemasan produkmu</p>
        <button class="btn-verifikasi" onclick="aktifkanKamera()">Verifikasi Kode</button>

        <!-- FORM KONFIRMASI (manual) -->
        <div class="form-konfirmasi" id="formKonfirmasiManual">
            <div class="valid-label">✅ Kode valid!</div>

            <div class="field-label">Jenis Kemasan</div>
            <select class="field-select">
                <option>Botol</option>
                <option>Tube</option>
                <option>Pump</option>
                <option>Sachet</option>
                <option>Compact</option>
                <option>Lainnya</option>
            </select>

            <div class="field-label">Jumlah</div>
            <div class="jumlah-wrap">
                <button class="qty-btn" onclick="kurangQtyM()">−</button>
                <span class="qty-num" id="qtyNumM">1</span>
                <button class="qty-btn" onclick="tambahQtyM()">+</button>
            </div>

            <button class="btn-konfirmasi" onclick="konfirmasiDropOff()">Konfirmasi Drop-Off</button>
        </div>
    </div>
</div>

<!-- SUCCESS PAGE -->
<div class="success-page" id="successPage">
    <div class="check-circle">✓</div>
    <div class="success-title">Drop-Off Berhasil! 🌿</div>
    <div class="success-desc">Terima kasih sudah berkontribusi untuk bumi yang lebih sehat.</div>

    <div class="koin-box">
        <div class="koin-icon">🪙</div>
        <div class="koin-title">+50 Ayu Koin telah ditambahkan!</div>
        <div class="koin-total">Total koin sekarang: 1250 AK</div>
    </div>

    <div class="success-buttons">
        <a href="{{ route('ayu-koin') }}" class="btn-lihat-koin">Lihat Ayu Koin Saya</a>
        <a href="{{ route('ayu-daur-ulang') }}" class="btn-daur-lagi">Daur Ulang Lagi</a>
    </div>
</div>

<script>
    function switchTab(tab) {
        const scanView    = document.getElementById('scanView');
        const manualView  = document.getElementById('manualView');
        const tabScan     = document.getElementById('tabScan');
        const tabManual   = document.getElementById('tabManual');

        if (tab === 'scan') {
            scanView.classList.add('active');
            manualView.classList.remove('active');
            tabScan.classList.add('active');
            tabManual.classList.remove('active');
        } else {
            manualView.classList.add('active');
            scanView.classList.remove('active');
            tabManual.classList.add('active');
            tabScan.classList.remove('active');
        }
    }

    function aktifkanKamera() {
        document.getElementById('formKonfirmasi').classList.add('show');
        document.getElementById('formKonfirmasiManual').classList.add('show');
    }

    // Qty scan
    function tambahQty() {
        const el = document.getElementById('qtyNum');
        el.textContent = parseInt(el.textContent) + 1;
    }
    function kurangQty() {
        const el = document.getElementById('qtyNum');
        if (parseInt(el.textContent) > 1) el.textContent = parseInt(el.textContent) - 1;
    }

    // Qty manual
    function tambahQtyM() {
        const el = document.getElementById('qtyNumM');
        el.textContent = parseInt(el.textContent) + 1;
    }
    function kurangQtyM() {
        const el = document.getElementById('qtyNumM');
        if (parseInt(el.textContent) > 1) el.textContent = parseInt(el.textContent) - 1;
    }

    function konfirmasiDropOff() {
        document.getElementById('mainNavbar').style.display = 'none';
        document.getElementById('mainContent').style.display = 'none';
        document.getElementById('successPage').classList.add('show');
    }
</script>

</body>
</html>