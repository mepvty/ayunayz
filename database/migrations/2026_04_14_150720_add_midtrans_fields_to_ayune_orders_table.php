<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ayune_orders', function (Blueprint $table) {
            // Snap Token dari Midtrans untuk popup pembayaran
            $table->string('snap_token')->nullable()->after('status');
            // Order ID yang dikirim ke Midtrans (format: ORDER-{id})
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            // Bukti pembayaran (ada di model fillable tapi belum di DB)
            $table->string('bukti_pembayaran')->nullable()->after('midtrans_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('ayune_orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id', 'bukti_pembayaran']);
        });
    }
};
