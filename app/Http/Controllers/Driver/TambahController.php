<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\PerjalananCreated; // 1. Import Event
use Illuminate\Support\Facades\Auth; // 2. Import Auth facade

class TambahController extends Controller
{
    // Menampilkan halaman form tambah perjalanan
    public function viewPerjalanan()
    {
        // Ambil semua data perjalanan dan kendaraan
        $perjalanan = LaporanPerjalanan::all();
        $kendaraan = Kendaraan::all();
        return view('driver.tambahperjalanan', compact('perjalanan', 'kendaraan'));
    }

    // Menyimpan data perjalanan
    public function storePerjalanan(Request $request)
    {
        $request->validate([
            'pengemudi_id' => 'required',
            'nama_pegawai' => 'required|max:255',
            'titik_awal' => 'required|max:255',
            'titik_akhir' => 'required|max:255',
            'tujuan_perjalanan' => 'required|max:255',
            'kendaraan_id' => 'required',
            // 'km_awal' => 'required|numeric', // km_awal di-set null
            'bbm_awal' => 'required|numeric',
            'jam_pergi' => 'required',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'estimasi_jarak' => 'required', // Pastikan estimasi jarak tidak kosong
        ]);


        // 3. Gunakan Auth::id() untuk mendapatkan ID driver yang login
        $perjalanan = LaporanPerjalanan::create([
            'pengemudi_id' => Auth::id(), // ID driver yang login.  Ini LEBIH AMAN.
            'nama_pegawai' => $request->nama_pegawai,
            'titik_awal' => $request->titik_awal,
            'titik_akhir' => $request->titik_akhir,
            'tujuan_perjalanan' => $request->tujuan_perjalanan,
            'kendaraan_id' => $request->kendaraan_id,
            'km_awal' => null, // Set null, karena diisi nanti
            'km_akhir' => null, // Set null
            'bbm_awal' => $request->bbm_awal,
            'bbm_akhir' => null, // Set null
            'jam_pergi' => $request->jam_pergi,
            'jam_kembali' => null, // Set null
            'foto_awal' => $request->file('foto_awal')->store('foto_perjalanan', 'public'),
            'foto_akhir' => null, // Set null
            'status' => 'menunggu validasi', // Status awal
            'estimasi_jarak' => $request->estimasi_jarak,
        ]);


        // 4. Dispatch event PerjalananCreated *SETELAH* data perjalanan disimpan.
        PerjalananCreated::dispatch($perjalanan);

        return redirect()->back()->with('success', 'Data Perjalanan berhasil ditambahkan!');
    }

    public function updatePerjalanan(Request $request, $id)
    {
        // Mencari data perjalanan berdasarkan ID
        $perjalanan = LaporanPerjalanan::find($id);

        if (!$perjalanan) {
            return redirect()->back()->with('error', 'Data perjalanan tidak ditemukan.');
        }

        $perjalanan->update([
            'km_akhir' => $request->km_akhir,
            'bbm_akhir' => $request->bbm_akhir,
            'jam_kembali' => $request->jam_kembali,
            'foto_akhir' => $request->hasFile('foto_akhir') ? $request->file('foto_akhir')->store('foto_perjalanan', 'public') : $perjalanan->foto_akhir,
        ]);

        return redirect()->back()->with('success', 'Data perjalanan berhasil diperbarui!');
    }
}