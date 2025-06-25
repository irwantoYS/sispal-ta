<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPerjalanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use carbon\Carbon;
use App\Models\InspeksiKendaraan;


class PDFController extends Controller
{
    public function cetakPDF(Request $request, $role)
    {
        // Validasi role yang diterima
        if (!in_array($role, ['Driver', 'HSSE', 'ManagerArea'])) {
            abort(404, 'Role tidak ditemukan');
        }

        // Data awal
        $data = [];
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $search = $request->input('search');

        // Query dasar
        $query = LaporanPerjalanan::query()
            ->with('validator')
            ->whereNotNull('bbm_akhir')
            ->whereNotNull('jam_kembali');

        // Filter berdasarkan role
        if ($role === 'Driver' || $role === 'ManagerArea') {
            $data['title'] = 'History Laporan Perjalanan Pengguna';
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
            $data['title'] = 'History Laporan Perjalanan';
            $query->whereNotNull('nama_pegawai')
                ->whereNotNull('titik_awal')
                ->whereNotNull('titik_akhir')
                ->whereNotNull('tujuan_perjalanan');
        }

        // Filter berdasarkan rentang tanggal
        if ($startDate) {
            $query->whereDate('jam_pergi', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('jam_pergi', '<=', $endDate);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('nama_pegawai', 'like', "%$search%")
                    ->orWhere('titik_awal', 'like', "%$search%")
                    ->orWhere('titik_akhir', 'like', "%$search%")
                    ->orWhere('tujuan_perjalanan', 'like', "%$search%");
            });
        }

        // Ambil data yang sesuai
        $data['perjalanan'] = $query->get();

        // Hitung ulang durasi, km_akhir, dan estimasi_bbm dengan benar
        foreach ($data['perjalanan'] as $item) {
            $jam_pergi = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_pergi, 'Asia/Jakarta');
            $jam_kembali = Carbon::createFromFormat('Y-m-d H:i:s', $item->jam_kembali, 'Asia/Jakarta');

            // Hitung durasi dengan urutan yang benar
            $durasi = $jam_pergi->diffInMinutes($jam_kembali);

            $jam = floor($durasi / 60);
            $menit = $durasi % 60;
            $durasi_format = sprintf("%02d Jam %02d Menit", $jam, $menit);

            // Simpan durasi ke database
            $item->estimasi_waktu = $durasi_format;

            // Menyimpan data estimasi total jarak tempuh
            $total_jarak = (float)$item->estimasi_jarak * 2;
            $item->km_akhir = number_format($total_jarak, 2, '.', ''); // Simpan sebagai angka

            // Hitung estimasi penggunaan BBM
            if ($item->Kendaraan && is_numeric($item->km_akhir)) {
                $km_akhir_numeric = (float) $item->km_akhir;
                $estimasi_bbm = $km_akhir_numeric / $item->Kendaraan->km_per_liter;
                $item->estimasi_bbm = number_format($estimasi_bbm, 2, '.', '');
            } else {
                $item->estimasi_bbm = '0';
            }
            $item->save();

            // Tambahkan properti baru untuk diformat khusus untuk tampilan di PDF
            $item->jam_pergi_formatted = $jam_pergi->format('d/m/Y H:i');
            $item->jam_kembali_formatted = $jam_kembali->format('d/m/Y H:i');
            $item->km_akhir_formatted = $item->km_akhir . " KM";
            $item->estimasi_bbm_formatted = $item->estimasi_bbm . " Liter";
        }

        // Hitung total untuk data yang difilter
        $totalEstimasiJarak = $data['perjalanan']->sum(function ($item) {
            return (float) str_replace(' KM', '', $item->km_akhir);
        });
        $totalEstimasiBBM =  $data['perjalanan']->sum('estimasi_bbm');

        // Hitung total durasi
        $totalDurasiMenit = 0;
        foreach ($data['perjalanan'] as $item) {
            $totalDurasiMenit += Carbon::parse($item->jam_pergi)->diffInMinutes(Carbon::parse($item->jam_kembali));
        }

        $totalDurasiJam = floor($totalDurasiMenit / 60);
        $totalDurasiSisaMenit = $totalDurasiMenit % 60;
        $totalDurasiFormat = sprintf("%02d Jam %02d Menit", $totalDurasiJam, $totalDurasiSisaMenit);

        $data['totalEstimasiJarak'] = $totalEstimasiJarak;
        $data['totalEstimasiBBM'] = $totalEstimasiBBM;
        $data['totalDurasiFormat'] = $totalDurasiFormat;

        $pdf = PDF::loadView('pdf.laporan_perjalanan', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('laporan-perjalanan.pdf');
    }


    public function StatusPerjalananPDF(Request $request, $id)
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();


        if (!$user) {
            abort(401, 'Pengguna tidak terautentikasi.');
        }

        // Role pengguna
        $role = $user->role; // Pastikan kolom 'role' ada di tabel users

        // Cari data perjalanan berdasarkan ID dan pengemudi yang sedang login
        $data['title'] = 'Status Perjalanan';
        $perjalanan = LaporanPerjalanan::with('validator')
            ->where('id', $id)
            ->where('pengemudi_id', $user->id)
            ->first();

        if (!$perjalanan) {
            abort(404, 'Data perjalanan tidak ditemukan.');
        }

        // Menyiapkan data untuk view
        $data = [
            'perjalanan' => $perjalanan,
            'role' => $role,
            'user' => $user,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.status_perjalanan', $data)->setPaper('A4', 'portrait');

        // Ubah dari stream ke download
        return $pdf->download("status_perjalanan_{$perjalanan->id}.pdf");
    }

    public function InspeksiKendaraanPDF($id)
    {
        // Dapatkan data inspeksi kendaraan
        $inspeksi = InspeksiKendaraan::with(['kendaraan', 'user'])->findOrFail($id);

        // Siapkan data untuk view
        $data = [
            'title' => 'Laporan Inspeksi Kendaraan',
            'inspeksi' => $inspeksi,
            'kendaraan' => $inspeksi->kendaraan,
            'user' => $inspeksi->user,
            'tanggal_inspeksi' => \Carbon\Carbon::parse($inspeksi->tanggal_inspeksi)->format('d/m/Y H:i'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('pdf.inspeksi_kendaraan', $data)->setPaper('A4', 'portrait');

        // Download PDF
        return $pdf->download("inspeksi_kendaraan_{$inspeksi->kendaraan->no_kendaraan}_{$inspeksi->tanggal_inspeksi}.pdf");
    }
}
