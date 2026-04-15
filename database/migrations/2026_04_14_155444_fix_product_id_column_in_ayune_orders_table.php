<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ayune_orders', function (Blueprint $table) {
            // Kolom product_id ada di DB tapi tidak seharusnya di tabel orders
            // (produk disimpan di ayune_order_items, bukan di orders langsung)
            // Jadikan nullable dulu agar tidak crash saat insert order baru
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ayune_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
};
