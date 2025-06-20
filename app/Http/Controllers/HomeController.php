<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Tambahkan model User
use Illuminate\Support\Facades\DB; // Untuk OrderByRaw
use App\Models\LaporanPerjalanan; // Tambahkan model LaporanPerjalanan
use Carbon\Carbon; // Tambahkan Carbon
use App\Models\InspeksiKendaraan;

class HomeController extends Controller
{
    public function landingpage()
    {
        // Ambil data staff dengan role yang diinginkan
        $roles = ['ManagerArea', 'HSSE', 'Driver'];

        $staff = User::whereIn('role', $roles)
            ->select('nama', 'role', 'image') // Ambil kolom yang dibutuhkan
            ->orderByRaw("FIELD(role, 'ManagerArea', 'HSSE', 'Driver')") // Urutkan berdasarkan role

            ->get();

        // Ambil data Top 3 Driver Bulan Ini
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $monthName = $now->translatedFormat('F'); // Ambil nama bulan (misal: April)
        // Pastikan locale Carbon diatur di AppServiceProvider jika ingin bahasa Indonesia: Carbon::setLocale('id');

        $topDrivers = LaporanPerjalanan::query()
            ->join('users', 'laporan_perjalanan.pengemudi_id', '=', 'users.id')
            ->whereNotNull('laporan_perjalanan.jam_kembali')
            ->whereBetween('laporan_perjalanan.jam_kembali', [$startOfMonth, $endOfMonth])
            ->select(
                'users.nama',
                'users.image',
                'laporan_perjalanan.pengemudi_id',
                DB::raw('COUNT(laporan_perjalanan.id) as total_perjalanan'), // Tambahkan COUNT
                DB::raw('SUM(laporan_perjalanan.km_akhir) as total_jarak'),
                DB::raw('SUM(TIMESTAMPDIFF(MINUTE, laporan_perjalanan.jam_pergi, laporan_perjalanan.jam_kembali)) as total_durasi_menit')
            )
            ->groupBy('users.nama', 'users.image', 'laporan_perjalanan.pengemudi_id')
            ->orderByDesc('total_jarak') // Urutkan berdasarkan total jarak
            ->limit(3) // Ambil 3 teratas
            ->get();

        // Format durasi untuk top drivers
        foreach ($topDrivers as $driver) {
            $totalDurasiMenit = $driver->total_durasi_menit ?? 0;
            $jam = floor($totalDurasiMenit / 60);
            $menit = $totalDurasiMenit % 60;
            $driver->total_durasi_format = sprintf("%02d Jam %02d Menit", $jam, $menit);
        }

        $topInspectors = InspeksiKendaraan::query()
            ->join('users', 'inspeksi_kendaraan.user_id', '=', 'users.id')
            ->whereBetween('inspeksi_kendaraan.tanggal_inspeksi', [$startOfMonth, $endOfMonth])
            ->select(
                'users.nama',
                'users.image',
                DB::raw('COUNT(inspeksi_kendaraan.id) as total_inspeksi')
            )
            ->groupBy('users.nama', 'users.image')
            ->orderByDesc('total_inspeksi')
            ->limit(3)
            ->get();

        // Kirim data staff, topDrivers, dan monthName ke view
        return view('welcome', compact('staff', 'topDrivers', 'monthName', 'topInspectors'));
    }
}
