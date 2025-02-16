<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Events\PerjalananStatusUpdated; // 1. Import Event

class PersetujuanController extends Controller
{
    public function viewPersetujuan()
    {
        // Mengambil data laporan perjalanan dengan status 'menunggu validasi'
        $perjalanan = LaporanPerjalanan::where('status', 'menunggu validasi')->get();
        // Mengambil semua data kendaraan
        $kendaraan = Kendaraan::all();

        // Mengembalikan view dengan data yang difilter
        return view('managerarea.persetujuanperjalanan', compact('perjalanan', 'kendaraan'));
    }

    public function validasi($id)
    {
        $perjalanan = LaporanPerjalanan::findOrFail($id);
        $perjalanan->status = 'disetujui';
        $perjalanan->save();

        // 2. Dispatch event untuk persetujuan
        PerjalananStatusUpdated::dispatch($perjalanan, 'disetujui');

        return response()->json(['message' => 'Perjalanan berhasil divalidasi.']);
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $perjalanan = LaporanPerjalanan::findOrFail($id);
        $perjalanan->status = 'ditolak';
        $perjalanan->alasan = $request->alasan;
        $perjalanan->save();

        // 3. Dispatch event untuk penolakan
        PerjalananStatusUpdated::dispatch($perjalanan, 'ditolak');
        

        return response()->json(['message' => 'Perjalanan berhasil ditolak dengan alasan: ' . $request->alasan]);
    }
}