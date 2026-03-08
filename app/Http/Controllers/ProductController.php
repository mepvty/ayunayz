<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function landing(){
        $produkTerbaru = Product::with('user')
            ->where('status','tersedia')
            ->latest()
            ->take(8)
            ->get();

        //ambil 8 produk terbaru yg masi tersedida
        //with user ambil data penjualny jg
        
        return view('welcome', compact('produkTerbaru'));
        //kirm ke welcomeblade
    }
}
