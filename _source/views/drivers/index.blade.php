@extends('layouts.app')

@section('title', 'Data Harian')
@section('page-title', 'Data Harian')
@section('page-subtitle', 'Data driver yang diinput pada tanggal tertentu')

@section('content')

{{-- Filter & Actions --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('drivers.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[180px]">
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Tanggal</label>
            <input
                type="date"
                id="tanggal"
                name="tanggal"
                value="{{ $tanggal }}"
                max="{{ now()->toDateString() }}"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
            >
        </div>
        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Tampilkan
        </button>
        @if($tanggal !== now()->toDateString())
        <a href="{{ route('drivers.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 px-3 py-2.5 rounded-xl hover:bg-gray-100 transition-colors">
            Hari ini
        </a>
        @endif
    </form>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="font-bold text-gray-800">
                Data Tanggal
                <span class="text-green-600">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM YYYY') }}</span>
            </h3>
            <p class="text-sm text-gray-400 mt-0.5">Total: <span class="font-semibold text-gray-600">{{ $drivers->count() }}</span> driver</p>
        </div>
        <a href="{{ route('drivers.create') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-xl text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Driver
        </a>
    </div>

    @if($drivers->isEmpty())
        <div class="px-6 py-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada data untuk tanggal ini</p>
            <p class="text-gray-400 text-sm mt-1">Pilih tanggal lain atau tambahkan data baru</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-3.5 font-semibold w-12">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Nama Driver</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Jam Input</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Status</th>
                        <th class="text-left px-6 py-3.5 font-semibold">Keterangan</th>
                        <th class="text-center px-6 py-3.5 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($drivers as $index => $driver)
                    <tr class="hover:bg-green-50/50 transition-colors group">
                        <td class="px-6 py-4 text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($driver->nama_lengkap, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $driver->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $driver->created_at->format('H:i') }} WIB</td>
                        <td class="px-6 py-4">
                            @if($driver->status === 'valid')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Valid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Bermasalah
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $driver->keterangan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('drivers.show', $driver->id) }}" class="inline-flex items-center gap-1.5 text-green-600 hover:text-green-800 font-medium text-xs bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
