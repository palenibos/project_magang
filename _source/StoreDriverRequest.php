<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nik'             => ['required', 'digits:16'],
            'nama_lengkap'    => ['required', 'string', 'max:255'],
            'tempat_lahir'    => ['required', 'string', 'max:100'],
            'tanggal_lahir'   => ['required', 'date', 'before:today'],
            'nomor_hp'        => ['required', 'string', 'max:20'],
            'email'           => ['required', 'email', 'max:255'],
            'nama_ibu_kandung'=> ['required', 'string', 'max:255'],
            'nama_bank'       => ['required', 'string', 'max:100'],
            'nomor_rekening'  => ['required', 'string', 'max:30'],
            'keterangan'      => ['nullable', 'string', 'max:255'],
            'tanggal_daftar'  => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus tepat 16 digit angka.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'=> 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before'  => 'Tanggal lahir harus sebelum hari ini.',
            'nomor_hp.required'     => 'Nomor HP wajib diisi.',
            'email.required'        => 'Alamat email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'nama_ibu_kandung.required' => 'Nama ibu kandung wajib diisi.',
            'nama_bank.required'    => 'Nama bank wajib dipilih.',
            'nomor_rekening.required'=> 'Nomor rekening wajib diisi.',
            'tanggal_daftar.required'=> 'Tanggal daftar wajib diisi.',
            'tanggal_daftar.before_or_equal' => 'Tanggal daftar tidak boleh melebihi hari ini.',
        ];
    }
}
