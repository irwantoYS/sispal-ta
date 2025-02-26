<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPerjalanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use carbon\Carbon;

class HomeController extends Controller
{
    public function landingpage(){
        return view('welcome');
    }
}