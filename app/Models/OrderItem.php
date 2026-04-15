<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // FIX: nama tabel seharusnya ayune_order_items (tanpa _ di akhir)
    protected $table = 'ayune_order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'harga',
    ];

    // RELASI
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
