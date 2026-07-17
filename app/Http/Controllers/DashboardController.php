<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today     = now()->toDateString();
        $thisMonth = now()->month;
        $thisYear  = now()->year;

        $hariIni        = Driver::harian($today)->count();
        $bulanIni       = Driver::bulanan($thisMonth, $thisYear)->count();
        $tahunIni       = Driver::tahunan($thisYear)->count();
        $bermasalahHari = Driver::harian($today)->bermasalah()->count();

        $aktivitasTerbaru = Driver::harian($today)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(['id', 'nama_lengkap', 'status', 'created_at']);

        return view('dashboard', compact(
            'hariIni',
            'bulanIni',
            'tahunIni',
            'bermasalahHari',
            'aktivitasTerbaru'
        ));
    }
}
