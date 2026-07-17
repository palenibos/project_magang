<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_hp',
        'email',
        'nama_ibu_kandung',
        'nama_bank',
        'nomor_rekening',
        'status',
        'keterangan',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_daftar' => 'date',
    ];

    // Scope: data pada tanggal tertentu
    public function scopeHarian($query, $tanggal)
    {
        return $query->whereDate('tanggal_daftar', $tanggal);
    }

    // Scope: data dalam bulan & tahun tertentu
    public function scopeBulanan($query, $bulan, $tahun)
    {
        return $query->whereMonth('tanggal_daftar', $bulan)
                     ->whereYear('tanggal_daftar', $tahun);
    }

    // Scope: data dalam tahun tertentu
    public function scopeTahunan($query, $tahun)
    {
        return $query->whereYear('tanggal_daftar', $tahun);
    }

    public function scopeBermasalah($query)
    {
        return $query->where('status', 'bermasalah');
    }
}
