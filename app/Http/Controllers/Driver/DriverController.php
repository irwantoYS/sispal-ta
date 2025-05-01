<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{

    public function dashboard(Request $request)
    {
        $driverId = Auth::id();

        $totalPerjalananDriver = LaporanPerjalanan::where('pengemudi_id', $driverId)->count();

        // Hitung Total Kendaraan Unik yang Digunakan Driver (Perjalanan Selesai)
        $totalKendaraanDriver = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereNotNull('kendaraan_id') // Pastikan ada kendaraan tercatat
            ->whereNotNull('bbm_akhir')    // Indikator perjalanan selesai
            ->whereNotNull('jam_kembali')   // Indikator perjalanan selesai
            ->distinct('kendaraan_id')
            ->count('kendaraan_id');

        // Hitung Total Keseluruhan (HANYA dari perjalanan SELESAI oleh driver ini)
        // Jarak (mengikuti logika History: estimasi_jarak * 2)
        $totalJarakDriverSelesai = 0;
        $laporanJarakDriver = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereNotNull('estimasi_jarak')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->get(['estimasi_jarak']);
        foreach ($laporanJarakDriver as $laporan) {
            $totalJarakDriverSelesai += (float)$laporan->estimasi_jarak * 2;
        }

        // Waktu
        $totalWaktuDetikDriverSelesai = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereNotNull('bbm_akhir') // Pastikan bbm akhir juga dihitung
            ->whereNotNull('jam_kembali')
            ->sum(DB::raw('TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)'));

        // Hitung Total Estimasi BBM Keseluruhan (dari perjalanan SELESAI oleh driver ini)
        $totalBbmDriverSelesai = 0; // Ganti nama variabel & filter
        $laporanBbmDriver = LaporanPerjalanan::with('kendaraan')
            ->where('pengemudi_id', $driverId) // Filter driver
            ->whereNotNull('estimasi_jarak')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->get();
        foreach ($laporanBbmDriver as $laporan) {
            if ($laporan->kendaraan && $laporan->kendaraan->km_per_liter > 0) {
                $jarakItem = (float)$laporan->estimasi_jarak * 2;
                $totalBbmDriverSelesai += $jarakItem / (float)$laporan->kendaraan->km_per_liter;
            }
        }

        $selectedMonth = (int) $request->input('bulan', Carbon::now()->month);
        $selectedYear = (int) $request->input('tahun', Carbon::now()->year);

        $availableMonths = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->select(DB::raw('DISTINCT MONTH(jam_pergi) as month'))
            ->orderBy('month')
            ->pluck('month');
        $availableYears = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->select(DB::raw('DISTINCT YEAR(jam_pergi) as year'))
            ->orderBy('year')
            ->pluck('year');

        $statsJarak = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('estimasi_jarak')
            ->sum('estimasi_jarak');

        $statsJumlahPerjalanan = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->count();

        $statsWaktuDetik = LaporanPerjalanan::where('pengemudi_id', $driverId)
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('jam_kembali')
            ->sum(DB::raw('TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)'));

        // Format waktu statistik driver
        $statsWaktuFormat = $this->formatTimeFromSeconds($statsWaktuDetik);
        // Format waktu total keseluruhan MILIK DRIVER
        $totalWaktuFormatDriverSelesai = $this->formatTimeFromSeconds($totalWaktuDetikDriverSelesai);

        return view('driver.dashboard', compact(
            'totalPerjalananDriver',
            'totalJarakDriverSelesai', // Ganti nama var
            'totalBbmDriverSelesai',   // Ganti nama var
            'totalWaktuFormatDriverSelesai', // Ganti nama var
            'statsJarak',
            'statsJumlahPerjalanan',
            'statsWaktuFormat',
            'selectedMonth',
            'selectedYear',
            'availableMonths',
            'availableYears',
            'totalKendaraanDriver' // Tambahkan variabel ini
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
        if ($totalSeconds === null || $totalSeconds <= 0) {
            return '0 mnt';
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $timeString = "";

        if ($hours > 0) {
            $timeString .= $hours . " jam ";
        }

        if ($minutes > 0 || $hours == 0) {
            $timeString .= $minutes . " mnt";
        }

        if (empty(trim($timeString))) {
            return '0 mnt';
        }

        return trim($timeString);
    }
}
