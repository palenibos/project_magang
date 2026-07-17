@extends('layouts.app')

@section('title', 'Rekap Bulanan')
@section('page-title', 'Rekap Bulanan')
@section('page-subtitle', 'Jumlah input driver per tanggal dalam satu bulan')

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
    <form method="GET" action="{{ route('rekap.bulanan') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[180px]">
            <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1.5">Bulan</label>
            <select id="bulan" name="bulan" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition">
                @foreach($bulanList as $b)
                    <option value="{{ $b }}" {{ (int)$bulan === $b ? 'selected' : '' }}>{{ $namaBulan[$b] }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[180px]">
            <label for="tahun_b" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun</label>
            <select id="tahun_b" name="tahun" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white transition">
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

{{-- Summary Cards --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalKeseluruhan }}</p>
            <p class="text-sm text-gray-500">Total Driver {{ $namaBulan[(int)$bulan] }} {{ $tahun }}</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalBermasalah }}</p>
            <p class="text-sm text-gray-500">Data Bermasalah Bulan Ini</p>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">
            Rincian per Tanggal —
            <span class="text-green-600">{{ $namaBulan[(int)$bulan] }} {{ $tahun }}</span>
        </h3>
    </div>

    @if($rekap->isEmpty())
        <div class="px-6 py-16 text-center">
            <p class="text-gray-400 text-sm">Tidak ada data untuk periode ini</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-3.5 font-semibold">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Tanggal</th>
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
                            {{ \Carbon\Carbon::parse($row->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
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
                            <a href="{{ route('drivers.index', ['tanggal' => $row->tanggal]) }}"
                               class="text-green-600 hover:text-green-800 text-xs font-medium underline underline-offset-2">
                                Lihat data
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-green-50 border-t-2 border-green-200">
                        <td colspan="2" class="px-6 py-4 font-bold text-green-800 text-sm">TOTAL</td>
                        <td class="px-6 py-4 text-center font-bold text-green-800 text-lg">{{ $totalKeseluruhan }}</td>
                        <td class="px-6 py-4 text-center font-bold text-red-700">{{ $totalBermasalah }}</td>
                        <td class="px-6 py-4 text-center font-bold text-green-700">{{ $totalKeseluruhan - $totalBermasalah }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

@endsection
