<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Tidak selalu dibutuhkan, tapi berguna untuk debugging
use Illuminate\Support\Facades\DB; // Jika Anda melakukan transaksi database

class DriverhistoryController extends Controller
{
    public function viewHistory(Request $request)
    {
        // Middleware auth harus menangani ini; tidak perlu cek di sini.
        // if (!Auth::check()) { ... }

        $perjalananQuery = LaporanPerjalanan::query()
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali')
            ->orderBy('updated_at', 'desc');


        // --- Filtering Tanggal (DIKOREKSI) ---
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null; // startOfDay() untuk inklusif
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null; // endOfDay() untuk inklusif

        if ($startDate && $endDate) {
            $perjalananQuery->whereBetween('jam_pergi', [$startDate, $endDate]);
        } elseif ($startDate) {
            $perjalananQuery->where('jam_pergi', '>=', $startDate);
        } elseif ($endDate) {
            $perjalananQuery->where('jam_pergi', '<=', $endDate);
        }
        // --- Akhir Filtering Tanggal ---


        // Filter berdasarkan pengemudi_id jika role adalah 'Driver'
        if (Auth::user()->role == 'Driver') {
            $perjalananQuery->where('pengemudi_id', Auth::user()->id);
        }

        $perjalanan = $perjalananQuery->get();

        // --- Perhitungan di Luar Loop ---
        $totalEstimasiJarak = 0;
        $totalEstimasiBBM = 0;
        $totalDurasiMenit = 0;

        foreach ($perjalanan as $item) {
            // Hitung Durasi (pastikan format tanggal/waktu konsisten)
            $jam_pergi = Carbon::parse($item->jam_pergi); // Carbon::parse lebih reliable
            $jam_kembali = Carbon::parse($item->jam_kembali);
            $durasi = $jam_pergi->diffInMinutes($jam_kembali);
            $totalDurasiMenit += $durasi;

            $jam = floor($durasi / 60);
            $menit = $durasi % 60;
            // Simpan durasi yang diformat, TAPI simpan juga durasi dalam menit (untuk perhitungan total)
            $item->estimasi_waktu = sprintf("%02d Jam %02d Menit", $jam, $menit);


            // Hitung km_akhir dan estimasi_bbm (pastikan Kendaraan ada)
            $total_jarak = (float)$item->estimasi_jarak * 2;
            $item->km_akhir = $total_jarak; // Simpan sebagai float/decimal!

            if ($item->Kendaraan) { // Lebih ringkas, dan hindari error jika Kendaraan null
                $estimasi_bbm = $item->km_akhir / $item->Kendaraan->km_per_liter;
                $item->estimasi_bbm = $estimasi_bbm; // Simpan sebagai float/decimal!
            } else {
                $item->estimasi_bbm = 0; // Default yang lebih baik daripada string kosong
            }

            // Akumulasi total
            $totalEstimasiJarak += $item->km_akhir;
            $totalEstimasiBBM += $item->estimasi_bbm;
        }
        // --- Akhir Perhitungan ---


        // Hitung total durasi (gunakan $totalDurasiMenit yang sudah dihitung)
        $totalDurasiJam = floor($totalDurasiMenit / 60);
        $totalDurasiSisaMenit = $totalDurasiMenit % 60;
        $totalDurasiFormat = sprintf("%02d Jam %02d Menit", $totalDurasiJam, $totalDurasiSisaMenit);

        // --- TIDAK ADA $item->save() DI SINI ---


        // Kirim data ke view  *** PASTIKAN ADA startDate dan endDate ***
        return view('driver.historyperjalanan', compact('perjalanan', 'totalEstimasiJarak', 'totalEstimasiBBM', 'totalDurasiFormat', 'startDate', 'endDate'));
    }
}