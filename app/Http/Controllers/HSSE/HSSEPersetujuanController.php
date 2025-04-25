<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class HSSEPersetujuanController extends Controller
{
    public function viewPersetujuan(request $request)
    {

        // Mengambil data laporan perjalanan dengan status 'menunggu validasi'
        // Tambahkan eager loading untuk relasi yang dibutuhkan
        $perjalanan = LaporanPerjalanan::with(['user', 'Kendaraan.latestInspeksi'])
            ->where('status', 'menunggu validasi')
            ->get();
        // Mengambil semua data kendaraan (Mungkin tidak perlu jika sudah eager load? Tergantung kebutuhan lain)
        // $kendaraan = Kendaraan::all(); 

        // Mengembalikan view dengan data yang difilter
        return view('hsse.persetujuanperjalanan', compact('perjalanan')); // Hapus compact kendaraan jika tidak dipakai
    }
}
