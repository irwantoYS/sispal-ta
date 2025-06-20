<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Driver\InspeksiKendaraanController;
use App\Http\Controllers\Driver\TambahController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\Driver\DriverhistoryController;
use App\Http\Controllers\Driver\DriverKendaraanController;
use App\Http\Controllers\Driver\StatusController;
use App\Http\Controllers\HSSE\HSSEController;
use App\Http\Controllers\HSSE\HSSEHistoryController;
use App\Http\Controllers\HSSE\HSSEKelolaAkunController;
use App\Http\Controllers\HSSE\HSSEPersetujuanController;
use App\Http\Controllers\HSSE\HSSEKendaraanController;
use App\Http\Controllers\ManagerArea\HistoryController;
use App\Http\Controllers\ManagerArea\ManagerAreaController;
use App\Http\Controllers\ManagerArea\PersetujuanController;
use App\Http\Controllers\ManagerArea\KendaraanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use App\Http\Controllers\HSSE\PegawaiController;
use App\Http\Controllers\HSSE\PeminjamanController;



Route::get('/', [HomeController::class, 'landingpage'])->name('welcome');

Route::get('/login', function () {
    return view('login');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

require __DIR__ . '/auth.php';

//manager area
Route::middleware(['auth', 'ManagerAreaMiddleware'])->group(function () {
    Route::get('/managerarea/dashboard', [ManagerAreaController::class, 'dashboard'])->name('managerarea.dashboard');
    Route::get('/managerarea/persetujuan', [PersetujuanController::class, 'viewPersetujuan'])->name('managerarea.persetujuan');
    Route::put('/perjalanan/{id}/validasi', [PersetujuanController::class, 'validasi'])->name('perjalanan.validasi');
    Route::put('/perjalanan/{id}/tolak', [PersetujuanController::class, 'tolak'])->name('perjalanan.tolak');
    Route::get('/managerarea/history', [HistoryController::class,  'viewHistory'])->name('managerarea.history');
    Route::get('/managerarea/kendaraan', [KendaraanController::class, 'viewKendaraan'])->name('managerarea.kendaraan');
    Route::get('/managerarea/kendaraan/{kendaraan}/history', [KendaraanController::class, 'showInspectionHistory'])->name('managerarea.kendaraan.history');
    Route::get('/managerarea/inspeksi/show/{inspeksi}', [KendaraanController::class, 'showInspectionDetail'])->name('managerarea.showinspeksi');
});

//hsse
Route::middleware(['auth', 'HSSEMiddleware'])->group(function () {
    Route::get('/hsse/dashboard', [HSSEController::class, 'dashboard'])->name('hsse.dashboard');
    Route::get('/hsse/persetujuan', [HSSEPersetujuanController::class, 'viewPersetujuan'])->name('hsse.persetujuan');
    Route::get('/hsse/history', [HSSEHistoryController::class,  'viewHistory'])->name('hsse.history');
    Route::get('/hsse/kendaraan', [HSSEKendaraanController::class, 'viewTambahKendaraan'])->name('hsse.kendaraan');
    Route::post('/hsse/tambahkendaraan', [HSSEKendaraanController::class, 'storeTambahKendaraan'])->name('hsse.tambahkendaraan.store');
    Route::post('/hsse/tambahkendaraan/{id}', [HSSEKendaraanController::class, 'updateTambahKendaraan'])->name('hsse.tambahkendaraan.update');
    Route::delete('/hsse/tambahkendaraan/{id}', [HSSEKendaraanController::class, 'deactivateKendaraan'])->name('hsse.tambahkendaraan.deactivate');
    Route::get('/hsse/kendaraan/{kendaraan}/history', [HSSEKendaraanController::class, 'showInspectionHistory'])->name('hsse.kendaraan.history');
    Route::get('/hsse/inspeksi/show/{inspeksi}', [HSSEKendaraanController::class, 'show'])->name('hsse.showinspeksi');

    // Routes for deactivated vehicles
    Route::get('/hsse/kendaraan/nonaktif', [HSSEKendaraanController::class, 'showDeactivated'])->name('hsse.kendaraan.nonaktif');
    Route::patch('/hsse/kendaraan/{id}/activate', [HSSEKendaraanController::class, 'activate'])->name('hsse.kendaraan.activate');

    // Route Kelola Akun
    Route::get('/hsse/kelola-akun/', [HSSEKelolaAkunController::class, 'index'])->name('hsse.kelolaakun');
    Route::get('/hsse/kelola-akun/create', [HSSEKelolaAkunController::class, 'create'])->name('hsse.kelolaakun.create'); // Form Tambah Akun
    Route::post('/hsse/kelola-akun', [HSSEKelolaAkunController::class, 'store'])->name('hsse.kelolaakun.store'); // Simpan Akun
    Route::get('/hsse/kelola-akun/{user}/edit', [HSSEKelolaAkunController::class, 'edit'])->name('hsse.kelolaakun.edit'); // Form Edit Akun
    Route::put('/hsse/kelola-akun/{user}', [HSSEKelolaAkunController::class, 'update'])->name('hsse.kelolaakun.update'); // Update Akun
    Route::delete('/hsse/kelola-akun/{user}', [HSSEKelolaAkunController::class, 'destroy'])->name('hsse.kelolaakun.destroy'); // Ini sekarang untuk menonaktifkan

    // Route untuk melihat dan mengaktifkan akun nonaktif
    Route::get('/hsse/kelola-akun/nonaktif', [HSSEKelolaAkunController::class, 'showNonaktif'])
        ->name('hsse.kelolaakun.nonaktif');
    Route::patch('/hsse/kelola-akun/{user}/activate', [HSSEKelolaAkunController::class, 'activate'])
        ->name('hsse.kelolaakun.activate');

    // Route Kelola Pegawai (CRUD) - Dikembalikan karena masih digunakan
    Route::resource('hsse/pegawai', App\Http\Controllers\HSSE\PegawaiController::class)
        ->except(['show']) // Tidak butuh halaman show detail pegawai
        ->names('hsse.pegawai'); // Memberi nama route (hsse.pegawai.index, hsse.pegawai.create, dll)

    // Rute untuk Peminjaman Kendaraan oleh Pegawai
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('hsse.peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('hsse.peminjaman.store');
    Route::patch('/peminjaman/{id}/complete', [PeminjamanController::class, 'complete'])->name('hsse.peminjaman.complete');
});

//driver
Route::middleware(['auth', 'DriverMiddleware'])->group(function () {
    Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/driver/tambah-perjalanan', [TambahController::class, 'viewPerjalanan'])->name('driver.tambah');
    Route::get('/driver/status', [StatusController::class, 'viewStatus'])->name('driver.status');
    Route::get('/driver/history', [DriverhistoryController::class, 'viewHistory'])->name('driver.history');
    Route::get('/driver/kendaraan', [DriverKendaraanController::class, 'viewKendaraan'])->name('driver.kendaraan');
    Route::get('/driver/kendaraan/{kendaraan}/inspeksi', [DriverKendaraanController::class, 'showInspectionHistory'])->name('driver.kendaraan.inspeksi.history');
    Route::post('/driver/store-perjalanan', [TambahController::class, 'storePerjalanan'])->name('storePerjalanan');
    Route::put('/driver/status/{id}', [TambahController::class, 'updatePerjalanan'])->name('update.perjalanan');
    Route::delete('/perjalanan/delete/{id}', [StatusController::class, 'destroyStatus'])->name('perjalanan.delete');
    //inspeksi kendaraan
    Route::get('/kendaraan/{id}/inspeksi', [DriverKendaraanController::class, 'viewInspeksi'])->name('driver.viewinspeksi');
    Route::post('/kendaraan/{id}/inspeksi', [DriverKendaraanController::class, 'storeInspeksi'])->name('driver.storeinspeksi');
    Route::get('/inspeksi/show/{inspeksi}', [InspeksiKendaraanController::class, 'show'])->name('driver.inspeksi.show');
});

//pdf_laravel
// Route::get('/user/invoice/{invoice}', function (Request $request, string $invoiceId) {
//     return $request->user()->downloadInvoice($invoiceId);
// });

//cetak_pdf
Route::get('/cetak-pdf/{role}', [PDFController::class, 'cetakPDF'])->name('cetak.pdf');
Route::get('/perjalanan/pdf/{id}', [PDFController::class, 'StatusPerjalananPDF'])->name('statusperjalanan.pdf');
Route::get('/inspeksi/pdf/{id}', [PDFController::class, 'InspeksiKendaraanPDF'])->name('inspeksi.pdf');

//notification
Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
Route::patch('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

// Halaman Offline PWA
Route::get('/offline', function () {
    return view('offline');
})->name('pwa.offline');
