<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;

class KendaraanController extends Controller
{
    public function viewKendaraan (){
      $kendaraan = Kendaraan::all();
      return view('managerarea.kendaraan', compact('kendaraan'));  
    }
}
