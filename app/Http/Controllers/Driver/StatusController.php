<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function viewStatus()
    {
        // Hapus whereNull('km_akhir'), hanya cek field yang diupdate di modal
        // Pastikan eager loading untuk relasi yang dibutuhkan di modal detail
        $perjalananQuery = LaporanPerjalanan::with(['user', 'Kendaraan.latestInspeksi'])
            ->whereNull('bbm_akhir')
            ->whereNull('jam_kembali')
            ->whereNull('foto_akhir')
            ->orderBy('updated_at', 'desc'); // Urutkan berdasarkan `updated_at`
        // Batasi 10 data per halaman 

        if (Auth::user()->role == 'HSSE') {
            $perjalanan = $perjalananQuery->get();
            return view('driver.statusperjalanan', compact('perjalanan'));
        } elseif (Auth::user()->role == 'ManagerArea') {
            $perjalanan = $perjalananQuery->get();
            return view('driver.statusperjalanan', compact('perjalanan'));
        } elseif (Auth::user()->role == 'Driver') {
            $perjalanan = $perjalananQuery->where('pengemudi_id', Auth::user()->id)->get();
            // dd($perjalanan);
            return view('driver.statusperjalanan', compact('perjalanan'));
        }
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:menunggu validasi,disetujui,ditolak',
            'alasan' => 'nullable|string|max:255', // Validasi alasan (jika ada)
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi foto akhir
        ]);

        // Mencari data perjalanan berdasarkan ID
        $perjalanan = LaporanPerjalanan::find($id);

        if (!$perjalanan) {
            return redirect()->back()->with('error', 'Data perjalanan tidak ditemukan.');
        }

        // Mengupdate status perjalanan
        $perjalanan->status = $request->input('status');

        // Jika statusnya ditolak, simpan alasan penolakan (jika ada)
        if ($request->input('status') == 'ditolak') {
            $perjalanan->alasan = $request->input('alasan');
        }

        // Menyimpan foto akhir jika ada
        if ($request->hasFile('foto_akhir')) {
            $fotoPath = $request->file('foto_akhir')->store('foto_perjalanan', 'public');
            $perjalanan->foto_akhir = $fotoPath; // Menyimpan path foto ke dalam kolom 'foto_akhir'
        }

        $perjalanan->save();

        return redirect()->back()->with('success', 'Status perjalanan berhasil diperbarui.');
    }

    public function destroyStatus($id)
    {
        $perjalanan = LaporanPerjalanan::find($id);
        if (!$perjalanan) {
            return redirect()->back()->with('error', 'Data perjalanan tidak ditemukan.');
        }

        // Hanya hapus jika status ditolak
        if ($perjalanan->status == 'ditolak') {
            $perjalanan->delete();
            return redirect()->back()->with('success', 'Laporan perjalanan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Hanya laporan perjalanan yang ditolak yang dapat dihapus.');
        }
    }
}
