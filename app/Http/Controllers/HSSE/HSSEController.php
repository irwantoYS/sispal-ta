<?php

namespace App\Http\Controllers\HSSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HSSEController extends Controller
{
    public function dashboard(){
        return view('hsse.dashboard');
    }
}
