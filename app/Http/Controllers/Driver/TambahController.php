<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LaporanPerjalanan;
use App\Models\InspeksiKendaraan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\PerjalananCreated;
use Illuminate\Support\Facades\Auth;

class TambahController extends Controller
{
    // Menampilkan halaman form tambah perjalanan
    public function viewPerjalanan()
    {
        $perjalanan = LaporanPerjalanan::all();
        $kendaraan = Kendaraan::whereIn('status', ['ready', 'perlu_perbaikan'])->get();
        $pegawaiList = Pegawai::orderBy('nama')->get();
        return view('driver.tambahperjalanan', compact('perjalanan', 'kendaraan', 'pegawaiList'));
    }

    // Menyimpan data perjalanan
    public function storePerjalanan(Request $request)
    {
        $request->validate([
            // 'pengemudi_id' => 'required', // Ini tidak perlu, karena pakai Auth::id()
            'nama_pegawai' => 'required|array',
            'nama_pegawai.*' => 'string|max:255',
            'titik_awal' => 'required|max:255',
            'titik_akhir' => 'required|max:255',
            'tujuan_perjalanan' => 'required|max:255',
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'bbm_awal' => 'required|numeric',
            'jam_pergi' => 'required',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
            'estimasi_jarak' => 'required',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        if ($kendaraan->status == 'in_use') {
            return redirect()->back()->with('error', 'Kendaraan sedang digunakan.');
        }

        // Simpan status SEBELUM diubah
        $previousStatus = $kendaraan->status;  // <--- SIMPAN STATUS AWAL

        // --- TAMBAHKAN LOGGING DI SINI ---
        Log::info('TambahController@storePerjalanan:');
        Log::info('  Kendaraan ID: ' . $kendaraan->id);
        Log::info('  Status awal kendaraan: ' . $previousStatus);

        $kendaraan->status = 'in_use';
        $kendaraan->save();

        Log::info('TambahController@storePerjalanan - Status Kendaraan setelah diubah: ' . $kendaraan->status);

        $perjalanan = LaporanPerjalanan::create([
            'pengemudi_id' => Auth::id(),
            'nama_pegawai' => json_encode($request->nama_pegawai),
            'titik_awal' => $request->titik_awal,
            'titik_akhir' => $request->titik_akhir,
            'tujuan_perjalanan' => $request->tujuan_perjalanan,
            'kendaraan_id' => $request->kendaraan_id,
            'km_awal' => null,
            'km_akhir' => null,
            'bbm_awal' => $request->bbm_awal,
            'bbm_akhir' => null,
            'jam_pergi' => $request->jam_pergi,
            'jam_kembali' => null,
            'foto_awal' => $request->file('foto_awal')->store('foto_perjalanan', 'public'),
            'foto_akhir' => null,
            'status' => 'menunggu validasi',
            'estimasi_jarak' => $request->estimasi_jarak,
            'previous_kendaraan_status' => $previousStatus, // <--- SIMPAN KE DATABASE
        ]);


        PerjalananCreated::dispatch($perjalanan);

        return redirect()->back()->with('success', 'Data Perjalanan berhasil ditambahkan!');
    }


    public function updatePerjalanan(Request $request, $id)
    {
        $perjalanan = LaporanPerjalanan::find($id);

        if (!$perjalanan) {
            return redirect()->back()->with('error', 'Data perjalanan tidak ditemukan.');
        }

        if ($perjalanan->pengemudi_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bbm_akhir' => 'required|numeric',
            'jam_kembali' => 'required',
            'foto_akhir' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6000',
        ]);

        $perjalanan->update([
            'bbm_akhir' => $request->bbm_akhir,
            'jam_kembali' => $request->jam_kembali,
            'foto_akhir' => $request->hasFile('foto_akhir') ? $request->file('foto_akhir')->store('foto_perjalanan', 'public') : $perjalanan->foto_akhir,
        ]);

        $kendaraan = $perjalanan->kendaraan;

        // Logging untuk membantu debug
        Log::info('UpdatePerjalanan - Mengembalikan status kendaraan:');
        Log::info('  Kendaraan ID: ' . $kendaraan->id);
        Log::info('  Status sebelum update: ' . $kendaraan->status);
        Log::info('  Previous status yang tersimpan: ' . $perjalanan->previous_kendaraan_status);

        if (!$perjalanan->previous_kendaraan_status) {
            Log::warning('Previous kendaraan status kosong! Menggunakan status default ready');
            $kendaraan->status = 'ready';
        } else {
            $kendaraan->status = $perjalanan->previous_kendaraan_status;
        }

        $kendaraan->save();
        Log::info('  Status setelah update: ' . $kendaraan->status);

        return redirect()->back()->with('success', 'Data perjalanan berhasil diperbarui!');
    }
}
