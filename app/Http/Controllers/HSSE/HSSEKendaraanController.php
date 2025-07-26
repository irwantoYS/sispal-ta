<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\InspeksiKendaraan;
use Carbon\Carbon;
use App\Models\User;

class HSSEKendaraanController extends Controller
{
    public function viewTambahKendaraan(Request $request)
    {
        $tambahkendaraan = Kendaraan::where('is_active', true)->get();

        // Logic for inspection summary
        $selectedMonth = $request->input('bulan', Carbon::now()->month);
        $selectedYear = $request->input('tahun', Carbon::now()->year);

        $inspeksiSummary = InspeksiKendaraan::selectRaw('user_id, count(*) as total_inspeksi')
            ->whereMonth('tanggal_inspeksi', $selectedMonth)
            ->whereYear('tanggal_inspeksi', $selectedYear)
            ->groupBy('user_id')
            ->orderBy('total_inspeksi', 'desc')
            ->with('user') // Eager load user
            ->get();

        // Attach user name to the summary
        $inspeksiSummary->each(function ($summary) {
            $summary->nama_pengemudi = $summary->user->nama ?? 'Pengemudi tidak ditemukan';
        });

        // Get available years for the filter dropdown
        $availableYears = InspeksiKendaraan::selectRaw('YEAR(tanggal_inspeksi) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $allMonths = range(1, 12);

        return view('hsse.tambahkendaraan', compact(
            'tambahkendaraan',
            'inspeksiSummary',
            'selectedMonth',
            'selectedYear',
            'availableYears',
            'allMonths'
        ));
    }

    public function storeTambahKendaraan(Request $request)
    {
        // Validasi data permintaan
        $validatedData = $request->validate([
            'no_kendaraan' => 'required|string|max:255',
            'merk_kendaraan' => 'required|string|max:255',
            'model_mobil' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:6000',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            Log::info('Image uploaded path: ' . $imagePath);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gambar diperlukan'
            ], 400);
        }

        // Membuat entri Kendaraan baru dengan status default 'ready'
        Kendaraan::create([
            'no_kendaraan' => $request->input('no_kendaraan'),
            'tipe_kendaraan' => $request->input('merk_kendaraan') . ' || ' . $request->input('model_mobil'),
            'km_per_liter' => $request->input('km_per_liter'),
            'status' => 'ready', // Status default diatur menjadi 'ready'
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil ditambahkan!']);
    }

    public function updateTambahKendaraan(Request $request, $id)
    {
        // Validasi data permintaan
        $validatedData = $request->validate([
            'no_kendaraan' => 'required|string|max:255',
            'merk_kendaraan' => 'required|string|max:255',
            'model_mobil' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:6000',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);

        $kendaraan->no_kendaraan = $request->input('no_kendaraan');
        $kendaraan->tipe_kendaraan = $request->input('merk_kendaraan') . ' || ' . $request->input('model_mobil');
        $kendaraan->km_per_liter = $request->input('km_per_liter');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }

            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $kendaraan->image = $imagePath;
        }

        $kendaraan->save();

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil diupdate!']);
    }

    public function deactivateKendaraan($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $ongoingTrip = LaporanPerjalanan::where('kendaraan_id', $kendaraan->id)
            ->whereNotIn('status', ['disetujui', 'ditolak'])->exists();
        if ($ongoingTrip) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menonaktifkan, kendaraan masih memiliki perjalanan yang belum selesai.'
            ], 400);
        }

        $kendaraan->is_active = false;
        $kendaraan->save();

