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
                DB::raw("SUM(TIMESTAMPDIFF(MINUTE, jam_pergi, jam_kembali)) as total_durasi_menit")
            )
            ->with('user')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->groupBy('pengemudi_id')
            ->orderBy('total_jarak', 'desc');

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $driverSummaryQuery->whereBetween('jam_pergi', [$startDate, $endDate]);
        }

        $driverSummary = $driverSummaryQuery->get();

        foreach ($driverSummary as $driver) {
            $totalDurasiMenit = $driver->total_durasi_menit;
            $jam = floor($totalDurasiMenit / 60);
            $menit = $totalDurasiMenit % 60;
            $driver->total_durasi_format = sprintf("%02d Jam %02d Menit", $jam, $menit);
            $driver->total_jarak = number_format($driver->total_jarak, 2, ',', '.');
        }


        // --- Data Detail Perjalanan ---
        $perjalananQuery = LaporanPerjalanan::query()
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->orderBy('updated_at', 'desc');

        // --- Filter Tanggal (Pindahkan ke sini agar konsisten) ---
        if ($startDate && $endDate) {
            // $startDate dan $endDate sudah di-parse di bagian ringkasan, jadi bisa langsung digunakan.
            $perjalananQuery->whereBetween('jam_pergi', [$startDate, $endDate]);
        }

        $perjalanan = $perjalananQuery->get();
        
        // --- Buat String Rentang Tanggal ---
        if ($startDate && $endDate) {
            $rentangTanggal = $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
        } else {
            $rentangTanggal = '';
        }

        // --- Perhitungan Total (Tidak Berubah) ---
        $totalEstimasiJarak = 0;
        $totalEstimasiBBM = 0;
        $totalDurasiMenit = 0;

       foreach ($perjalanan as $item) {
             // Hitung durasi
            $jam_pergi = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_pergi, 'Asia/Jakarta');
            $jam_kembali = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_kembali, 'Asia/Jakarta');
             $durasi = $jam_pergi->diffInMinutes($jam_kembali); //perbaiki urutan

            $jam = floor($durasi / 60);
            $menit = $durasi % 60;
            $durasi_format = sprintf("%02d Jam %02d Menit", $jam, $menit);

            // Simpan durasi ke database (optional, tapi bagus untuk konsistensi)
            $item->estimasi_waktu = $durasi_format;

              // Hitung total jarak (km_akhir)
             $total_jarak = (float)$item->estimasi_jarak * 2; //dari tambah perjalanan
             $item->km_akhir = number_format($total_jarak, 2, '.', '');


            // Hitung estimasi BBM
             if ($item->Kendaraan && is_numeric($item->km_akhir)) {
                  $km_akhir_numeric = (float) str_replace(' KM', '', $item->km_akhir);
                  $estimasi_bbm =  $km_akhir_numeric / $item->Kendaraan->km_per_liter;
                  $item->estimasi_bbm = number_format($estimasi_bbm, 2, '.', '');
             } else {
                  $item->estimasi_bbm = '0';
             }

              //Tambahkan ke total
            $totalEstimasiJarak += $total_jarak;
            $totalEstimasiBBM += $item->estimasi_bbm;
            $totalDurasiMenit += $durasi;

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
            'startDate' => $startDate,  // Tanggal awal (untuk form)
            'endDate' => $endDate,      // Tanggal akhir (untuk form)
            'rentangTanggal' => $rentangTanggal,    // String rentang tanggal
        ]);
    }

}