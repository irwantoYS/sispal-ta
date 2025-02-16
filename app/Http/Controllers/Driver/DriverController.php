<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\LaporanPerjalanan;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    
    public function dashboard(){
        return view('driver.dashboard');
    }
}
