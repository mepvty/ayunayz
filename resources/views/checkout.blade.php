<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - AYU-NE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #fff; color: #3b1a1a; }

          .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            border-bottom: 1px solid #f5e0e0;
            background: white;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-logo img { height: 36px; width: auto; object-fit: contain; }
        .nav-links { display: flex; gap: 36px; list-style: none; }
        .nav-links a { text-decoration: none; font-size: 14px; font-weight: 500; color: #7a4a4a; }
        .nav-links a:hover { color: #e07080; }
        .nav-right { display: flex; align-items: center; gap: 18px; }
        .search-box { display: flex; align-items: center; background: #f9f0f2; border-radius: 50px; padding: 1px 16px; gap: 8px; width: 220px; }
        .search-box input { border: none; background: transparent; outline: none; font-size: 13px; width: 100%; font-family: 'Poppins', sans-serif; }
        .search-box input::placeholder { color: #c4a0a0; }
        .nav-icon { position: relative; cursor: pointer; font-size: 20px; color: #7a4a4a; text-decoration: none; }
        .badge { position: absolute; top: -6px; right: -6px; background: #e07080; color: white; font-size: 9px; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f4a0aa; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: white; text-decoration: none; }

        /* CONTENT */
        .content { padding: 36px 40px; display: flex; gap: 28px; align-items: flex-start; }

        /* LEFT */
        .checkout-left { flex: 1; display: flex; flex-direction: column; gap: 20px; }

        h1 { font-size: 22px; font-weight: 800; color: #3b1a1a; margin-bottom: 4px; }

        .section-box {
            border: 1px solid #f5e0e0; border-radius: 16px; padding: 24px;
        }

        .section-title { font-size: 15px; font-weight: 700; color: #3b1a1a; margin-bottom: 18px; }

        label { display: block; font-size: 12.5px; font-weight: 600; color: #3b1a1a; margin-bottom: 6px; }

        input[type="text"], textarea {
            width: 100%; padding: 12px 16px; border: 1.5px solid #f0d5d5;
            border-radius: 10px; font-size: 13px; color: #3b1a1a;
            outline: none; font-family: 'Poppins', sans-serif;
            transition: border 0.2s; margin-bottom: 14px;
        }

        input::placeholder, textarea::placeholder { color: #d4a0a0; }
        input:focus, textarea:focus { border-color: #e8a0a8; }

        textarea { resize: vertical; min-height: 80px; }

        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* PENGIRIMAN */
        .kurir-option {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 18px; border: 1.5px solid #f0d5d5; border-radius: 12px;
            margin-bottom: 10px; cursor: pointer; transition: all 0.2s;
        }

        .kurir-option:hover { border-color: #f4a0aa; background: #fff5f6; }
        .kurir-option.selected { border-color: #f4a0aa; background: #fff5f6; }

        .kurir-left { display: flex; align-items: center; gap: 12px; }

        .radio-circle {
            width: 18px; height: 18px; border-radius: 50%; border: 2px solid #f0d5d5;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .radio-circle.checked { border-color: #e07080; background: #e07080; }
        .radio-circle.checked::after { content: ''; width: 7px; height: 7px; background: white; border-radius: 50%; }

        .kurir-name { font-size: 14px; font-weight: 700; color: #3b1a1a; }
        .kurir-hari { font-size: 12px; color: #9a6a6a; }
        .kurir-harga { font-size: 14px; font-weight: 600; color: #3b1a1a; }

        /* RIGHT: SUMMARY */
        .checkout-right { width: 300px; flex-shrink: 0; }

        .summary-box { border: 1px solid #f5e0e0; border-radius: 16px; padding: 24px; }
        .summary-title { font-size: 16px; font-weight: 700; margin-bottom: 18px; }

        .summary-item {
            display: flex; justify-content: space-between;
            font-size: 13px; color: #7a4a4a; margin-bottom: 10px;
        }

        .summary-item span:last-child { font-weight: 600; color: #3b1a1a; }

        hr { border: none; border-top: 1px solid #f5e0e0; margin: 14px 0; }

        .summary-total {
            display: flex; justify-content: space-between;
            font-size: 16px; font-weight: 800; color: #3b1a1a; margin-bottom: 20px;
        }

        .btn-pesan {
            width: 100%; padding: 14px; background: #f4a0aa; color: white;
            border: none; border-radius: 50px; font-size: 15px; font-weight: 700;
            cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.2s;
        }

        .btn-pesan:hover { background: #e8858f; }
    </style>
</head>
<body>

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
        <div class="search-box"><span>🔍</span><input type="text" placeholder="Cari produk..."></div>
        <a href="{{ route('notifikasi') }}" class="nav-icon">🔔<div class="badge">•</div></a>
        <a href="{{ route('keranjang') }}" class="nav-icon">🛒<div class="badge">2</div></a>
        <a href="{{ route('profil') }}" class="avatar">A</a>
    </div>
</nav>

<div class="content">
    <!-- LEFT -->
    <div class="checkout-left">
        <h1>Checkout</h1>

        <!-- Alamat Pengiriman -->
        <div class="section-box">
            <div class="section-title">Alamat Pengiriman</div>
            <label>Nama</label>
            <input type="text" placeholder="Nama lengkap">
            <label>No HP</label>
            <input type="text" placeholder="08xxxxxxxxxx">
            <label>Alamat Lengkap</label>
            <textarea placeholder="Jalan, nomor rumah, RT/RW"></textarea>
            <div class="row-2">
                <div>
                    <label>Kota</label>
                    <input type="text" placeholder="Jakarta" style="margin-bottom:0;">
                </div>
                <div>
                    <label>Kode Pos</label>
                    <input type="text" placeholder="12345" style="margin-bottom:0;">
                </div>
            </div>
        </div>

        <!-- Jasa Pengiriman -->
        <div class="section-box">
            <div class="section-title">Jasa Pengiriman</div>

            <div class="kurir-option selected" onclick="pilihKurir(this, 15000)">
                <div class="kurir-left">
                    <div class="radio-circle checked" id="radio1"></div>
                    <div>
                        <div class="kurir-name">JNE REG</div>
                        <div class="kurir-hari">2-3 hari</div>
                    </div>
                </div>
                <div class="kurir-harga">Rp 15.000</div>
            </div>

            <div class="kurir-option" onclick="pilihKurir(this, 12000)">
                <div class="kurir-left">
                    <div class="radio-circle" id="radio2"></div>
                    <div>
                        <div class="kurir-name">J&T Express</div>
                        <div class="kurir-hari">2-4 hari</div>
                    </div>
                </div>
                <div class="kurir-harga">Rp 12.000</div>
            </div>

            <div class="kurir-option" onclick="pilihKurir(this, 18000)">
                <div class="kurir-left">
                    <div class="radio-circle" id="radio3"></div>
                    <div>
                        <div class="kurir-name">SiCepat REG</div>
                        <div class="kurir-hari">1-2 hari</div>
                    </div>
                </div>
                <div class="kurir-harga">Rp 18.000</div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="checkout-right">
        <div class="summary-box">
            <div class="summary-title">Ringkasan Pesanan</div>
            <div class="summary-item">
                <span>5X Ceramide Barrier...</span>
                <span>Rp 95.000</span>
            </div>
            <div class="summary-item">
                <span>Holyshield Sunscreen...</span>
                <span>Rp 75.000</span>
            </div>
            <hr>
            <div class="summary-item">
                <span>Subtotal</span>
                <span>Rp 170.000</span>
            </div>
            <div class="summary-item">
                <span>Ongkir</span>
                <span id="ongkirVal">Rp 15.000</span>
            </div>
            <hr>
            <div class="summary-total">
                <span>Total</span>
                <span id="totalVal">Rp 185.000</span>
            </div>
            <button id="pay-button" class="btn-pesan" style="display:block; text-align:center; width:100%;">Buat Pesanan</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    let ongkir = 15000;
    const subtotal = 170000;

    function formatRp(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function pilihKurir(el, harga) {
        document.querySelectorAll('.kurir-option').forEach(k => {
            k.classList.remove('selected');
            k.querySelector('.radio-circle').classList.remove('checked');
        });
        el.classList.add('selected');
        el.querySelector('.radio-circle').classList.add('checked');
        ongkir = harga;
        document.getElementById('ongkirVal').textContent = formatRp(ongkir);
        document.getElementById('totalVal').textContent = formatRp(subtotal + ongkir);
    }

    // Midtrans Snap Payment
    document.getElementById('pay-button').onclick = function () {
        const total = subtotal + ongkir;

        fetch('{{ route("checkout.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                subtotal: subtotal,
                ongkir: ongkir,
                total: total
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                window.snap.pay(data.token, {
                    onSuccess: function(result){
                        window.location.href = "{{ route('pesanan-berhasil') }}";
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran!");
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            } else {
                alert('Gagal mendapatkan token: ' + (data.error || 'Unknown Error'));
                console.error(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pembayaran.');
        });
    };
</script>

</body>
</html>