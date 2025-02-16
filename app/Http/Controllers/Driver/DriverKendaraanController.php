<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\kendaraan;

class DriverKendaraanController extends Controller
{
    public function viewKendaraan (){

        $kendaraan = kendaraan::all();
        return view('driver.kendaraan', compact('kendaraan'));
    }
}
