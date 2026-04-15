<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // ─────────────────────────────────────────────────
    // Konfigurasi Midtrans (dipake di beberapa method)
    // ─────────────────────────────────────────────────
    private function setupMidtrans()
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction  = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized   = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds         = config('midtrans.is_3ds');

        // SSL bypass untuk environment development Windows/XAMPP
        // CURLOPT_HTTPHEADER (nilai 10023) wajib ada agar SDK tidak error
        if (!config('midtrans.is_production')) {
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER     => [],
            ];
        }
    }

    // ─────────────────────────────────────────────────
    // GET /checkout — Halaman checkout
    // Kirim data cart nyata ke view (view boleh tetap pakai hardcoded)
    // ─────────────────────────────────────────────────
    public function checkout()
    {
        $cartItems = Cart::with(['product', 'seller'])
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->product->harga ?? 0);

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    // ─────────────────────────────────────────────────
    // POST /checkout/process — Generate Snap Token & Simpan Order ke DB
    // ─────────────────────────────────────────────────
    public function process(Request $request)
    {
        $request->validate([
            'subtotal' => 'required|numeric',
            'ongkir'   => 'required|numeric',
            'total'    => 'required|numeric',
        ]);

        // Ambil cart items dari DB
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        // Gunakan data dari cart jika ada, fallback ke data form jika cart kosong
        $totalBayar = $cartItems->isNotEmpty()
            ? $cartItems->sum(fn($i) => $i->product->harga ?? 0) + $request->ongkir
            : (int) $request->total;

        $sellerId = $cartItems->isNotEmpty() ? $cartItems->first()->seller_id : auth()->id();

        // Ambil data alamat dari request (boleh kosong, pakai default jika belum ada di form)
        $alamat           = $request->input('alamat', '-');
        $metodePengiriman = $request->input('metode_pengiriman', 'JNE REG');

        // ── Simpan Order ke DB ──────────────────────
        $order = Order::create([
            'buyer_id'          => auth()->id(),
            'seller_id'         => $sellerId,
            'alamat_pengiriman' => $alamat,
            'metode_pengiriman' => $metodePengiriman,
            'total_harga'       => (int) $request->subtotal,
            'koin_digunakan'    => 0,
            'diskon'            => 0,
            'total_bayar'       => $totalBayar,
            'catatan'           => $request->input('catatan'),
            'status'            => 'menunggu_pembayaran',
        ]);

        // ── Simpan Order Items dari Cart ────────────
        if ($cartItems->isNotEmpty()) {
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'seller_id'  => $item->seller_id,
                    'harga'      => $item->product->harga ?? 0,
                ]);
            }
        }

        // ── Generate Midtrans Snap Token ────────────
        $this->setupMidtrans();

        $midtransOrderId = 'ORDER-' . $order->id;

        $params = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => (int) $totalBayar,
            ],
            'customer_details' => [
                'first_name' => auth()->check() ? auth()->user()->name : 'Guest',
                'email'      => auth()->check() ? auth()->user()->email : 'guest@example.com',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan token dan midtrans order ID ke record order
            $order->update([
                'snap_token'        => $snapToken,
                'midtrans_order_id' => $midtransOrderId,
            ]);

            return response()->json([
                'token'    => $snapToken,
                'order_id' => $order->id,
            ]);

        } catch (\Exception $e) {
            // Hapus order dari DB jika gagal generate token
            $order->orderItems()->delete();
            $order->delete();

            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────
    // GET /pesanan-saya — Daftar semua pesanan user
    // ─────────────────────────────────────────────────
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('buyer_id', auth()->id())
            ->latest()
            ->get();

        return view('pesanan-saya', compact('orders'));
    }

    // ─────────────────────────────────────────────────
    // GET /detail-pesanan/{id} — Detail satu pesanan
    // ─────────────────────────────────────────────────
    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'seller'])
            ->where('buyer_id', auth()->id())
            ->findOrFail($id);

        return view('detail-pesanan', compact('order'));
    }

    // ─────────────────────────────────────────────────
    // POST /midtrans/notification — Webhook dari Midtrans
    // Midtrans memanggil endpoint ini setiap kali status pembayaran berubah
    // ─────────────────────────────────────────────────
    public function notification(Request $request)
    {
        $this->setupMidtrans();

        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;
            $orderId           = $notification->order_id; // format: ORDER-{id}

            // Cari order berdasarkan midtrans_order_id
            $order = Order::where('midtrans_order_id', $orderId)->first();

            if (!$order) {
                Log::warning('Midtrans notification: order not found for ' . $orderId);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update status order berdasarkan status dari Midtrans
            if ($transactionStatus == 'capture') {
                // Pembayaran kartu kredit
                $order->update([
                    'status' => ($fraudStatus == 'accept') ? 'dibayar' : 'dibatalkan',
                ]);
            } elseif ($transactionStatus == 'settlement') {
                // Pembayaran bank transfer / QR / VA sudah selesai
                $order->update(['status' => 'dibayar']);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'dibatalkan']);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['status' => 'menunggu_pembayaran']);
            }

            Log::info("Midtrans notification: order {$orderId} → {$transactionStatus}");
            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
