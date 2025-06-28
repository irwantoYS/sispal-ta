<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class HSSEHistoryController extends Controller
{
    public function viewHistory(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // --- Ringkasan Per Driver ---
        $driverSummaryQuery = LaporanPerjalanan::query()
            ->select(
                'pengemudi_id',
                DB::raw('SUM(km_akhir) as total_jarak'),
                DB::raw("SUM(TIMESTAMPDIFF(MINUTE, jam_pergi, jam_kembali)) as total_durasi_menit"),
                DB::raw('COUNT(*) as total_perjalanan')
            )
            ->with('user')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->groupBy('pengemudi_id')
            ->orderBy('total_jarak', 'desc');

        if ($startDate && $endDate) {
            $parsedStartDate = Carbon::parse($startDate)->startOfDay();
            $parsedEndDate = Carbon::parse($endDate)->endOfDay();
            $driverSummaryQuery->whereBetween('jam_pergi', [$parsedStartDate, $parsedEndDate]);
        }

        $driverSummary = $driverSummaryQuery->get();

        foreach ($driverSummary as $driver) {
            $totalDurasiMenitDriver = $driver->total_durasi_menit;
            $jamDriver = floor($totalDurasiMenitDriver / 60);
            $menitDriver = $totalDurasiMenitDriver % 60;
            $driver->total_durasi_format = sprintf("%02d Jam %02d Menit", $jamDriver, $menitDriver);
        }


        // --- Data Detail Perjalanan ---
        $perjalananQuery = LaporanPerjalanan::query()
            ->with(['user', 'Kendaraan', 'validator'])
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->orderBy('jam_pergi', 'desc');

        if (isset($parsedStartDate) && isset($parsedEndDate)) {
            $perjalananQuery->whereBetween('jam_pergi', [$parsedStartDate, $parsedEndDate]);
        }

        $perjalanan = $perjalananQuery->get();

        $rentangTanggal = '';
        if (isset($parsedStartDate) && isset($parsedEndDate)) {
            $rentangTanggal = $parsedStartDate->format('d M Y') . ' - ' . $parsedEndDate->format('d M Y');
        }

        // --- Perhitungan Total (menggunakan nilai dari database) ---
        $totalEstimasiJarak = 0;
        $totalEstimasiBBM = 0;
        $totalDurasiMenit = 0;
        $totalKmManual = 0;

        foreach ($perjalanan as $item) {
            if ($item->jam_pergi && $item->jam_kembali) {
                $jam_pergi = Carbon::parse($item->jam_pergi);
                $jam_kembali = Carbon::parse($item->jam_kembali);
                $durasiPerItem = $jam_pergi->diffInMinutes($jam_kembali);
                $totalDurasiMenit += $durasiPerItem;
            }

            if ($item->Kendaraan && $item->Kendaraan->km_per_liter > 0 && is_numeric($item->km_akhir) && $item->km_akhir > 0) {
                $item->estimasi_bbm = (float)$item->km_akhir / $item->Kendaraan->km_per_liter;
            } else {
                $item->estimasi_bbm = 0;
            }

            $totalEstimasiJarak += (float)$item->km_akhir;
            $totalEstimasiBBM += (float)($item->estimasi_bbm ?? 0);
            $totalKmManual += (float)($item->total_km_manual ?? 0);
        }

        $totalDurasiJam = floor($totalDurasiMenit / 60);
        $totalDurasiSisaMenit = $totalDurasiMenit % 60;
        $totalDurasiFormat = sprintf("%02d Jam %02d Menit", $totalDurasiJam, $totalDurasiSisaMenit);

        // --- Kirim data ke view ---
        return view('hsse.historyperjalanan', [
            'perjalanan' => $perjalanan,
            'driverSummary' => $driverSummary,
            'totalEstimasiJarak' => $totalEstimasiJarak,
            'totalEstimasiBBM' => $totalEstimasiBBM,
            'totalDurasiFormat' => $totalDurasiFormat,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'rentangTanggal' => $rentangTanggal,
            'totalKmManual' => $totalKmManual,
        ]);
    }
}
