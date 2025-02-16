<?php

namespace App\Http\Controllers\ManagerArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerAreaController extends Controller
{
    public function dashboard(){
        return view('managerarea.dashboard');
    }
}
