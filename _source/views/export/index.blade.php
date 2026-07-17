@extends('layouts.app')

@section('title', 'Export Excel')
@section('page-title', 'Export Excel')
@section('page-subtitle', 'Unduh data driver dalam format Excel (.xlsx)')

@section('content')

<div class="w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Unduh Data Excel</h3>
                    <p class="text-sm text-gray-400 mt-0.5">Format: NIK, Nama, TTL, HP, Email, Ibu Kandung, Bank, Rekening, Status, Tanggal</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('export.download') }}" class="px-8 py-6 space-y-5" id="export-form">
            @csrf

            {{-- Pilih Periode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode Export</label>
                <div class="grid grid-cols-3 gap-3" role="radiogroup">
                    <label class="cursor-pointer" id="lbl-harian">
                        <input type="radio" name="periode" value="harian" class="sr-only peer" {{ old('periode', 'harian') === 'harian' ? 'checked' : '' }} onchange="showSection(this.value)">
                        <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-xl p-4 text-center transition-all">
                            <svg class="w-6 h-6 mx-auto text-gray-400 peer-checked:text-green-600 mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-sm font-medium text-gray-700">Harian</span>
                        </div>
                    </label>
                    <label class="cursor-pointer" id="lbl-bulanan">
                        <input type="radio" name="periode" value="bulanan" class="sr-only peer" {{ old('periode') === 'bulanan' ? 'checked' : '' }} onchange="showSection(this.value)">
                        <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-xl p-4 text-center transition-all">
                            <svg class="w-6 h-6 mx-auto text-gray-400 peer-checked:text-green-600 mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span class="text-sm font-medium text-gray-700">Bulanan</span>
                        </div>
                    </label>
                    <label class="cursor-pointer" id="lbl-tahunan">
                        <input type="radio" name="periode" value="tahunan" class="sr-only peer" {{ old('periode') === 'tahunan' ? 'checked' : '' }} onchange="showSection(this.value)">
                        <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-xl p-4 text-center transition-all">
                            <svg class="w-6 h-6 mx-auto text-gray-400 peer-checked:text-green-600 mb-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            <span class="text-sm font-medium text-gray-700">Tahunan</span>
                        </div>
                    </label>
                </div>
                @error('periode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Section: Harian --}}
            <div id="section-harian" class="space-y-3">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Section: Bulanan --}}
            <div id="section-bulanan" class="space-y-3 hidden">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1.5">Bulan</label>
                        <select id="bulan" name="bulan" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                            @foreach(range(1,12) as $b)
                                @php $nm = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] @endphp
                                <option value="{{ $b }}" {{ (int)old('bulan', now()->month) === $b ? 'selected' : '' }}>{{ $nm[$b] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tahun-b" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun</label>
                        <select id="tahun-b" name="tahun" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                            @foreach(range(2024, now()->year + 1) as $t)
                                <option value="{{ $t }}" {{ (int)old('tahun', now()->year) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Section: Tahunan --}}
            <div id="section-tahunan" class="space-y-3 hidden">
                <div>
                    <label for="tahun-t" class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Tahun</label>
                    <select id="tahun-t" name="tahun" class="w-full border border-gray-200 rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white transition">
                        @foreach(range(2024, now()->year + 1) as $t)
                            <option value="{{ $t }}" {{ (int)old('tahun', now()->year) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Download Button --}}
            <div class="pt-2">
                <button type="submit" id="btn-download" class="w-full inline-flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3.5 rounded-xl text-sm transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download Excel (.xlsx)
                </button>
            </div>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl px-5 py-4 text-sm text-blue-700">
        <p class="font-semibold mb-1 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Informasi Export
        </p>
        <ul class="space-y-1 text-blue-600 text-xs">
            <li>• File Excel berisi semua kolom termasuk data sensitif (NIK, Rekening, Ibu Kandung)</li>
            <li>• Format nama file: <code class="bg-blue-100 px-1 rounded">SiDriver_BPU_[Periode].xlsx</code></li>
            <li>• Kolom: NIK, Nama Lengkap, Tempat Lahir, Tgl Lahir, HP, Email, Ibu Kandung, Bank, Rekening, Status, Tgl Daftar</li>
        </ul>
    </div>
</div>

<script>
function showSection(val) {
    ['harian','bulanan','tahunan'].forEach(s => {
        document.getElementById('section-' + s).classList.toggle('hidden', s !== val);
    });
}
// Init on page load
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="periode"]:checked');
    if (checked) showSection(checked.value);
});
</script>

@endsection
