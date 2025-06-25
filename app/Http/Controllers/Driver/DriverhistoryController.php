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
            ->orderBy('jam_pergi', 'desc');


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

        $perjalanan = $perjalananQuery->with('kendaraan', 'validator')->get(); // Eager load kendaraan

        // --- Perhitungan di Luar Loop ---
        $totalEstimasiJarak = 0;
        $totalEstimasiBBM = 0;
        $totalDurasiMenit = 0;

        foreach ($perjalanan as $item) {
            // Durasi perjalanan sudah dihitung dan disimpan di $item->estimasi_waktu
            // oleh TambahController@updatePerjalanan. Untuk total, kita masih hitung dari jam.
            if ($item->jam_pergi && $item->jam_kembali) {
                $jam_pergi = Carbon::parse($item->jam_pergi);
                $jam_kembali = Carbon::parse($item->jam_kembali);
                $durasi = $jam_pergi->diffInMinutes($jam_kembali);
                $totalDurasiMenit += $durasi;
                // $item->estimasi_waktu sudah memiliki format "X jam Y menit" dari database
            }

            // km_akhir sudah dihitung (estimasi_jarak * 2) dan disimpan di database
            // oleh TambahController@storePerjalanan.

            if ($item->Kendaraan && $item->Kendaraan->km_per_liter > 0) {
                $item->estimasi_bbm = (float)$item->km_akhir / $item->Kendaraan->km_per_liter;
            } else {
                $item->estimasi_bbm = 0;
            }

            // Akumulasi total
            $totalEstimasiJarak += (float)$item->km_akhir; // Gunakan km_akhir dari database
            $totalEstimasiBBM += (float)$item->estimasi_bbm;
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
