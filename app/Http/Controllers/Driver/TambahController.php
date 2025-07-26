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
use Carbon\Carbon;
use App\Models\DcuRecord;

class TambahController extends Controller
{
    // Menampilkan halaman form tambah perjalanan
    public function viewPerjalanan()
    {
        // Ambil status DCU terakhir
        $latestDcu = DcuRecord::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        $dcuStatus = 'Belum Mengisi'; // Default status

        if ($latestDcu) {
            $dcuStatus = $latestDcu->kesimpulan; // 'Fit' or 'Unfit'
        }

        $perjalanan = LaporanPerjalanan::all();
        $kendaraan = Kendaraan::whereIn('status', ['ready', 'perlu_perbaikan'])->get();
        $pegawaiList = Pegawai::orderBy('nama')->get();
        return view('driver.tambahperjalanan', compact('perjalanan', 'kendaraan', 'pegawaiList', 'dcuStatus'));
    }

    // Menyimpan data perjalanan
    public function storePerjalanan(Request $request)
    {
        // Cek DCU Terakhir
        $latestDcu = DcuRecord::where('user_id', Auth::id())->latest()->first();
        if ($latestDcu && $latestDcu->kesimpulan == 'Unfit') {
            // Periksa apakah DCU dibuat pada hari yang sama
            if ($latestDcu->created_at->isToday()) {
                return redirect()->back()->with('error', 'Anda tidak dapat membuat perjalanan karena hasil DCU terakhir Anda adalah "Unfit".');
            }
        }

        // Cek apakah user sudah punya perjalanan aktif
        $perjalananAktif = LaporanPerjalanan::where('pengemudi_id', Auth::id())
            ->whereIn('status', ['menunggu validasi', 'disetujui', 'in_use'])
            ->whereNull('jam_kembali')
            ->first();
        if ($perjalananAktif) {
            return redirect()->back()->with('error', 'Anda masih memiliki perjalanan yang sedang berjalan atau menunggu persetujuan. Selesaikan perjalanan tersebut sebelum membuat perjalanan baru.');
        }

        $request->validate([
            // 'pengemudi_id' => 'required', // Ini tidak perlu, karena pakai Auth::id()
            'nama_pegawai' => 'required|array',
            'nama_pegawai.*' => 'string|max:255',
            'titik_awal' => 'required|max:255',
            'titik_akhir' => 'required|max:255',
            'tujuan_perjalanan' => 'required|max:255',
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'km_awal_manual' => 'required|numeric',
            'bbm_awal' => 'required|numeric',
            'jam_pergi' => 'required',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
            'estimasi_jarak' => 'required',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->input('kendaraan_id'));

        if ($kendaraan->status == 'in_use') {
            return redirect()->back()->with('error', 'Kendaraan sedang digunakan.');
        }

        $previousStatus = $kendaraan->status;
        Log::info('TambahController@storePerjalanan:');
        Log::info('  Kendaraan ID: ' . $kendaraan->id);
        Log::info('  Status awal kendaraan: ' . $previousStatus);

        $kendaraan->status = 'in_use';
        $kendaraan->save();

        Log::info('TambahController@storePerjalanan - Status Kendaraan setelah diubah: ' . $kendaraan->status);

        $estimasi_jarak_numeric = floatval(str_replace(',', '.', $request->input('estimasi_jarak')));
        $km_akhir_calculated = $estimasi_jarak_numeric * 2;

        // --- PERBAIKAN UNTUK NAMA PEGAWAI ---
        $namaPegawaiInput = $request->input('nama_pegawai');
        // Cek jika inputnya adalah array, langsung encode. Jika tidak, anggap sudah JSON.
        $namaPegawaiJson = is_array($namaPegawaiInput) ? json_encode($namaPegawaiInput) : $namaPegawaiInput;
        // Membersihkan jika ada JSON yang tidak valid atau string kosong
        if (!json_decode($namaPegawaiJson)) {
            $namaPegawaiJson = '[]';
        }

        $perjalanan = LaporanPerjalanan::create([
            'pengemudi_id' => Auth::id(),
            'nama_pegawai' => $namaPegawaiJson, // Menggunakan variabel yang sudah dibersihkan
            'titik_awal' => $request->input('titik_awal'),
            'titik_akhir' => $request->input('titik_akhir'),
            'tujuan_perjalanan' => $request->input('tujuan_perjalanan'),
            'kendaraan_id' => $request->input('kendaraan_id'),
            'km_awal' => null,
            'km_akhir' => $km_akhir_calculated,
            'km_awal_manual' => $request->input('km_awal_manual'),
            'bbm_awal' => $request->input('bbm_awal'),
            'bbm_akhir' => null,
            'jam_pergi' => $request->input('jam_pergi'),
            'jam_kembali' => null,
            'foto_awal' => $request->file('foto_awal')->store('foto_perjalanan', 'public'),
            'foto_akhir' => null,
            'status' => 'menunggu validasi',
            'estimasi_jarak' => $estimasi_jarak_numeric,
            'estimasi_waktu' => null,
            'previous_kendaraan_status' => $previousStatus,
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
            'jenis_bbm' => 'required|in:Solar,Pertalite,Pertamax',
            'jam_kembali' => 'required|date',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:6000',
            'km_akhir_manual' => 'required|numeric|gt:' . $perjalanan->km_awal_manual,
        ]);

        $total_km_manual = $request->input('km_akhir_manual') - $perjalanan->km_awal_manual;

        $perjalanan->update([
            'bbm_akhir' => $request->input('bbm_akhir'),
            'jenis_bbm' => $request->input('jenis_bbm'),
            'jam_kembali' => $request->input('jam_kembali'),
            'foto_akhir' => $request->hasFile('foto_akhir') ? $request->file('foto_akhir')->store('foto_perjalanan', 'public') : $perjalanan->foto_akhir,
            'km_akhir_manual' => $request->input('km_akhir_manual'),
            'total_km_manual' => $total_km_manual,
        ]);

        if ($perjalanan->jam_pergi && $perjalanan->jam_kembali) {
            $jamPergi = Carbon::parse($perjalanan->jam_pergi);
            $jamKembali = Carbon::parse($perjalanan->jam_kembali);

            if ($jamKembali->greaterThan($jamPergi)) {
                $durasi = $jamKembali->diff($jamPergi);
                $perjalanan->estimasi_waktu = $durasi->format('%h jam %i menit');
            } else {
                $perjalanan->estimasi_waktu = 'Data waktu tidak valid';
                Log::warning('Perhitungan durasi tidak valid: Jam kembali tidak lebih besar dari jam pergi.', ['perjalanan_id' => $perjalanan->id]);
            }
            $perjalanan->save();
        }

        $kendaraan = $perjalanan->kendaraan;

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
