@extends('layouts.app')

@section('title', 'Rekap Tahunan')
@section('page-title', 'Rekap Tahunan')
@section('page-subtitle', 'Jumlah input driver per bulan dalam satu tahun')

@section('content')

@php
    $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
@endphp

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('rekap.tahunan') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[180px]">
            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Tahun</label>
            <select id="tahun" name="tahun" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ (int)$tahun === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Tampilkan
        </button>
    </form>
</div>

{{-- Summary Card --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalKeseluruhan }}</p>
            <p class="text-sm text-gray-500">Total Driver Tahun {{ $tahun }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $rekap->count() }}</p>
            <p class="text-sm text-gray-500">Bulan Aktif dengan Data</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">
            Rincian per Bulan — <span class="text-green-600">Tahun {{ $tahun }}</span>
        </h3>
    </div>

    @if($rekap->isEmpty())
        <div class="px-6 py-16 text-center">
            <p class="text-gray-400 text-sm">Tidak ada data untuk tahun ini</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-3.5 font-semibold">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Bulan</th>
                        <th class="text-center px-6 py-3.5 font-semibold">Total Input</th>
                        <th class="text-center px-6 py-3.5 font-semibold">Bermasalah</th>
                        <th class="text-center px-6 py-3.5 font-semibold">Valid</th>
                        <th class="text-center px-6 py-3.5 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($rekap as $index => $row)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $namaBulan[$row->bulan_angka] ?? $row->nama_bulan }} {{ $tahun }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-bold text-gray-800 text-base">{{ $row->total }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($row->bermasalah > 0)
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    {{ $row->bermasalah }}
                                </span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                {{ $row->total - $row->bermasalah }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('rekap.bulanan', ['bulan' => $row->bulan_angka, 'tahun' => $tahun]) }}"
                               class="text-green-600 hover:text-green-800 text-xs font-medium underline underline-offset-2">
                                Detail bulan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-green-50 border-t-2 border-green-200">
                        <td colspan="2" class="px-6 py-4 font-bold text-green-800 text-sm">TOTAL {{ $tahun }}</td>
                        <td class="px-6 py-4 text-center font-bold text-green-800 text-lg">{{ $totalKeseluruhan }}</td>
                        <td class="px-6 py-4 text-center font-bold text-red-700">{{ $rekap->sum('bermasalah') }}</td>
                        <td class="px-6 py-4 text-center font-bold text-green-700">{{ $totalKeseluruhan - $rekap->sum('bermasalah') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

@endsection
