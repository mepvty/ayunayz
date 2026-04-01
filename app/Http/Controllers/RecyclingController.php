<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DropBox;
use App\Models\RecyclingSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\DaurUlang;

class RecyclingController extends Controller
{
    // Halaman upload foto
    public function index()
    {
        return view('scan-kemasan');
    }

    // Simpan foto kemasan
    public function uploadFoto(Request $request)
{
    $request->validate([
        'foto_kemasan'   => 'required|array|min:1',
        'foto_kemasan.*' => 'image|mimes:jpg,jpeg,png|max:5048',
    ]);

    $paths = [];
    foreach ($request->file('foto_kemasan') as $foto) {
        $paths[] = $foto->store('kemasan', 'public');
    }

    session(['foto_kemasan' => json_encode($paths)]);
    session()->save(); // ← tetap ada ini

    return redirect()->route('scan-qr');
}
    // Halaman scan QR
    public function scanQR()
    {
        return view('scan-qr');
    }

    // Proses QR / kode manual
    public function prosesQR(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string',
    ]);

    $dropBox = DropBox::where('qr_code', $request->qr_code)
                      ->where('aktif', true)
                      ->first();

    if (!$dropBox) {
        return back()->withErrors(['qr_code' => 'Kode tidak valid atau drop box tidak aktif!']);
    }

    $fotoKemasan = session('foto_kemasan');

    $submission = RecyclingSubmission::create([
        'user_id'        => Auth::id(),
        'drop_box_id'    => $dropBox->id,
        'foto_kemasan'   => $fotoKemasan,
        'status'         => 'confirmed',
        'koin_diberikan' => 10,
    ]);

    // Simpan ke tabel daur_ulang untuk riwayat
    // foto_kemasan disimpen json, ambil foto pertama buat ditampilin di riwayat
    $fotoArray = json_decode($fotoKemasan, true);
    DaurUlang::create([
        'user_id'      => Auth::id(),
        'foto_kemasan' => $fotoArray[0] ?? '',
        'qr_code'      => $request->qr_code,
        'koin'         => 10,
    ]);

    Auth::user()->increment('ayu_koin', 10);

    session()->forget('foto_kemasan');

    return redirect()->route('daur-ulang-sukses')->with('koin', 10);
}
    // Halaman sukses
    public function sukses()
    {
        return view('daur-ulang-sukses');
    }
}