        return response()->json(['success' => true, 'message' => 'Data kendaraan berhasil dinonaktifkan!']);
    }

    public function show(InspeksiKendaraan $inspeksi)
    {
        // Memuat relasi 'kendaraan' untuk efisiensi dan mengirimkannya ke view
        $inspeksi->load('kendaraan', 'user');
        return view('hsse.showinspeksi', compact('inspeksi'));
    }

    /**
     * Display a listing of the active vehicles.
     */
    public function index(Request $request)
    {
        $kendaraan = Kendaraan::where('is_active', true)->get();

        $selectedMonth = $request->input('bulan', Carbon::now()->month);
        $selectedYear = $request->input('tahun', Carbon::now()->year);

        $inspeksiQuery = InspeksiKendaraan::query()
            ->join('users', 'inspeksi_kendaraans.user_id', '=', 'users.id')
            ->selectRaw('users.nama as nama_pengemudi, COUNT(inspeksi_kendaraans.id) as total_inspeksi')
            ->whereMonth('inspeksi_kendaraans.tanggal_inspeksi', $selectedMonth)
            ->whereYear('inspeksi_kendaraans.tanggal_inspeksi', $selectedYear)
            ->groupBy('users.nama')
            ->orderBy('total_inspeksi', 'desc');

        $inspeksiSummary = $inspeksiQuery->get();
        $allMonths = range(1, 12);
        $availableYears = InspeksiKendaraan::selectRaw('YEAR(tanggal_inspeksi) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $topInspector = InspeksiKendaraan::with('user')->get()->groupBy('user_id')->map(function ($group) {
            return [
                'user' => $group->first()->user,
                'count' => $group->count(),
            ];
        })->sortByDesc('count')->first();

        return view('hsse.tambahkendaraan', compact('kendaraan', 'topInspector', 'inspeksiSummary', 'selectedMonth', 'selectedYear', 'allMonths', 'availableYears'));
    }

    /**
     * Display a listing of the deactivated vehicles.
     */
    public function showDeactivated()
    {
        $kendaraan = Kendaraan::where('is_active', false)->get();
        return view('hsse.kendaraan_nonaktif', compact('kendaraan'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kendaraan' => 'required|string|max:255|unique:kendaraan,no_kendaraan',
            'tipe_kendaraan' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kendaraan = new Kendaraan($request->only(['no_kendaraan', 'tipe_kendaraan', 'km_per_liter']));
        $kendaraan->status = 'ready';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('kendaraan_images', 'public');
            $kendaraan->image = $path;
        }

        $kendaraan->save();

        return redirect()->route('hsse.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return view('hsse.editkendaraan', compact('kendaraan'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kendaraan' => 'required|string|max:255|unique:kendaraan,no_kendaraan,' . $id,
            'tipe_kendaraan' => 'required|string|max:255',
            'km_per_liter' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->fill($request->only(['no_kendaraan', 'tipe_kendaraan', 'km_per_liter']));

        if ($request->hasFile('image')) {
            if ($kendaraan->image && Storage::exists('public/' . $kendaraan->image)) {
                Storage::delete('public/' . $kendaraan->image);
            }
            $path = $request->file('image')->store('kendaraan_images', 'public');
            $kendaraan->image = $path;
        }

        $kendaraan->save();

        return redirect()->route('hsse.kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Deactivate the specified vehicle.
     */
    public function deactivate($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->is_active = false;
        $kendaraan->save();

        return redirect()->route('hsse.kendaraan.index')->with('success', 'Kendaraan berhasil dinonaktifkan.');
    }

    /**
     * Activate the specified vehicle.
     */
    public function activate($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->is_active = true;
        $kendaraan->save();

        return redirect()->route('hsse.kendaraan.nonaktif')->with('success', 'Kendaraan berhasil diaktifkan kembali.');
    }

    /**
     * Display the inspection history for a specific vehicle.
     */
    public function showInspectionHistory(Request $request, $kendaraan_id)
    {
        $kendaraan = Kendaraan::with('inspeksis.user')->findOrFail($kendaraan_id);
        $query = $kendaraan->inspeksis();

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_inspeksi', [$startDate, $endDate]);
        }

        $inspections = $query->orderBy('tanggal_inspeksi', 'desc')->get();
        return view('hsse.history_inspeksi', compact('kendaraan', 'inspections', 'startDate', 'endDate'));
    }
}
