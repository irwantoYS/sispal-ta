<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HSSEKendaraanController extends Controller
{
    public function viewTambahKendaraan()
    {
        $tambahkendaraan = Kendaraan::all();
        return view('hsse.tambahkendaraan', compact('tambahkendaraan'));
    }

    public function storeTambahKendaraan(Request $request)
    {
        // Validasi data permintaan
        $validatedData = $request->validate([
            'no_kendaraan' => 'required|string|max:255',
            'tipe_kendaraan' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            Log::info('Image uploaded path: ' . $imagePath);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gambar diperlukan'
            ], 400);
        }

        // Membuat entri Kendaraan baru dengan status default 'ready'
        Kendaraan::create([
            'no_kendaraan' => $request->no_kendaraan,
            'tipe_kendaraan' => $request->tipe_kendaraan,
            'km_per_liter' => $request->km_per_liter,
            'status' => 'ready', // Status default diatur menjadi 'ready'
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil ditambahkan!']);
    }

    public function updateTambahKendaraan(Request $request, $id)
    {
        // Validasi data permintaan
        $validatedData = $request->validate([
            'no_kendaraan' => 'required|string|max:255',
            'tipe_kendaraan' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->no_kendaraan = $request->no_kendaraan;
        $kendaraan->tipe_kendaraan = $request->tipe_kendaraan;
        $kendaraan->km_per_liter = $request->km_per_liter;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }

            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $kendaraan->image = $imagePath;
        }

        $kendaraan->save();

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil diupdate!']);
    }

    public function destroyTambahKendaraan($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $cekRelasi = LaporanPerjalanan::where('kendaraan_id', $kendaraan->id)->exists();
        if ($cekRelasi) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus, Kegiatan sudah terkait pada data lain'
            ], 400);
        }

        if ($kendaraan->image) {
            Storage::disk('public')->delete($kendaraan->image);
        }

        $kendaraan->delete();

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil dihapus!']);
    }
}
