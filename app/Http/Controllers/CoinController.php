<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\CoinHistory;

class CoinController extends Controller
{
    /**
     * Tampilkan halaman AYU Koin dengan saldo dan riwayat transaksi koin.
     */
    public function index()
    {
        // Ambil saldo koin user saat ini
        $coin = Coin::where('user_id', auth()->id())->first();

        // Ambil 20 riwayat transaksi koin terbaru
        $riwayat = CoinHistory::where('user_id', auth()->id())
            ->latest()
            ->take(20)
            ->get();

        return view('ayu-koin', compact('coin', 'riwayat'));
    }
}
