<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayu Belanja - AYU-NE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #fff;
            color: #3b1a1a;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 40px;
            border-bottom: 1px solid #f5e0e0;
            background: white;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-logo img {
            height: 36px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            color: #7a4a4a;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: #e07080; }

        .nav-links a.active {
            color: #e07080;
            font-weight: 700;
            border-bottom: 2px solid #e07080;
            padding-bottom: 2px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f9f0f2;
            border-radius: 50px;
            padding: 8px 16px;
            gap: 8px;
            width: 220px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: #3b1a1a;
            width: 100%;
            font-family: 'Poppins', sans-serif;
        }

        .search-box input::placeholder { color: #c4a0a0; }

        .nav-icon {
            position: relative;
            cursor: pointer;
            font-size: 20px;
            color: #7a4a4a;
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #e07080;
            color: white;
            font-size: 9px;
            font-weight: 700;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f4a0aa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            text-decoration: none;
        }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            border-bottom: 1px solid #f5e0e0;
        }

        .filter-left {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-btn {
            padding: 9px 20px;
            border-radius: 50px;
            border: 1.5px solid #f0d5d5;
            background: white;
            font-size: 13px;
            font-weight: 500;
            color: #7a4a4a;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            border-color: #f4a0aa;
            color: #e07080;
        }

        .filter-btn.active {
            background: #f4a0aa;
            color: white;
            border-color: #f4a0aa;
            font-weight: 600;
        }

        .filter-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* TOGGLE SWITCH */
        .toggle-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #7a4a4a;
            cursor: pointer;
        }

        .toggle {
            position: relative;
            width: 44px;
            height: 24px;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #f0d5d5;
            border-radius: 50px;
            transition: 0.3s;
            cursor: pointer;
        }

        .toggle-slider:before {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        .toggle input:checked + .toggle-slider {
            background: #f4a0aa;
        }

        .toggle input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }

        /* SORT DROPDOWN */
        .sort-select {
            padding: 9px 16px;
            border: 1.5px solid #f0d5d5;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #3b1a1a;
            background: white;
            cursor: pointer;
            outline: none;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 22px;
        }

        /* PRODUCT GRID */
        .product-section {
            padding: 28px 40px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .product-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #f5e0e0;
            background: white;
            transition: box-shadow 0.2s;
        }

        .product-card:hover {
            box-shadow: 0 4px 20px rgba(224,112,128,0.12);
        }

        .product-img {
            background: #fdf0f2;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #c4a0a0;
            position: relative;
        }

        .product-info {
            padding: 14px 16px 18px 16px;
        }

        .tag-verified {
            display: inline-block;
            background: #f4a0aa;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
            margin-bottom: 8px;
        }

        .product-brand {
            font-size: 10px;
            color: #9a6a6a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .product-name {
            font-size: 13.5px;
            font-weight: 700;
            color: #3b1a1a;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #3b1a1a;
            margin-bottom: 14px;
        }

        .btn-keranjang {
            width: 100%;
            padding: 10px;
            background: white;
            border: 1.5px solid #f0d5d5;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: #3b1a1a;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }

        .btn-keranjang:hover {
            background: #fce4ec;
            border-color: #f4a0aa;
        }

        /* Hidden product */
        .product-card.hidden {
            display: none;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/AYU-NE.png') }}" alt="AYU-NE">
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="{{ route('dashboard') }}">Home</a></li>
        <li><a href="#" class="active">Ayu Belanja</a></li>
        <li><a href="{{ route('ayu-daur-ulang') }}">Ayu Daur Ulang</a></li>
        <li><a href="{{ route('ayu-koin') }}">Ayu Koin</a></li>
    </ul>
    <div class="nav-right">
        <div class="search-box">
            <span>🔍</span>
            <input type="text" placeholder="Cari produk...">
        </div>
        <a href="{{ route('notifikasi') }}" class="nav-icon">🔔<div class="badge">•</div></a>
        <a href="{{ route('keranjang') }}" class="nav-icon">🛒<div class="badge">2</div></a>
        <a href="{{ route('profil') }}" class="avatar">A</a>
    </div>
</nav>

<!-- FILTER BAR -->
<div class="filter-bar">
    <div class="filter-left">
        <button class="filter-btn active" onclick="filterKategori('semua', this)">Semua</button>
        <button class="filter-btn" onclick="filterKategori('makeup', this)">Makeup</button>
        <button class="filter-btn" onclick="filterKategori('skincare', this)">Skincare</button>
        <button class="filter-btn" onclick="filterKategori('alat', this)">Alat Makeup</button>
        <button class="filter-btn" onclick="filterKategori('isulang', this)">Isi Ulang</button>
    </div>

    <div class="filter-right">
        <label class="toggle-wrap">
            <label class="toggle">
                <input type="checkbox" id="toggleVerified" onchange="filterVerified()">
                <span class="toggle-slider"></span>
            </label>
            Terverifikasi
        </label>

        <select class="sort-select" id="sortSelect" onchange="sortProduk()">
            <option value="terbaru">Terbaru</option>
            <option value="terendah">Harga Terendah</option>
            <option value="tertinggi">Harga Tertinggi</option>
            <option value="terpopuler">Terpopuler</option>
        </select>

        <div class="cart-icon nav-icon">
            🛒<div class="badge">2</div>
        </div>
    </div>
</div>

<!-- PRODUCT GRID -->
<div class="product-section">
    <div class="product-grid" id="productGrid">

        <!-- Produk 1 -->
        <div class="product-card" data-kategori="skincare" data-verified="true" data-harga="95000" data-populer="3">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Skintific</div>
                <div class="product-name">5X Ceramide Barrier Repair Moisture Gel</div>
                <div class="product-price">Rp 95.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 2 -->
        <div class="product-card" data-kategori="skincare" data-verified="true" data-harga="45000" data-populer="7">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Whitelab</div>
                <div class="product-name">Brightening Face Toner</div>
                <div class="product-price">Rp 45.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 3 -->
        <div class="product-card" data-kategori="skincare" data-verified="true" data-harga="75000" data-populer="5">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Somethinc</div>
                <div class="product-name">Holyshield Sunscreen SPF 50</div>
                <div class="product-price">Rp 75.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 4 -->
        <div class="product-card" data-kategori="skincare" data-verified="true" data-harga="55000" data-populer="6">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Npure</div>
                <div class="product-name">Cica Beauty Serum</div>
                <div class="product-price">Rp 55.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 5 -->
        <div class="product-card" data-kategori="makeup" data-verified="false" data-harga="35000" data-populer="2">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <div class="product-brand">Wardah</div>
                <div class="product-name">Instaperfect Matte Lipstick</div>
                <div class="product-price">Rp 35.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 6 -->
        <div class="product-card" data-kategori="makeup" data-verified="true" data-harga="85000" data-populer="8">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Maybelline</div>
                <div class="product-name">Fit Me Foundation</div>
                <div class="product-price">Rp 85.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 7 -->
        <div class="product-card" data-kategori="alat" data-verified="false" data-harga="25000" data-populer="1">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <div class="product-brand">Focallure</div>
                <div class="product-name">Makeup Brush Set 12pcs</div>
                <div class="product-price">Rp 25.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

        <!-- Produk 8 -->
        <div class="product-card" data-kategori="isulang" data-verified="true" data-harga="30000" data-populer="4">
            <div class="product-img">Product Photo</div>
            <div class="product-info">
                <span class="tag-verified">Terverifikasi</span>
                <div class="product-brand">Sensatia Botanicals</div>
                <div class="product-name">Rose Face Mist Refill 200ml</div>
                <div class="product-price">Rp 30.000</div>
                <a href="{{ route('detail-produk') }}" class="btn-keranjang" style="display:block; text-align:center; text-decoration:none;">Tambah Keranjang</a>
            </div>
        </div>

    </div>
</div>

<script>
    let activeKategori = 'semua';
    let onlyVerified = false;
    let activeSort = 'terbaru';

    function getAllCards() {
        return Array.from(document.querySelectorAll('.product-card'));
    }

    function applyFilter() {
        const cards = getAllCards();

        cards.forEach(card => {
            const kategori = card.dataset.kategori;
            const verified = card.dataset.verified === 'true';

            const matchKategori = activeKategori === 'semua' || kategori === activeKategori;
            const matchVerified = !onlyVerified || verified;

            card.classList.toggle('hidden', !(matchKategori && matchVerified));
        });

        applySort();
    }

    function applySort() {
        const grid = document.getElementById('productGrid');
        const cards = getAllCards();

        cards.sort((a, b) => {
            if (activeSort === 'terendah') {
                return parseInt(a.dataset.harga) - parseInt(b.dataset.harga);
            } else if (activeSort === 'tertinggi') {
                return parseInt(b.dataset.harga) - parseInt(a.dataset.harga);
            } else if (activeSort === 'terpopuler') {
                return parseInt(b.dataset.populer) - parseInt(a.dataset.populer);
            }
            return 0; // terbaru = urutan default
        });

        cards.forEach(card => grid.appendChild(card));
    }

    function filterKategori(kategori, btn) {
        activeKategori = kategori;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        applyFilter();
    }

    function filterVerified() {
        onlyVerified = document.getElementById('toggleVerified').checked;
        applyFilter();
    }

    function sortProduk() {
        activeSort = document.getElementById('sortSelect').value;
        applyFilter();
    }
</script>

</body>
</html>