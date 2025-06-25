<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Events\PerjalananStatusUpdated;
use App\Models\InspeksiKendaraan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Log; // Import Log

class PersetujuanController extends Controller
{
    public function viewPersetujuan()
    {
        // Eager load relasi kendaraan dan inspeksi terakhir
        $perjalanan = LaporanPerjalanan::with(['user', 'kendaraan', 'kendaraan.riwayatInspeksi' => function ($query) {
            $query->latest(); // Cukup latest() saja, ->first() dilakukan di bawah.
        }])->where('status', 'menunggu validasi')->get();

        return view('managerarea.persetujuanperjalanan', compact('perjalanan'));
    }

    public function validasi($id)
    {
        DB::beginTransaction();
        try {
            $perjalanan = LaporanPerjalanan::where('id', $id)->lockForUpdate()->firstOrFail();

            Log::info('PersetujuanController@validasi - START');
            Log::info('  Perjalanan ID: ' . $perjalanan->id);
            Log::info('  Status Perjalanan: ' . $perjalanan->status);

            if ($perjalanan->status !== 'menunggu validasi') {
                Log::info('PersetujuanController@validasi - Status perjalanan bukan menunggu validasi.');
                return response()->json(['message' => 'Perjalanan ini tidak bisa divalidasi.'], 422);
            }

            $kendaraan = $perjalanan->kendaraan;

            Log::info('PersetujuanController@validasi - BEFORE in_use check:');
            Log::info('  Kendaraan ID: ' . $kendaraan->id);
            Log::info('  Status Kendaraan: ' . $kendaraan->status);


            if ($kendaraan->status !== 'in_use') { // <---  CEK HARUS !==
                Log::warning('PersetujuanController@validasi - Kendaraan TIDAK in_use! Ini tidak seharusnya terjadi.'); // Gunakan Log::warning()
                DB::rollBack(); // Sebaiknya rollback, karena ini kondisi yang tidak normal.
                return response()->json(['message' => 'Status kendaraan tidak valid.  Tidak bisa memvalidasi perjalanan.'], 422);
            }

            $perjalanan->status = 'disetujui';
            $perjalanan->validated_by = Auth::id();
            $perjalanan->save();


            // $kendaraan->status = 'in_use';  // <--- TETAP in_use
            // $kendaraan->save();

            Log::info('PersetujuanController@validasi - AFTER in_use set (harusnya tidak berubah):'); // Ganti pesan log
            Log::info('  Status Kendaraan: ' . $kendaraan->status);

            PerjalananStatusUpdated::dispatch($perjalanan, 'disetujui');
            DB::commit();
            return response()->json(['message' => 'Perjalanan berhasil divalidasi.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error validasi perjalanan: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat memvalidasi perjalanan.'], 500);
        }
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $perjalanan = LaporanPerjalanan::findOrFail($id);

            if ($perjalanan->status !== 'menunggu validasi') {
                DB::rollBack();
                return response()->json(['message' => 'Perjalanan ini tidak dapat ditolak.'], 422);
            }

            $perjalanan->status = 'ditolak';
            $perjalanan->alasan = $request->alasan;
            $perjalanan->validated_by = Auth::id();
            $perjalanan->save();

            $kendaraan = $perjalanan->kendaraan;

            // Perbaikan di sini: Gunakan previous_kendaraan_status
            if ($kendaraan->status === 'in_use') { // Tetap cek untuk menghindari overwrite
                $kendaraan->status = $perjalanan->previous_kendaraan_status; // KEMBALIKAN KE STATUS SEMULA
                $kendaraan->save();
            }

            PerjalananStatusUpdated::dispatch($perjalanan, 'ditolak');
            DB::commit();
            return response()->json(['message' => 'Perjalanan berhasil ditolak dengan alasan: ' . $request->alasan]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saat menolak perjalanan (ID: $id): " . $e->getMessage() . "\n" . $e->getTraceAsString()); //  Log stack trace juga
            return response()->json(['message' => 'Terjadi kesalahan saat menolak perjalanan.', 'error' => $e->getMessage()], 500);
        }
    }
}
