@extends('layouts.app')

@section('title', 'Edit Data Driver')
@section('page-title', 'Edit Data Driver')
@section('page-subtitle', 'Perbarui informasi data driver')

@section('content')

<div class="w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg">Formulir Data Driver</h3>
            <p class="text-sm text-gray-400 mt-0.5">Semua field bertanda <span class="text-red-500">*</span> wajib diisi</p>
        </div>

        <form method="POST" action="{{ route('drivers.update', $driver->id) }}" class="px-8 py-6 space-y-6" autocomplete="off">
            @csrf
            @method('PUT')

            {{-- Section: Data Pribadi --}}
            <div>
                <h4 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-xs">1</span>
                    Data Pribadi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1.5">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            value="{{ old('nik', $driver->nik) }}"
                            maxlength="16"
                            placeholder="16 digit angka"
                            class="w-full border @error('nik') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('nik')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap', $driver->nama_lengkap) }}"
                            placeholder="Sesuai KTP"
                            class="w-full border @error('nama_lengkap') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="tempat_lahir"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir', $driver->tempat_lahir) }}"
                            placeholder="Kota/Kabupaten"
                            class="w-full border @error('tempat_lahir') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('tempat_lahir')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            id="tanggal_lahir"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $driver->tanggal_lahir->format('Y-m-d')) }}"
                            max="{{ now()->subDay()->toDateString() }}"
                            class="w-full border @error('tanggal_lahir') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('tanggal_lahir')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Ibu Kandung --}}
                    <div class="md:col-span-2">
                        <label for="nama_ibu_kandung" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Ibu Kandung <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama_ibu_kandung"
                            name="nama_ibu_kandung"
                            value="{{ old('nama_ibu_kandung') }}"
                            placeholder="Nama ibu kandung sesuai akta"
                            class="w-full border @error('nama_ibu_kandung') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('nama_ibu_kandung')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Section: Kontak --}}
            <div>
                <h4 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-xs">2</span>
                    Kontak
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nomor HP --}}
                    <div>
                        <label for="nomor_hp" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="nomor_hp"
                            name="nomor_hp"
                            value="{{ old('nomor_hp', $driver->nomor_hp) }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full border @error('nomor_hp') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('nomor_hp')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $driver->email) }}"
                            placeholder="contoh@email.com"
                            class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Section: Data Rekening --}}
            <div>
                <h4 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-xs">3</span>
                    Data Rekening
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama Bank --}}
                    <div>
                        <label for="nama_bank" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Bank <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="nama_bank"
                            name="nama_bank"
                            class="w-full border @error('nama_bank') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 pr-10 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white"
                        >
                            <option value="">— Pilih Bank —</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank }}" {{ old('nama_bank', $driver->nama_bank) === $bank ? 'selected' : '' }}>
                                    {{ $bank }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_bank')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Rekening --}}
                    <div>
                        <label for="nomor_rekening" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nomor Rekening <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nomor_rekening"
                            name="nomor_rekening"
                            value="{{ old('nomor_rekening', $driver->nomor_rekening) }}"
                            placeholder="Nomor rekening aktif"
                            class="w-full border @error('nomor_rekening') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        >
                        @error('nomor_rekening')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Section: Tanggal Daftar --}}
            <div>
                <h4 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-xs">4</span>
                    Tanggal Pendaftaran
                </h4>

                {{-- Info note --}}
                <div class="flex items-start gap-2 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-4 text-sm text-amber-700">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Boleh diisi tanggal sebelum hari ini jika ingin memasukkan data lama. Secara default diisi hari ini.</span>
                </div>

                <div class="max-w-xs">
                    <label for="tanggal_daftar" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal Daftar <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        id="tanggal_daftar"
                        name="tanggal_daftar"
                        value="{{ old('tanggal_daftar', $driver->tanggal_daftar->format('Y-m-d')) }}"
                        max="{{ now()->toDateString() }}"
                        class="w-full border @error('tanggal_daftar') border-red-400 bg-red-50 @else border-gray-200 @enderror rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    >
                    @error('tanggal_daftar')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-100">

            {{-- Keterangan Tambahan --}}
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Keterangan <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input
                    type="text"
                    id="keterangan"
                    name="keterangan"
                    value="{{ old('keterangan', $driver->keterangan) }}"
                    placeholder="Catatan tambahan jika ada..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                >
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('drivers.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-8 py-3 rounded-xl text-sm transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Perbarui Data
            </button>
            </div>
        </form>
    </div>
</div>

@endsection
