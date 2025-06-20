<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\InspeksiKendaraan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KendaraanController extends Controller
{
    public function viewKendaraan(Request $request)
    {
        // Mengambil semua data kendaraan
        $kendaraan = Kendaraan::get();

        // Logika untuk Laporan Inspeksi Pengemudi (sama seperti Driver)
        $selectedMonth = $request->input('bulan', Carbon::now()->month);
        $selectedYear = $request->input('tahun', Carbon::now()->year);

        $inspeksiSummary = DB::table('inspeksi_kendaraan')
            ->join('users', 'inspeksi_kendaraan.user_id', '=', 'users.id')
            ->select('users.nama as nama_pengemudi', DB::raw('count(inspeksi_kendaraan.id) as total_inspeksi'))
            ->whereYear('inspeksi_kendaraan.tanggal_inspeksi', $selectedYear)
            ->whereMonth('inspeksi_kendaraan.tanggal_inspeksi', $selectedMonth)
            ->whereNotNull('inspeksi_kendaraan.user_id')
            ->groupBy('users.id', 'users.nama')
            ->orderBy('total_inspeksi', 'desc')
            ->get();

        $availableYears = DB::table('inspeksi_kendaraan')
            ->select(DB::raw('DISTINCT YEAR(tanggal_inspeksi) as year'))
            ->whereNotNull('tanggal_inspeksi')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $allMonths = collect(range(1, 12));

        return view('managerarea.kendaraan', compact(
            'kendaraan',
            'inspeksiSummary',
            'selectedMonth',
            'selectedYear',
            'availableYears',
            'allMonths'
        ));
    }

    public function showInspectionHistory(Request $request, Kendaraan $kendaraan)
    {
        $inspectionsQuery = $kendaraan->inspeksis()->with('user');

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($startDate) {
            $inspectionsQuery->whereDate('tanggal_inspeksi', '>=', $startDate);
        }
        if ($endDate) {
            $inspectionsQuery->whereDate('tanggal_inspeksi', '<=', $endDate);
        }

        $inspections = $inspectionsQuery->latest('tanggal_inspeksi')->get();

        // Kartu Top Inspector di-nonaktifkan di view, jadi logikanya bisa disederhanakan/dihapus jika tidak perlu
        $topInspector = null;

        return view('managerarea.history_inspeksi', compact('kendaraan', 'inspections', 'topInspector', 'startDate', 'endDate'));
    }

    public function showInspectionDetail(InspeksiKendaraan $inspeksi)
    {
        $inspeksi->load('kendaraan', 'user');
        return view('managerarea.showinspeksi', compact('inspeksi'));
    }
}
