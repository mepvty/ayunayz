<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DropoffLocation;

class DropOffLocationController extends Controller
{
    /**
     * Tampilkan semua lokasi drop-off yang masih aktif.
     */
    public function index()
    {
        $lokasi = DropoffLocation::where('is_active', true)
            ->orderBy('kota')
            ->get();

        return view('dropoff-lokasi', compact('lokasi'));
    }
}
