<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\InspeksiKendaraan; // Import model InspeksiKendaraan
use Illuminate\Http\Request;

class InspeksiKendaraanController extends Controller
{
    public function show(InspeksiKendaraan $inspeksi) // Perhatikan: $id adalah ID *inspeksi*, bukan ID kendaraan
    {
        // $inspeksi = InspeksiKendaraan::findOrFail($id);

        

        return view('driver.showinspeksi', compact('inspeksi'));
    }
}