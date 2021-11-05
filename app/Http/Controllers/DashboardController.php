<?php

namespace App\Http\Controllers;

use App\Models\MBrand;
use App\Models\MLevis;
use App\Models\MType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $Levis = MLevis::count();
        $Brand = MBrand::count();
        $Type  = MType::count();
        return view('dashboard', 
        [
            'Levis' => $Levis,
            'Brand' => $Brand,
            'Type'  => $Type,
            'title' => 'Dashboard'
        ]);
    }

    public function dashboard()
    {
        return view('dashboard', 
        [
            'title' => 'Dashboard'
        ]);
    }
}
