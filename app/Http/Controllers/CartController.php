<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Tampilkan isi keranjang belanja milik user yang sedang login.
     */
    public function index()
    {
        $cartItems = Cart::with(['product', 'seller'])
            ->where('user_id', auth()->id())
            ->get();

        // Hitung subtotal dari harga semua produk di keranjang
        $subtotal = $cartItems->sum(fn($item) => $item->product->harga ?? 0);

        return view('keranjang', compact('cartItems', 'subtotal'));
    }

    /**
     * Tambah produk ke keranjang.
     * Dipanggil dari halaman detail produk (POST /keranjang/tambah/{productId})
     */
    public function store($productId)
    {
        $product = Product::findOrFail($productId);

        // Tidak bisa beli produk sendiri
        if ($product->user_id === auth()->id()) {
            return back()->with('error', 'Tidak bisa membeli produk milik sendiri!');
        }

        // Cek apakah produk sudah ada di keranjang
        $sudahAda = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->exists();

        if ($sudahAda) {
            return back()->with('info', 'Produk sudah ada di keranjang!');
        }

        Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $productId,
            'seller_id'  => $product->user_id,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Hapus satu item dari keranjang.
     * Dipanggil dari halaman keranjang (DELETE /keranjang/{id})
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id()) // pastikan hanya bisa hapus milik sendiri
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Kosongkan seluruh keranjang (dipanggil setelah pembayaran berhasil).
     */
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return response()->json(['message' => 'Keranjang dikosongkan']);
    }
}
