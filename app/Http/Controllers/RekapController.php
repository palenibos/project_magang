<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    /**
     * Rekap bulanan — jumlah input per tanggal dalam satu bulan
     */
    public function bulanan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $rekap = Driver::bulanan($bulan, $tahun)
            ->selectRaw('DATE(tanggal_daftar) as tanggal, COUNT(*) as total, SUM(status = "bermasalah") as bermasalah')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $totalKeseluruhan = $rekap->sum('total');
        $totalBermasalah  = $rekap->sum('bermasalah');

        $bulanList = range(1, 12);
        $tahunList = $this->getTahunList();

        return view('rekap.bulanan', compact(
            'rekap', 'bulan', 'tahun', 'totalKeseluruhan', 'totalBermasalah', 'bulanList', 'tahunList'
        ));
    }

    /**
     * Rekap tahunan — jumlah input per bulan dalam satu tahun
     */
    public function tahunan(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        $rekap = Driver::tahunan($tahun)
            ->selectRaw('MONTH(tanggal_daftar) as bulan_angka, MONTHNAME(tanggal_daftar) as nama_bulan, COUNT(*) as total, SUM(status = "bermasalah") as bermasalah')
            ->groupBy('bulan_angka', 'nama_bulan')
            ->orderBy('bulan_angka')
            ->get();

        $totalKeseluruhan = $rekap->sum('total');
        $tahunList        = $this->getTahunList();

        return view('rekap.tahunan', compact('rekap', 'tahun', 'totalKeseluruhan', 'tahunList'));
    }

    private function getTahunList(): array
    {
        $startYear  = 2024;
        $currentYear = now()->year;
        return range($startYear, $currentYear + 1);
    }
}
