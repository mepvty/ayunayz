<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'ayune_orders';

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'alamat_pengiriman',
        'metode_pengiriman',
        'total_harga',
        'koin_digunakan',
        'diskon',
        'total_bayar',
        'bukti_pembayaran',
        'catatan',
        'status',
        'snap_token',        // Token Midtrans Snap
        'midtrans_order_id', // Order ID yang dikirim ke Midtrans
    ];

    // RELASI
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderItems()
    {
        // FIX: harusnya hasMany bukan belongsTo
        // Satu order punya banyak item
        return $this->hasMany(OrderItem::class);
    }
}
