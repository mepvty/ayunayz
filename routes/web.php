<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecyclingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\DropOffLocationController;

// ─────────────────────────────────────────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
});

// ─── Midtrans Notification Webhook ───────────────────────────────────────────
// WAJIB di luar middleware CSRF — Midtrans tidak mengirim CSRF token
Route::post('/midtrans/notification', [OrderController::class, 'notification'])
    ->name('midtrans.notification');

// ─────────────────────────────────────────────────────────────────────────────
// AUTH ROUTES
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ── Profile ──────────────────────────────────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil', function () {
        return view('profile.index');
    })->name('profil');

    // ── Belanja ──────────────────────────────────────────────────────────────
    Route::get('/ayu-belanja', function () {
        return view('ayu-belanja');
    })->name('ayu-belanja');

    Route::get('/detail-produk', function () {
        return view('detail-produk');
    })->name('detail-produk');

    // ── Keranjang ─────────────────────────────────────────────────────────────
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah/{productId}', [CartController::class, 'store'])->name('keranjang.tambah');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('keranjang.hapus');
    Route::post('/keranjang/clear', [CartController::class, 'clear'])->name('keranjang.clear');

    // ── Checkout & Order ──────────────────────────────────────────────────────
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [OrderController::class, 'process'])->name('checkout.process');
    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('pesanan-saya');
    Route::get('/detail-pesanan/{id}', [OrderController::class, 'show'])->name('detail-pesanan');

    // ── Halaman statis pesanan ────────────────────────────────────────────────
    Route::get('/pesanan-berhasil', function () {
        return view('pesanan-berhasil');
    })->name('pesanan-berhasil');

    Route::get('/lacak-pesanan', function () {
        return view('lacak-pesanan');
    })->name('lacak-pesanan');

    // ── AYU Koin ─────────────────────────────────────────────────────────────
    Route::get('/ayu-koin', [CoinController::class, 'index'])->name('ayu-koin');

    // ── Drop-Off Lokasi ───────────────────────────────────────────────────────
    Route::get('/dropoff-lokasi', [DropOffLocationController::class, 'index'])->name('dropoff-lokasi');

    // ── Notifikasi ────────────────────────────────────────────────────────────
    Route::get('/notifikasi', function () {
        return view('notifikasi');
    })->name('notifikasi');

    // ── Chat ──────────────────────────────────────────────────────────────────
    Route::get('/chat-penjual', function () {
        return view('chat-penjual');
    })->name('chat-penjual');

    // ── Daur Ulang ────────────────────────────────────────────────────────────
    Route::get('/ayu-daur-ulang', function () {
        return view('ayu-daur-ulang');
    })->name('ayu-daur-ulang');

    Route::get('/scan-kemasan', [RecyclingController::class, 'index'])->name('scan-kemasan');
    Route::post('/scan-kemasan/upload', [RecyclingController::class, 'uploadFoto'])->name('upload-foto');
    Route::get('/scan-qr', [RecyclingController::class, 'scanQR'])->name('scan-qr');
    Route::post('/scan-qr/proses', [RecyclingController::class, 'prosesQR'])->name('proses-qr');
    Route::get('/daur-ulang-sukses', [RecyclingController::class, 'sukses'])->name('daur-ulang-sukses');
});

require __DIR__.'/auth.php';
