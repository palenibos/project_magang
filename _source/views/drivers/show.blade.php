@extends('layouts.app')

@section('title', 'Detail Driver — ' . $driver->nama_lengkap)
@section('page-title', 'Detail Driver')
@section('page-subtitle', 'Informasi lengkap data driver')

@section('content')

<div class="w-full">

    {{-- Header Actions --}}
    <div class="flex items-center justify-between mb-5">
        <a href="{{ route('drivers.index', ['tanggal' => $driver->tanggal_daftar->format('Y-m-d')]) }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data Harian
        </a>
        <a href="{{ route('drivers.edit', $driver->id) }}"
           class="inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-600 hover:text-green-600 hover:border-green-300 hover:bg-green-50 px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Data
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-8 py-6 bg-gradient-to-r from-green-700 to-green-800 text-white">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                    {{ strtoupper(substr($driver->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $driver->nama_lengkap }}</h2>
                    <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                        <p class="text-green-200 text-sm">Didaftarkan pada {{ $driver->tanggal_daftar->isoFormat('D MMMM YYYY') }} — {{ $driver->created_at->format('H:i') }} WIB</p>
                        @if($driver->updated_at->ne($driver->created_at))
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white/10 text-green-50 text-xs" title="Terakhir diedit">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Diedit {{ $driver->updated_at->isoFormat('D MMMM YYYY — H:mm') }} WIB
                            </span>
                        @endif
                    </div>
                    <div class="mt-2">
                        @if($driver->status === 'valid')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white border border-white/30">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Valid
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/30 text-white border border-red-300/40">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Bermasalah — {{ $driver->keterangan }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="px-8 py-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Data Pribadi</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7">
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">NIK</dt>
                    <dd class="font-mono text-gray-800 font-semibold text-base tracking-wider bg-gray-50 px-3 py-2 rounded-lg">{{ $driver->nik }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Nama Lengkap</dt>
                    <dd class="text-gray-800 font-medium">{{ $driver->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Tempat Lahir</dt>
                    <dd class="text-gray-800">{{ $driver->tempat_lahir }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Tanggal Lahir</dt>
                    <dd class="text-gray-800">{{ $driver->tanggal_lahir->isoFormat('D MMMM YYYY') }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Nama Ibu Kandung</dt>
                    <dd class="text-gray-800 font-medium">{{ $driver->nama_ibu_kandung }}</dd>
                </div>
            </dl>

            <hr class="border-gray-100 mb-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Kontak</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7">
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Nomor HP</dt>
                    <dd class="text-gray-800">{{ $driver->nomor_hp }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Alamat Email</dt>
                    <dd class="text-gray-800">{{ $driver->email }}</dd>
                </div>
            </dl>

            <hr class="border-gray-100 mb-6">

            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Data Rekening</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7">
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Nama Bank</dt>
                    <dd class="text-gray-800 font-medium">{{ $driver->nama_bank }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Nomor Rekening</dt>
                    <dd class="font-mono text-gray-800 font-semibold text-base tracking-wider bg-gray-50 px-3 py-2 rounded-lg">{{ $driver->nomor_rekening }}</dd>
                </div>
            </dl>

            @if($driver->keterangan)
            <hr class="border-gray-100 mb-6">
            <div>
                <dt class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Keterangan</dt>
                <dd class="text-red-700 bg-red-50 px-4 py-3 rounded-xl text-sm font-medium border border-red-100">{{ $driver->keterangan }}</dd>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
