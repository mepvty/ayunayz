<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RecyclingController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\DropOffLocationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

//halaman public !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//kl slash doang tampilin welcome, kl kita tr makenya landing page
Route::get('/', [ProductController::class, 'landing'])
    ->name('landing');

//hlman product!!! list produk
Route::get('/produk', [ProductController::class, 'index'])
    ->name('produk.index');

//hlmn detail produk
Route::get('/produk/{id}', [ProductController::class, 'show'])
    ->name('produk.show');

//hlmn drop off lokasi
Route::get('/lokasi-dropoff', [DropOffLocationController::class, 'index'])
    ->name('lokasi-dropoff.index');


//hal loginn butuh middleware!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//bwat midle ware mangggil grup funkzi
Route::middleware(['auth', 'verified'])->group(function() {
    
    //hal dashboardd
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    //hal profile
    //edit
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    //update
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    //delete
    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

    //hal produk
    //jual produk or upload
    Route::get('/produk/jual', [ProductController::class, 'create'])
    ->name('product.create');
    //simpen produk
    Route::post('/produk', [ProductController::class, 'store'])
    ->name('produk.store');
    //apus
    Route::delete('/produk/{id}', [ProductController::class, 'destroy'])
    ->name('produk.destroy');

    //hal krnjang MAU BOBOKKKKK
    //ini buat liat keranjnag kan?
    Route::get('/keranjang', [CartController::class, 'index'])
    ->name('keranjang.index');
    //simpen keranjank
    Route::post('/keranjang', [CartController::class, 'store'])
    ->name('keranjang.store');
    //bom keranjnag
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])
    ->name('keranjang.destroy');

    //hal order pesan shibaw
    //ini buat liat pesanan ad p je
    Route::get('/pesanan', [OrderController::class, 'index'])
    ->name('pesanan.index');
    //ini buat nyimpen d p aj
    Route::post('/pesanan', [OrderController::class, 'store'])
    ->name('pesanan.store');
    //ini buat liat detil pesanan nyh
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])
    ->name('pesanan.show');
    //ni update pesanan kau ynk linglung
    Route::patch('/pesanan/{id}', [OrderController::class, 'update'])
    ->name('pesanan.update');

    //RECYCLE BYCICLE HAHH
    //liat daur ulank kau ada kau tdk
    Route::get('/daur-ulang', [RecyclingController::class, 'index'])
    ->name('daur-ulang.index');
    //daur ulang form BUAT APE NI????
    Route::get('/daur-ulang/form', [RecyclingController::class, 'create'])
    ->name('daur-ulang.create');
    //simpen
    Route::post('/daur-ulang', [RecyclingController::class, 'store'])
    ->name('daur-ulang.store');
    //scan shibaw
    Route::post('/daur-ulang/scan', [RecyclingController::class, 'scan'])
    ->name('daur-ulang.scan');

    //halanman koinzz
    //liat koin elu
    Route::get('/koin', [CoinController::class, 'index'])
    ->name('koin.index');

});

//halamn adminzzzzzzzzzzzz !!!!!!!!!!!!!!!!!!!!!!!!
Route::middleware(['auth'])->prefix('admin')->group(function() {

    //dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard');
    //liat dropoff
    Route::get('/lokasi-dropoff', [AdminController::class, 'dropoffIndex'])
    ->name('admin.dropoff.index');
    //simpen
    Route::post('/lokasi-dropoff', [AdminController::class, 'dropoffStore'])
    ->name('admin.dropoff.store');
    //update
    Route::get('/lokasi-dropoff', [AdminController::class, 'konfirmasiDaurUlang'])
    ->name('admin.daur-ulang.konfirmasi');

});

//API INTERNAL INTEGRATION KOIN !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
Route::prefix('api')->group(function(){
    
    //tambah koin
    Route::post('/koin/tambah', [CoinController::class, 'tambahKoin'])
    ->name('api.koin.tambah');
    //kurangi ckoin
    Route::post('/koin/kurang', [CoinController::class, 'kurangKoin'])
    ->name('api.koin.kurang');
    //zek zaldo
    Route::get('/koin/{user_id}', [CoinController::class, 'cekSaldo'])
    ->name('api.koin.saldo');
});


require __DIR__.'/auth.php';
