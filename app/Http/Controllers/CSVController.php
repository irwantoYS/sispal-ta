<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPerjalanan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSVController extends Controller
{
    public function cetakCSV(Request $request, $role)
    {
        if (!in_array($role, ['Driver', 'HSSE', 'ManagerArea'])) {
            abort(404, 'Role tidak ditemukan');
        }

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $search = $request->input('search');

        $query = LaporanPerjalanan::query()
            ->with('validator', 'kendaraan')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali');

        if ($role === 'Driver' || $role === 'ManagerArea') {
            $query->whereNotNull('nama_pegawai')
                ->whereNotNull('titik_awal')
                ->whereNotNull('titik_akhir')
                ->whereNotNull('tujuan_perjalanan')
                ->whereHas('Kendaraan', function ($query) {
                    $query->whereNotNull('no_kendaraan')
                        ->whereNotNull('tipe_kendaraan');
                });

            if ($role === 'Driver') {
                $query->where('pengemudi_id', Auth::user()->id);
            }
        } elseif ($role === 'HSSE') {
            $query->whereNotNull('nama_pegawai')
                ->whereNotNull('titik_awal')
                ->whereNotNull('titik_akhir')
                ->whereNotNull('tujuan_perjalanan');
        }

        if ($startDate) {
            $query->whereDate('jam_pergi', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('jam_pergi', '<=', $endDate);
        }

        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('nama_pegawai', 'like', "%$search%")
                    ->orWhere('titik_awal', 'like', "%$search%")
                    ->orWhere('titik_akhir', 'like', "%$search%")
                    ->orWhere('tujuan_perjalanan', 'like', "%$search%");
            });
        }

        $perjalanan = $query->get();

        $response = new StreamedResponse(function () use ($perjalanan) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'No',
                'Nama Pegawai',
                'Tujuan Perjalanan',
                'Titik Awal',
                'Titik Akhir',
                'Jam Pergi',
                'Jam Kembali',
                'Total Estimasi Jarak',
                'Total Estimasi BBM',
                'Total Durasi',
                'Total KM Manual',
                'Validator'
            ], ';');

            $totalEstimasiJarak = 0;
            $totalEstimasiBBM = 0;
            $totalDurasiMenit = 0;
            $totalKmManual = 0;

            foreach ($perjalanan as $index => $item) {
                $nama_pegawai_raw = $item->nama_pegawai;
                $nama_pegawai_array = json_decode($nama_pegawai_raw, true);
                $nama_pegawai_formatted = is_array($nama_pegawai_array) ? implode(', ', $nama_pegawai_array) : $nama_pegawai_raw;

                $jam_pergi = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_pergi, 'Asia/Jakarta');
                $jam_kembali = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_kembali, 'Asia/Jakarta');
                $durasi = $jam_pergi->diffInMinutes($jam_kembali);
                $jam = floor($durasi / 60);
                $menit = $durasi % 60;
                $durasi_format = sprintf("%02d Jam %02d Menit", $jam, $menit);

                $total_jarak = (float)$item->estimasi_jarak * 2;
                $km_akhir = number_format($total_jarak, 2, '.', '');

                $estimasi_bbm_val = '0';
                if ($item->Kendaraan && is_numeric($km_akhir) && $item->Kendaraan->km_per_liter > 0) {
                    $km_akhir_numeric = (float) $km_akhir;
                    $estimasi_bbm_val = $km_akhir_numeric / $item->Kendaraan->km_per_liter;
                }

                $totalEstimasiJarak += $total_jarak;
                $totalEstimasiBBM += (float)$estimasi_bbm_val;
                $totalDurasiMenit += $durasi;
                $totalKmManual += (float)$item->total_km_manual;

                fputcsv($handle, [
                    $index + 1,
                    $nama_pegawai_formatted,
                    $item->tujuan_perjalanan,
                    $item->titik_awal,
                    $item->titik_akhir,
                    $jam_pergi->format('d/m/Y H:i'),
                    $jam_kembali->format('d/m/Y H:i'),
                    $km_akhir . " KM",
                    number_format((float)$estimasi_bbm_val, 2, '.', '') . " Liter",
                    $durasi_format,
                    $item->total_km_manual ? $item->total_km_manual . ' KM' : '-',
                    $item->validator ? $item->validator->nama : 'N/A'
                ], ';');
            }

            $totalDurasiJam = floor($totalDurasiMenit / 60);
            $totalDurasiSisaMenit = $totalDurasiMenit % 60;
            $totalDurasiFormat = sprintf("%d Jam %02d Menit", $totalDurasiJam, $totalDurasiSisaMenit);

            fputcsv($handle, [], ';');
            fputcsv($handle, ['Ringkasan Perjalanan'], ';');
            fputcsv($handle, ['Total Estimasi Jarak', number_format($totalEstimasiJarak, 2, ',', '.') . ' KM'], ';');
            fputcsv($handle, ['Total Estimasi BBM', number_format($totalEstimasiBBM, 2, ',', '.') . ' Liter'], ';');
            fputcsv($handle, ['Total Durasi Perjalanan', $totalDurasiFormat], ';');
            fputcsv($handle, ['Total KM Manual', number_format($totalKmManual, 2, ',', '.') . ' KM'], ';');
            fputcsv($handle, ['Total Perjalanan', count($perjalanan)], ';');

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="laporan-perjalanan.csv"');

        return $response;
    }
}
