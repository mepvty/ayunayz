<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lokasi Drop-Off - AYU-NE</title>
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

        /* CONTENT */
        .content {
            padding: 36px 40px;
        }

        h1 {
            font-size: 26px;
            font-weight: 800;
            color: #3b1a1a;
            margin-bottom: 20px;
        }

        /* TAB BUTTONS */
        .tab-wrap {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }

        .tab-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 50px;
            border: 1.5px solid #f0d5d5;
            background: white;
            font-size: 14px;
            font-weight: 500;
            color: #7a4a4a;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: #f4a0aa;
            color: white;
            border-color: #f4a0aa;
            font-weight: 600;
        }

        .tab-btn:hover:not(.active) {
            border-color: #f4a0aa;
            color: #e07080;
        }

        /* SEARCH BAR */
        .search-location {
            width: 100%;
            padding: 14px 20px;
            border: 1.5px solid #f0d5d5;
            border-radius: 12px;
            font-size: 14px;
            color: #3b1a1a;
            outline: none;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 28px;
            transition: border 0.2s;
        }

        .search-location::placeholder { color: #c4a0a0; }
        .search-location:focus { border-color: #e8a0a8; }

        /* MAP VIEW */
        .map-view { display: none; }
        .map-view.active { display: block; }

        .map-box {
            width: 100%;
            height: 400px;
            background: #fdf0f2;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #c4a0a0;
            margin-bottom: 16px;
        }

        .map-legend {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #7a4a4a;
        }

        .legend-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        /* LIST VIEW */
        .list-view { display: none; }
        .list-view.active { display: block; }

        .location-card {
            display: flex;
            gap: 20px;
            padding: 24px;
            border: 1px solid #f5e0e0;
            border-radius: 16px;
            margin-bottom: 16px;
            align-items: flex-start;
            transition: box-shadow 0.2s;
        }

        .location-card:hover {
            box-shadow: 0 4px 16px rgba(224,112,128,0.08);
        }

        .location-photo {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: #fdf0f2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #c4a0a0;
            text-align: center;
            flex-shrink: 0;
            line-height: 1.4;
        }

        .location-info {
            flex: 1;
        }

        .location-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .location-name-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .location-name {
            font-size: 16px;
            font-weight: 700;
            color: #3b1a1a;
        }

        .tag-terdekat {
            background: #2ecc71;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .location-distance {
            font-size: 13px;
            font-weight: 600;
            color: #e07080;
        }

        .location-address {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #7a4a4a;
            margin-bottom: 6px;
        }

        .location-jam {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #7a4a4a;
            margin-bottom: 12px;
        }

        .kemasan-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .kemasan-tag {
            padding: 4px 12px;
            border: 1px solid #f0d5d5;
            border-radius: 50px;
            font-size: 12px;
            color: #7a4a4a;
        }

        .btn-pilih {
            padding: 10px 24px;
            border: 1.5px solid #f0d5d5;
            border-radius: 50px;
            background: white;
            font-size: 13px;
            font-weight: 600;
            color: #3b1a1a;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }

        .btn-pilih:hover {
            background: #fce4ec;
            border-color: #f4a0aa;
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
        <li><a href="{{ route('ayu-belanja') }}">Ayu Belanja</a></li>
        <li><a href="{{ route('ayu-daur-ulang') }}">Ayu Daur Ulang</a></li>
        <li><a href="{{ route('ayu-koin') }}">Ayu Koin</a></li>
    </ul>
    <div class="nav-right">
        <div class="search-box">
            <span>🔍</span>
            <input type="text" placeholder="Cari produk...">
        </div>
        <div class="nav-icon">🔔<div class="badge">•</div></div>
        <div class="nav-icon">🛒<div class="badge">2</div></div>
        <a href="{{ route('profil') }}" class="avatar">A</a>
    </div>
</nav>

<!-- CONTENT -->
<div class="content">
    <h1>Pilih Lokasi Drop-Off</h1>

    <!-- TABS -->
    <div class="tab-wrap">
        <button class="tab-btn" id="tabPeta" onclick="switchTab('peta')">🗺️ Peta</button>
        <button class="tab-btn active" id="tabDaftar" onclick="switchTab('daftar')">☰ Daftar</button>
    </div>

    <!-- SEARCH -->
    <input type="text" class="search-location" placeholder="Cari lokasi drop-off..." oninput="searchLokasi(this.value)">

    <!-- MAP VIEW -->
    <div class="map-view" id="mapView">
        <div class="map-box">
            Google Maps — Drop-Off Locations Map
        </div>
        <div class="map-legend">
            <div class="legend-item">
                <div class="legend-dot" style="background: #f4a0aa;"></div>
                Titik Drop-Off AYU-NE
            </div>
            <div class="legend-item">
                <div class="legend-dot" style="background: #3498db;"></div>
                Lokasi Kamu
            </div>
        </div>
    </div>

    <!-- LIST VIEW -->
    <div class="list-view active" id="listView">

        <!-- Lokasi 1 -->
        <div class="location-card" data-name="alfamart sudirman">
            <div class="location-photo">Partner<br>Location<br>Photo</div>
            <div class="location-info">
                <div class="location-top">
                    <div class="location-name-wrap">
                        <span class="location-name">Alfamart Sudirman</span>
                        <span class="tag-terdekat">Terdekat</span>
                    </div>
                    <span class="location-distance">0.5 km</span>
                </div>
                <div class="location-address">📍 Jl. Jend. Sudirman No. 45, Jakarta Pusat</div>
                <div class="location-jam">🕐 08:00 - 22:00</div>
                <div class="kemasan-tags">
                    <span class="kemasan-tag">Botol</span>
                    <span class="kemasan-tag">Tube</span>
                    <span class="kemasan-tag">Sachet</span>
                    <span class="kemasan-tag">Pump</span>
                </div>
                <a href="{{ route('scan-kemasan') }}" class="btn-pilih" style="text-decoration:none; display:inline-block;">Pilih Lokasi Ini</a>
            </div>
        </div>

        <!-- Lokasi 2 -->
        <div class="location-card" data-name="indomaret thamrin">
            <div class="location-photo">Partner<br>Location<br>Photo</div>
            <div class="location-info">
                <div class="location-top">
                    <div class="location-name-wrap">
                        <span class="location-name">Indomaret Thamrin</span>
                    </div>
                    <span class="location-distance">1.2 km</span>
                </div>
                <div class="location-address">📍 Jl. M.H. Thamrin No. 12, Jakarta Pusat</div>
                <div class="location-jam">🕐 24 Jam</div>
                <div class="kemasan-tags">
                    <span class="kemasan-tag">Botol</span>
                    <span class="kemasan-tag">Tube</span>
                    <span class="kemasan-tag">Pump</span>
                </div>
                <button class="btn-pilih">Pilih Lokasi Ini</button>
            </div>
        </div>

        <!-- Lokasi 3 -->
        <div class="location-card" data-name="guardian grand indonesia">
            <div class="location-photo">Partner<br>Location<br>Photo</div>
            <div class="location-info">
                <div class="location-top">
                    <div class="location-name-wrap">
                        <span class="location-name">Guardian Grand Indonesia</span>
                    </div>
                    <span class="location-distance">2.1 km</span>
                </div>
                <div class="location-address">📍 Jl. M.H. Thamrin No. 1, Jakarta Pusat</div>
                <div class="location-jam">🕐 10:00 - 22:00</div>
                <div class="kemasan-tags">
                    <span class="kemasan-tag">Botol</span>
                    <span class="kemasan-tag">Tube</span>
                    <span class="kemasan-tag">Sachet</span>
                    <span class="kemasan-tag">Compact</span>
                    <span class="kemasan-tag">Palette</span>
                </div>
                <button class="btn-pilih">Pilih Lokasi Ini</button>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        const mapView  = document.getElementById('mapView');
        const listView = document.getElementById('listView');
        const tabPeta  = document.getElementById('tabPeta');
        const tabDaftar = document.getElementById('tabDaftar');

        if (tab === 'peta') {
            mapView.classList.add('active');
            listView.classList.remove('active');
            tabPeta.classList.add('active');
            tabDaftar.classList.remove('active');
        } else {
            listView.classList.add('active');
            mapView.classList.remove('active');
            tabDaftar.classList.add('active');
            tabPeta.classList.remove('active');
        }
    }

    function searchLokasi(keyword) {
        const cards = document.querySelectorAll('.location-card');
        const lower = keyword.toLowerCase();
        cards.forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(lower) ? 'flex' : 'none';
        });
    }
</script>

</body>
</html>