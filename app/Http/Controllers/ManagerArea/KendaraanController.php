<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\InspeksiKendaraan; // Import model InspeksiKendaraan

class KendaraanController extends Controller
{
    public function viewKendaraan()
    {
        $kendaraan = Kendaraan::all();
        return view('managerarea.kendaraan', compact('kendaraan'));
    }

    public function show(InspeksiKendaraan $inspeksi) // Perhatikan: $id adalah ID *inspeksi*, bukan ID kendaraan
    {
    
        return view('managerarea.showinspeksi', compact('inspeksi'));
    }
}
