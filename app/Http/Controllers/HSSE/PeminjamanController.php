<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LaporanPerjalanan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $kendaraanTersedia = Kendaraan::where('status', 'ready')->get();
        $pegawaiList = Pegawai::orderBy('nama')->get();
        $peminjamanAktif = LaporanPerjalanan::with(['user', 'kendaraan'])
            ->where('status', 'dipinjam')
            ->get();

        return view('hsse.peminjaman', compact('kendaraanTersedia', 'pegawaiList', 'peminjamanAktif'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pegawai_id' => 'required|array',
            'pegawai_id.*' => 'exists:pegawai,id',
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tujuan_perjalanan' => 'required|string|max:255',
            'titik_akhir' => 'required|string|max:255',
            'estimasi_jarak' => 'required|numeric',
            'km_awal_manual' => 'required|numeric',
            'bbm_awal' => 'required|numeric',
            'jam_pergi' => 'required|date',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        if ($kendaraan->status !== 'ready') {
            return redirect()->back()->with('error', 'Kendaraan tidak tersedia atau sedang digunakan.');
        }

        $pegawaiNames = Pegawai::whereIn('id', $request->pegawai_id)->pluck('nama')->toArray();

        // Simpan status sebelumnya dan ubah status kendaraan
        $previousStatus = $kendaraan->status;
        $kendaraan->status = 'in_use';
        $kendaraan->save();

        // Buat laporan perjalanan dengan status 'dipinjam'
        LaporanPerjalanan::create([
            'pengemudi_id' => Auth::id(), // Dicatat oleh HSSE yang login
            'nama_pegawai' => json_encode($pegawaiNames), // Simpan sebagai array JSON
            'kendaraan_id' => $request->kendaraan_id,
            'tujuan_perjalanan' => $request->tujuan_perjalanan,
            'titik_awal' => '35125, Jl. Sam Ratulangi No.15, Penengahan, Kec. Tj. Karang Pusat, Kota Bandar Lampung, Lampung 35126',
            'titik_akhir' => $request->titik_akhir,
            'jam_pergi' => $request->jam_pergi,
            'status' => 'dipinjam', // Status khusus untuk peminjaman
            'estimasi_jarak' => $request->estimasi_jarak,
            'previous_kendaraan_status' => $previousStatus,
            'km_akhir' => $request->estimasi_jarak * 2,
            'km_awal_manual' => $request->km_awal_manual,
            'bbm_awal' => $request->bbm_awal,
            'foto_awal' => $request->file('foto_awal')->store('foto_perjalanan', 'public'),
        ]);

        return redirect()->route('hsse.peminjaman.index')->with('success', 'Peminjaman kendaraan berhasil dicatat.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request, $id): RedirectResponse
    {
        $peminjaman = LaporanPerjalanan::findOrFail($id);

        $request->validate([
            'bbm_akhir' => 'required|numeric',
            'jam_kembali' => 'required|date',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
            'km_akhir_manual' => 'required|numeric|gt:' . $peminjaman->km_awal_manual,
            'jenis_bbm' => 'required|in:Solar,Pertalite,Pertamax',
        ]);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman ini tidak dalam status aktif.');
        }

        $peminjaman->jam_kembali = $request->jam_kembali;
        $peminjaman->bbm_akhir = $request->bbm_akhir;
        $peminjaman->jenis_bbm = $request->jenis_bbm;
        $peminjaman->km_akhir_manual = $request->km_akhir_manual;
        $peminjaman->total_km_manual = $request->km_akhir_manual - $peminjaman->km_awal_manual;

        if ($request->hasFile('foto_akhir')) {
            $peminjaman->foto_akhir = $request->file('foto_akhir')->store('foto_perjalanan', 'public');
        }
        $peminjaman->status = 'selesai';

        if ($peminjaman->jam_pergi && $peminjaman->jam_kembali) {
            $jamPergi = Carbon::parse($peminjaman->jam_pergi);
            $jamKembali = Carbon::parse($peminjaman->jam_kembali);

            if ($jamKembali->greaterThan($jamPergi)) {
                $durasi = $jamKembali->diff($jamPergi);
                $peminjaman->estimasi_waktu = $durasi->format('%h jam %i menit');
            }
        }

        $peminjaman->save();

        // Kembalikan status kendaraan
        $kendaraan = $peminjaman->kendaraan;
        if ($kendaraan) {
            $kendaraan->status = $peminjaman->previous_kendaraan_status ?: 'ready';
            $kendaraan->save();
        }

        return redirect()->route('hsse.peminjaman.index')->with('success', 'Peminjaman kendaraan telah diselesaikan.');
    }
}
