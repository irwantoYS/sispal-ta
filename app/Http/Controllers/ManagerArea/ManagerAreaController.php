<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagerAreaController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalPerjalanan = LaporanPerjalanan::count();
        $totalKendaraan = Kendaraan::count();
        $totalDriver = User::where('role', 'Driver')->count();

        // Hitung Total Keseluruhan Jarak (menggunakan km_akhir dari perjalanan selesai)
        $totalJarakSemua = LaporanPerjalanan::whereNotNull('km_akhir')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->sum('km_akhir');

        // Hitung Total KM Manual
        $totalKmManualSemua = LaporanPerjalanan::whereNotNull('jam_kembali')
            ->sum('total_km_manual');

        // Hitung Total Estimasi BBM Keseluruhan (dari perjalanan selesai)
        $totalBbmSemua = 0;
        $laporanBbm = LaporanPerjalanan::with('kendaraan')
            ->whereNotNull('km_akhir') // Gunakan km_akhir
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->get();
        foreach ($laporanBbm as $laporan) {
            if ($laporan->kendaraan && $laporan->kendaraan->km_per_liter > 0 && $laporan->km_akhir > 0) {
                $totalBbmSemua += (float)$laporan->km_akhir / (float)$laporan->kendaraan->km_per_liter;
            }
        }

        // Hitung Total Waktu Keseluruhan (dari perjalanan selesai)
        $totalWaktuDetikSemua = LaporanPerjalanan::whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->sum(DB::raw('TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)'));

        // Filter Bulan dan Tahun
        $selectedMonth = (int) $request->input('bulan', Carbon::now()->month);
        $selectedYear = (int) $request->input('tahun', Carbon::now()->year);

        $availableMonths = LaporanPerjalanan::select(DB::raw('DISTINCT MONTH(jam_pergi) as month'))
            ->orderBy('month')
            ->pluck('month');
        $availableYears = LaporanPerjalanan::select(DB::raw('DISTINCT YEAR(jam_pergi) as year'))
            ->orderBy('year')
            ->pluck('year');

        // Mengambil Top Driver berdasarkan Jarak Tempuh (menggunakan km_akhir)
        $topDriversByDistance = LaporanPerjalanan::select(
            'pengemudi_id',
            DB::raw('SUM(km_akhir) as total_jarak'),
            DB::raw('SUM(total_km_manual) as total_km_manual')
        )
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('km_akhir') // Pastikan km_akhir ada
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_jarak')
            ->limit(5)
            ->get();

        $topDriversByTrips = LaporanPerjalanan::select('pengemudi_id', DB::raw('COUNT(*) as total_perjalanan'))
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_perjalanan')
            ->limit(5)
            ->get();

        // Mengambil Top Driver berdasarkan Waktu Tempuh (Sama seperti HSSE)
        $topDriversByTime = LaporanPerjalanan::select(
            'pengemudi_id',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, jam_pergi, jam_kembali)) as total_detik')
        )
            ->with('user')
            ->whereMonth('jam_pergi', $selectedMonth)
            ->whereYear('jam_pergi', $selectedYear)
            ->whereNotNull('bbm_akhir') // Filter Selesai
            ->whereNotNull('jam_kembali') // Filter Selesai
            ->groupBy('pengemudi_id')
            ->orderByDesc('total_detik')
            ->limit(5)
            ->get();

        // Format waktu untuk top driver by time (Sama seperti HSSE)
        foreach ($topDriversByTime as $driver) {
            $driver->total_waktu_format = $this->formatTimeFromSeconds($driver->total_detik);
        }

        // Format waktu untuk total keseluruhan (Sama seperti HSSE)
        $totalWaktuFormatSemua = $this->formatTimeFromSeconds($totalWaktuDetikSemua);

        return view('managerarea.dashboard', compact(
            'totalPerjalanan',
            'totalKendaraan',
            'totalDriver',
            'totalJarakSemua',
            'totalBbmSemua',
            'totalWaktuFormatSemua',
            'totalKmManualSemua',
            'topDriversByDistance',
            'topDriversByTrips',
            'topDriversByTime',
            'selectedMonth',
            'selectedYear',
            'availableMonths',
            'availableYears'
        ));
    }


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
