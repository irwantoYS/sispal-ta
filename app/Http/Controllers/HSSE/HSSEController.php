<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HSSEController extends Controller
{
    public function dashboard(Request $request)
    {
        // Data Ringkasan Utama
        $totalPerjalanan = LaporanPerjalanan::count();
        $totalKendaraan = Kendaraan::count();
        $totalDriver = User::where('role', 'Driver')->count(); // Tetap hitung driver

        // Hitung Total Keseluruhan (mengikuti logika History: estimasi_jarak * 2 dari perjalanan selesai)
        $totalJarakSemua = 0; // Inisialisasi
        $laporanJarak = LaporanPerjalanan::whereNotNull('estimasi_jarak')
            ->whereNotNull('bbm_akhir')     // Filter: BBM Akhir tidak null
            ->whereNotNull('jam_kembali') // Filter: Jam Kembali tidak null
            ->get(['estimasi_jarak']); // Ambil data yang sudah difilter
        foreach ($laporanJarak as $laporan) {
            $totalJarakSemua += (float)$laporan->estimasi_jarak * 2; // Kalikan 2 dan tambahkan
        }

        // Hitung Total Estimasi BBM Keseluruhan (dari perjalanan selesai)
        $totalBbmSemua = 0; // Inisialisasi
        $laporanBbm = LaporanPerjalanan::with('kendaraan') // Eager load kendaraan
            ->whereNotNull('estimasi_jarak')
            ->whereNotNull('bbm_akhir')     // Filter Selesai
            ->whereNotNull('jam_kembali') // Filter Selesai
            ->get();
        foreach ($laporanBbm as $laporan) {
            if ($laporan->kendaraan && $laporan->kendaraan->km_per_liter > 0) {
                $jarakItem = (float)$laporan->estimasi_jarak * 2;
                $totalBbmSemua += $jarakItem / (float)$laporan->kendaraan->km_per_liter;
            }
        }

        $totalWaktuDetikSemua = LaporanPerjalanan::whereNotNull('jam_kembali')
            ->sum(DB::raw('TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)'));

        // Filter Bulan dan Tahun
        $selectedMonth = (int) $request->input('bulan', Carbon::now()->month);
        $selectedYear = (int) $request->input('tahun', Carbon::now()->year);

        // Mendapatkan daftar bulan dan tahun untuk filter
        $availableMonths = LaporanPerjalanan::select(DB::raw('DISTINCT MONTH(jam_pergi) as month'))
            ->orderBy('month')
            ->pluck('month');
        $availableYears = LaporanPerjalanan::select(DB::raw('DISTINCT YEAR(jam_pergi) as year'))
            ->orderBy('year')
            ->pluck('year');

        // Mengambil Top Driver berdasarkan Jarak Tempuh
        $topDriversByDistance = LaporanPerjalanan::select('pengemudi_id', DB::raw('SUM(estimasi_jarak) as total_jarak'))
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('estimasi_jarak')
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_jarak')
            ->limit(5)
            ->get();

        // Mengambil Top Driver berdasarkan Jumlah Perjalanan
        $topDriversByTrips = LaporanPerjalanan::select('pengemudi_id', DB::raw('COUNT(*) as total_perjalanan'))
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_perjalanan')
            ->limit(5)
            ->get();

        // Mengambil Top Driver berdasarkan Waktu Tempuh
        $topDriversByTime = LaporanPerjalanan::select(
            'pengemudi_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)) as total_detik')
        )
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('jam_kembali')
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_detik')
            ->limit(5)
            ->get();

        // Format waktu untuk top driver by time
        foreach ($topDriversByTime as $driver) {
            $driver->total_waktu_format = $this->formatTimeFromSeconds($driver->total_detik);
        }

        // Format waktu untuk total keseluruhan
        $totalWaktuFormatSemua = $this->formatTimeFromSeconds($totalWaktuDetikSemua);

        return view('hsse.dashboard', compact(
            'totalPerjalanan',
            'totalKendaraan',
            'totalDriver',
            'totalJarakSemua',
            'totalBbmSemua',
            'totalWaktuFormatSemua',
            'topDriversByDistance',
            'topDriversByTrips',
            'topDriversByTime',
            'selectedMonth',
            'selectedYear',
            'availableMonths',
            'availableYears'
        ));
    }

    /**
     * Helper function untuk format detik ke Jam Menit.
     *
     * @param int|null $totalSeconds Jumlah detik.
     * @return string String waktu yang diformat (misal: "2 jam 30 mnt").
     */
    private function formatTimeFromSeconds($totalSeconds)
    {
        if ($totalSeconds === null || $totalSeconds <= 0) { // Cek null atau 0 atau negatif
            return '0 mnt';
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $timeString = "";

        if ($hours > 0) {
            $timeString .= $hours . " jam ";
        }

        // Selalu tampilkan menit jika jam 0 atau jika ada sisa menit
        if ($minutes > 0 || $hours == 0) {
            $timeString .= $minutes . " mnt";
        }

        // Jika string kosong (misal total detik < 60 dan > 0), fallback ke 0 mnt (seharusnya tidak terjadi dengan logika di atas)
        // Tapi ditambahkan untuk keamanan
        if (empty(trim($timeString))) {
            return '0 mnt';
        }

        return trim($timeString);
    }
}
