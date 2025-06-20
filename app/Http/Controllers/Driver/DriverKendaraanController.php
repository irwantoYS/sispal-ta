<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\InspeksiKendaraan; // Import model InspeksiKendaraan
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DriverKendaraanController extends Controller
{
    public function viewKendaraan(Request $request)
    {
        // Mengambil semua data kendaraan
        $kendaraan = Kendaraan::with('inspeksis')->get();

        // --- Logika untuk Laporan Inspeksi Pengemudi ---
        $selectedMonth = $request->input('bulan', Carbon::now()->month);
        $selectedYear = $request->input('tahun', Carbon::now()->year);

        // Query untuk rekap inspeksi
        $inspeksiSummary = DB::table('inspeksi_kendaraan')
            ->join('users', 'inspeksi_kendaraan.user_id', '=', 'users.id')
            ->select('users.nama as nama_pengemudi', DB::raw('count(inspeksi_kendaraan.id) as total_inspeksi'))
            ->whereYear('inspeksi_kendaraan.tanggal_inspeksi', $selectedYear)
            ->whereMonth('inspeksi_kendaraan.tanggal_inspeksi', $selectedMonth)
            ->whereNotNull('inspeksi_kendaraan.user_id')
            ->groupBy('users.id', 'users.nama')
            ->orderBy('total_inspeksi', 'desc')
            ->get();

        // Ambil tahun yang tersedia untuk filter
        $availableYears = DB::table('inspeksi_kendaraan')
            ->select(DB::raw('DISTINCT YEAR(tanggal_inspeksi) as year'))
            ->whereNotNull('tanggal_inspeksi')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Buat daftar 12 bulan untuk filter
        $allMonths = collect(range(1, 12));

        return view('driver.kendaraan', compact(
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

        // The top inspector card should reflect all-time stats for this vehicle.
        // So we calculate it from all inspections, not the filtered ones.
        $allInspectionsForVehicle = $kendaraan->inspeksis()->with('user')->get();
        $topInspector = null;
        if ($allInspectionsForVehicle->isNotEmpty()) {
            $topInspector = $allInspectionsForVehicle->groupBy('user_id')
                ->map(function ($group) {
                    if ($group->first()->user) {
                        return [
                            'user' => $group->first()->user,
                            'count' => $group->count(),
                        ];
                    }
                    return null;
                })
                ->filter()
                ->sortByDesc('count')
                ->first();
        }

        return view('driver.history_inspeksi', compact('kendaraan', 'inspections', 'topInspector', 'startDate', 'endDate'));
    }

    public function viewInspeksi($kendaraanId)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraanId);

        // Cek status kendaraan
        if ($kendaraan->status === 'in_use') {
            return redirect()->route('driver.kendaraan')
                ->with('error', 'Kendaraan sedang digunakan dan tidak dapat diinspeksi.');
        }

        return view('driver.inspeksi_kendaraan', compact('kendaraan'));
    }

    public function storeInspeksi(Request $request, $kendaraanId)
    {
        $kendaraan = Kendaraan::findOrFail($kendaraanId);

        // --- VALIDASI ---
        $request->validate([
            'tanggal_inspeksi' => 'required|date',
            // Validasi untuk semua item inspeksi kendaraan (sesuai formulir)
            'body_baik' => 'required|in:0,1',
            'body_keterangan' => 'nullable|string',
            'ban_baik' => 'required|in:0,1',
            'ban_keterangan' => 'nullable|string',
            'stir_baik' => 'required|in:0,1',
            'stir_keterangan' => 'nullable|string',
            'rem_kaki_tangan_baik' => 'required|in:0,1',
            'rem_kaki_tangan_keterangan' => 'nullable|string',
            'pedal_kopling_gas_rem_baik' => 'required|in:0,1',
            'pedal_kopling_gas_rem_keterangan' => 'nullable|string',
            'starter_baik' => 'required|in:0,1',
            'starter_keterangan' => 'nullable|string',
            'oli_mesin_baik' => 'required|in:0,1',
            'oli_mesin_keterangan' => 'nullable|string',
            'tangki_bb_pompa_baik' => 'required|in:0,1',
            'tangki_bb_pompa_keterangan' => 'nullable|string',
            'radiator_pompa_fanbelt_baik' => 'required|in:0,1',
            'radiator_pompa_fanbelt_keterangan' => 'nullable|string',
            'transmisi_baik' => 'required|in:0,1',
            'transmisi_keterangan' => 'nullable|string',
            'knalpot_baik' => 'required|in:0,1',
            'knalpot_keterangan' => 'nullable|string',
            'klakson_baik' => 'required|in:0,1',
            'klakson_keterangan' => 'nullable|string',
            'alarm_mundur_baik' => 'required|in:0,1',
            'alarm_mundur_keterangan' => 'nullable|string',
            'lampu_depan_baik' => 'required|in:0,1',
            'lampu_depan_keterangan' => 'nullable|string',
            'lampu_sign_baik' => 'required|in:0,1',
            'lampu_sign_keterangan' => 'nullable|string',
            'lampu_kabin_pintu_baik' => 'required|in:0,1',
            'lampu_kabin_pintu_keterangan' => 'nullable|string',
            'lampu_rem_baik' => 'required|in:0,1',
            'lampu_rem_keterangan' => 'nullable|string',
            'lampu_mundur_baik' => 'required|in:0,1',
            'lampu_mundur_keterangan' => 'nullable|string',
            'lampu_drl_baik' => 'required|in:0,1',
            'lampu_drl_keterangan' => 'nullable|string',
            'indikator_kecepatan_baik' => 'required|in:0,1',
            'indikator_kecepatan_keterangan' => 'nullable|string',
            'indikator_bb_baik' => 'required|in:0,1',
            'indikator_bb_keterangan' => 'nullable|string',
            'indikator_temperatur_baik' => 'required|in:0,1',
            'indikator_temperatur_keterangan' => 'nullable|string',
            'lampu_depan_belakang_baik' => 'required|in:0,1',
            'lampu_depan_belakang_keterangan' => 'nullable|string',
            'lampu_rem2_baik' => 'required|in:0,1',
            'lampu_rem2_keterangan' => 'nullable|string',
            'baut_roda_baik' => 'required|in:0,1',
            'baut_roda_keterangan' => 'nullable|string',
            'jendela_baik' => 'required|in:0,1',
            'jendela_keterangan' => 'nullable|string',
            'wiper_washer_baik' => 'required|in:0,1',
            'wiper_washer_keterangan' => 'nullable|string',
            'spion_baik' => 'required|in:0,1',
            'spion_keterangan' => 'nullable|string',
            'kunci_pintu_baik' => 'required|in:0,1',
            'kunci_pintu_keterangan' => 'nullable|string',
            'kursi_baik' => 'required|in:0,1',
            'kursi_keterangan' => 'nullable|string',
            'sabuk_keselamatan_baik' => 'required|in:0,1',
            'sabuk_keselamatan_keterangan' => 'nullable|string',
            'apar_baik' => 'required|in:0,1',
            'apar_keterangan' => 'nullable|string',
            'perlengkapan_kebocoran_baik' => 'required|in:0,1',
            'perlengkapan_kebocoran_keterangan' => 'nullable|string',
            'segitiga_pengaman_baik' => 'required|in:0,1',
            'segitiga_pengaman_keterangan' => 'nullable|string',
            'safety_cone_baik' => 'required|in:0,1',
            'safety_cone_keterangan' => 'nullable|string',
            'dongkrak_kunci_baik' => 'required|in:0,1',
            'dongkrak_kunci_keterangan' => 'nullable|string',
            'ganjal_ban_baik' => 'required|in:0,1',
            'ganjal_ban_keterangan' => 'nullable|string',
            'kotak_p3k_baik' => 'required|in:0,1',
            'kotak_p3k_keterangan' => 'nullable|string',
            'dokumen_rutin_baik' => 'required|in:0,1',
            'dokumen_rutin_keterangan' => 'nullable|string',
            'dokumen_service_baik' => 'required|in:0,1',
            'dokumen_service_keterangan' => 'nullable|string',

            // Validasi untuk kondisi pengemudi
            'pengemudi_sehat_baik' => 'required|in:0,1',
            'pengemudi_sehat_keterangan' => 'nullable|string',
            'pengemudi_istirahat_baik' => 'required|in:0,1',
            'pengemudi_istirahat_keterangan' => 'nullable|string',
            'pengemudi_mabuk_baik' => 'required|in:0,1',
            'pengemudi_mabuk_keterangan' => 'nullable|string',
            'pengemudi_obat_baik' => 'required|in:0,1',
            'pengemudi_obat_keterangan' => 'nullable|string',
            'catatan' => 'nullable|string',

        ]);

        // --- LOGIKA PENENTUAN STATUS KENDARAAN ---
        $status = 'ready';  // Default: baik
        // Cek *semua* field boolean yang terkait dengan kondisi *KENDARAAN*.
        // Jika *salah satu* bernilai 0 (false/Tidak Baik/Rusak), ubah status menjadi 'perlu_perbaikan'.
        if (
            $request->body_baik == 0 || $request->ban_baik == 0 || $request->stir_baik == 0 ||
            $request->rem_kaki_tangan_baik == 0 || $request->pedal_kopling_gas_rem_baik == 0 ||
            $request->starter_baik == 0 || $request->oli_mesin_baik == 0 ||
            $request->tangki_bb_pompa_baik == 0 || $request->radiator_pompa_fanbelt_baik == 0 ||
            $request->transmisi_baik == 0 || $request->knalpot_baik == 0 || $request->klakson_baik == 0 ||
            $request->alarm_mundur_baik == 0 || $request->lampu_depan_baik == 0 ||
            $request->lampu_sign_baik == 0 || $request->lampu_kabin_pintu_baik == 0 ||
            $request->lampu_rem_baik == 0 || $request->lampu_mundur_baik == 0 || $request->lampu_drl_baik == 0 ||
            $request->indikator_kecepatan_baik == 0 || $request->indikator_bb_baik == 0 ||
            $request->indikator_temperatur_baik == 0 || $request->lampu_depan_belakang_baik == 0 ||
            $request->lampu_rem2_baik == 0 || $request->baut_roda_baik == 0 || $request->jendela_baik == 0 ||
            $request->wiper_washer_baik == 0 || $request->spion_baik == 0 ||
            $request->kunci_pintu_baik == 0 || $request->kursi_baik == 0 || $request->sabuk_keselamatan_baik == 0 ||
            $request->apar_baik == 0 || $request->perlengkapan_kebocoran_baik == 0 ||
            $request->segitiga_pengaman_baik == 0 || $request->safety_cone_baik == 0 ||
            $request->dongkrak_kunci_baik == 0 || $request->ganjal_ban_baik == 0 || $request->kotak_p3k_baik == 0 ||
            $request->dokumen_rutin_baik == 0 || $request->dokumen_service_baik == 0
        ) {
            $status = 'perlu_perbaikan';
        }
        // Kondisi pengemudi *TIDAK* memengaruhi status kendaraan.

        // --- PENYIMPANAN DATA ---
        $inspeksi = InspeksiKendaraan::create([
            'kendaraan_id' => $kendaraanId,
            'user_id' => Auth::id(), // ID driver yang login
            'tanggal_inspeksi' => $request->tanggal_inspeksi,

            // Data Kendaraan (sesuaikan dengan nama field di form dan migrasi)
            'body_baik' => $request->body_baik,
            'body_keterangan' => $request->body_keterangan,
            'ban_baik' => $request->ban_baik,
            'ban_keterangan' => $request->ban_keterangan,
            'stir_baik' => $request->stir_baik,
            'stir_keterangan' => $request->stir_keterangan,
            'rem_kaki_tangan_baik' => $request->rem_kaki_tangan_baik,
            'rem_kaki_tangan_keterangan' => $request->rem_kaki_tangan_keterangan,
            'pedal_kopling_gas_rem_baik' => $request->pedal_kopling_gas_rem_baik,
            'pedal_kopling_gas_rem_keterangan' => $request->pedal_kopling_gas_rem_keterangan,
            'starter_baik' => $request->starter_baik,
            'starter_keterangan' => $request->starter_keterangan,
            'oli_mesin_baik' => $request->oli_mesin_baik,
            'oli_mesin_keterangan' => $request->oli_mesin_keterangan,
            'tangki_bb_pompa_baik' => $request->tangki_bb_pompa_baik,
            'tangki_bb_pompa_keterangan' => $request->tangki_bb_pompa_keterangan,
            'radiator_pompa_fanbelt_baik' => $request->radiator_pompa_fanbelt_baik,
            'radiator_pompa_fanbelt_keterangan' => $request->radiator_pompa_fanbelt_keterangan,
            'transmisi_baik' => $request->transmisi_baik,
            'transmisi_keterangan' => $request->transmisi_keterangan,
            'knalpot_baik' => $request->knalpot_baik,
            'knalpot_keterangan' => $request->knalpot_keterangan,
            'klakson_baik' => $request->klakson_baik,
            'klakson_keterangan' => $request->klakson_keterangan,
            'alarm_mundur_baik' => $request->alarm_mundur_baik,
            'alarm_mundur_keterangan' => $request->alarm_mundur_keterangan,
            'lampu_depan_baik' => $request->lampu_depan_baik,
            'lampu_depan_keterangan' => $request->lampu_depan_keterangan,
            'lampu_sign_baik' => $request->lampu_sign_baik,
            'lampu_sign_keterangan' => $request->lampu_sign_keterangan,
            'lampu_kabin_pintu_baik' => $request->lampu_kabin_pintu_baik,
            'lampu_kabin_pintu_keterangan' => $request->lampu_kabin_pintu_keterangan,
            'lampu_rem_baik' => $request->lampu_rem_baik,
            'lampu_rem_keterangan' => $request->lampu_rem_keterangan,
            'lampu_mundur_baik' => $request->lampu_mundur_baik,
            'lampu_mundur_keterangan' => $request->lampu_mundur_keterangan,
            'lampu_drl_baik' => $request->lampu_drl_baik,
            'lampu_drl_keterangan' => $request->lampu_drl_keterangan,
            'indikator_kecepatan_baik' => $request->indikator_kecepatan_baik,
            'indikator_kecepatan_keterangan' => $request->indikator_kecepatan_keterangan,
            'indikator_bb_baik' => $request->indikator_bb_baik,
            'indikator_bb_keterangan' => $request->indikator_bb_keterangan,
            'indikator_temperatur_baik' => $request->indikator_temperatur_baik,
            'indikator_temperatur_keterangan' => $request->indikator_temperatur_keterangan,
            'lampu_depan_belakang_baik' => $request->lampu_depan_belakang_baik,
            'lampu_depan_belakang_keterangan' => $request->lampu_depan_belakang_keterangan,
            'lampu_rem2_baik' => $request->lampu_rem2_baik,
            'lampu_rem2_keterangan' => $request->lampu_rem2_keterangan,
            'baut_roda_baik' => $request->baut_roda_baik,
            'baut_roda_keterangan' => $request->baut_roda_keterangan,
            'jendela_baik' => $request->jendela_baik,
            'jendela_keterangan' => $request->jendela_keterangan,
            'wiper_washer_baik' => $request->wiper_washer_baik,
            'wiper_washer_keterangan' => $request->wiper_washer_keterangan,
            'spion_baik' => $request->spion_baik,
            'spion_keterangan' => $request->spion_keterangan,
            'kunci_pintu_baik' => $request->kunci_pintu_baik,
            'kunci_pintu_keterangan' => $request->kunci_pintu_keterangan,
            'kursi_baik' => $request->kursi_baik,
            'kursi_keterangan' => $request->kursi_keterangan,
            'sabuk_keselamatan_baik' => $request->sabuk_keselamatan_baik,
            'sabuk_keselamatan_keterangan' => $request->sabuk_keselamatan_keterangan,
            'apar_baik' => $request->apar_baik,
            'apar_keterangan' => $request->apar_keterangan,
            'perlengkapan_kebocoran_baik' => $request->perlengkapan_kebocoran_baik,
            'perlengkapan_kebocoran_keterangan' => $request->perlengkapan_kebocoran_keterangan,
            'segitiga_pengaman_baik' => $request->segitiga_pengaman_baik,
            'segitiga_pengaman_keterangan' => $request->segitiga_pengaman_keterangan,
            'safety_cone_baik' => $request->safety_cone_baik,
            'safety_cone_keterangan' => $request->safety_cone_keterangan,
            'dongkrak_kunci_baik' => $request->dongkrak_kunci_baik,
            'dongkrak_kunci_keterangan' => $request->dongkrak_kunci_keterangan,
            'ganjal_ban_baik' => $request->ganjal_ban_baik,
            'ganjal_ban_keterangan' => $request->ganjal_ban_keterangan,
            'kotak_p3k_baik' => $request->kotak_p3k_baik,
            'kotak_p3k_keterangan' => $request->kotak_p3k_keterangan,
            'dokumen_rutin_baik' => $request->dokumen_rutin_baik,
            'dokumen_rutin_keterangan' => $request->dokumen_rutin_keterangan,
            'dokumen_service_baik' => $request->dokumen_service_baik,
            'dokumen_service_keterangan' => $request->dokumen_service_keterangan,

            // Data Pengemudi (sesuai dengan formulir)
            'pengemudi_sehat_baik' => $request->pengemudi_sehat_baik,
            'pengemudi_sehat_keterangan' => $request->pengemudi_sehat_keterangan,
            'pengemudi_istirahat_baik' => $request->pengemudi_istirahat_baik,
            'pengemudi_istirahat_keterangan' => $request->pengemudi_istirahat_keterangan,
            'pengemudi_mabuk_baik' => $request->pengemudi_mabuk_baik,
            'pengemudi_mabuk_keterangan' => $request->pengemudi_mabuk_keterangan,
            'pengemudi_obat_baik' => $request->pengemudi_obat_baik,
            'pengemudi_obat_keterangan' => $request->pengemudi_obat_keterangan,

            'catatan' => $request->catatan,
            'status' => $status, // Status *kendaraan* (bukan status perjalanan)
        ]);

        // Update status kendaraan *berdasarkan hasil inspeksi kendaraan*.
        // Kondisi pengemudi TIDAK memengaruhi status kendaraan.
        $kendaraan->update(['status' => $status]);

        return redirect()->route('driver.kendaraan')->with('success', 'Inspeksi kendaraan berhasil disimpan.');
    }

    public function create()
    {
        return view('driver.create_kendaraan');
    }
}
