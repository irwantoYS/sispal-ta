<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\LaporanPerjalanan; // Tidak perlu jika hanya menampilkan staff
// use Illuminate\Support\Facades\Auth; // Tidak perlu jika tidak terkait user login
// use Barryvdh\DomPDF\Facade\Pdf; // Tidak perlu untuk halaman ini
// use carbon\Carbon; // Tidak perlu untuk halaman ini
use App\Models\User; // Tambahkan model User
use Illuminate\Support\Facades\DB; // Untuk OrderByRaw

class HomeController extends Controller
{
    public function landingpage()
    {
        // Ambil data staff dengan role yang diinginkan
        $roles = ['ManagerArea', 'HSSE', 'Driver'];

        $staff = User::whereIn('role', $roles)
            ->select('nama', 'role', 'image') // Ambil kolom yang dibutuhkan
            ->orderByRaw("FIELD(role, 'ManagerArea', 'HSSE', 'Driver')") // Urutkan berdasarkan role
            ->take(4) // Ambil maksimal 4 staff pertama sesuai urutan role
            ->get();

        return view('welcome', compact('staff')); // Kirim data staff ke view
    }
}
