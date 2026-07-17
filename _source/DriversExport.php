<?php

namespace App\Exports;

use App\Models\Driver;

/**
 * Helper class untuk menyiapkan data export.
 * Export diproses langsung oleh ExportController menggunakan
 * maatwebsite/excel v1.x API (Excel facade).
 */
class DriversExport
{
    protected string $periode;
    protected array  $params;

    public function __construct(string $periode, array $params)
    {
        $this->periode = $periode;
        $this->params  = $params;
    }

    /**
     * Ambil data driver sesuai periode, kembalikan sebagai array of arrays
     * (format yang dibutuhkan sheet->fromArray).
     */
    public function getData(): array
    {
        $query = Driver::query()
            ->orderBy('tanggal_daftar')
            ->orderBy('created_at');

        switch ($this->periode) {
            case 'harian':
                $query->harian($this->params['tanggal']);
                break;
            case 'bulanan':
                $query->bulanan($this->params['bulan'], $this->params['tahun']);
                break;
            case 'tahunan':
                $query->tahunan($this->params['tahun']);
                break;
        }

        $drivers = $query->get();

        $rows = [];

        foreach ($drivers as $driver) {
            $rows[] = [
                $driver->nik,
                $driver->nama_lengkap,
                $driver->tempat_lahir,
                $driver->tanggal_lahir  ? $driver->tanggal_lahir->format('d/m/Y')  : '',
                $driver->nomor_hp,
                $driver->email,
                $driver->nama_ibu_kandung,
                $driver->nama_bank,
                $driver->nomor_rekening,
                ucfirst($driver->status),
                $driver->tanggal_daftar ? $driver->tanggal_daftar->format('d/m/Y') : '',
            ];
        }

        return $rows;
    }

    public static function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Nomor HP',
            'Alamat Email',
            'Nama Ibu Kandung',
            'Nama Bank',
            'Nomor Rekening',
            'Status',
            'Tanggal Daftar',
        ];
    }
}
