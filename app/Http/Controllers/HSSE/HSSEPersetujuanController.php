<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class HSSEPersetujuanController extends Controller
{
    public function viewPersetujuan (request $request){
        
            // Mengambil data laporan perjalanan dengan status 'menunggu validasi'
            $perjalanan = LaporanPerjalanan::where('status', 'menunggu validasi')->get();
            // Mengambil semua data kendaraan
            $kendaraan = Kendaraan::all();
            
            // Mengembalikan view dengan data yang difilter
            return view('hsse.persetujuanperjalanan', compact('perjalanan', 'kendaraan'));
        }
}
