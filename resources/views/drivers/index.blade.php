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
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition"
            >
        </div>
        <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-green-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
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
                <span class="text-primary">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM YYYY') }}</span>
            </h3>
            <p class="text-sm text-gray-400 mt-0.5">Total: <span class="font-semibold text-gray-600">{{ $drivers->count() }}</span> driver</p>
        </div>
        <a href="{{ route('drivers.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-green-700 text-white font-medium px-4 py-2 rounded-xl text-sm transition-colors shadow-sm">
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
                            <div class="flex items-center justify-center gap-2">
                                {{-- Detail --}}
                                <a href="{{ route('drivers.show', $driver->id) }}" class="inline-flex items-center gap-1.5 text-primary hover:text-green-700 font-medium text-xs bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 font-medium text-xs bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                {{-- Hapus --}}
                                <button
                                    type="button"
                                    onclick="confirmDelete('{{ $driver->id }}', '{{ addslashes($driver->nama_lengkap) }}')"
                                    class="inline-flex items-center gap-1.5 text-red-600 hover:text-red-800 font-medium text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                                {{-- Hidden delete form --}}
                                <form id="delete-form-{{ $driver->id }}" method="POST" action="{{ route('drivers.destroy', $driver->id) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- ===== Modal Konfirmasi Hapus ===== --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

    {{-- Modal Box --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Hapus Data Driver</h3>
                <p class="text-sm text-gray-500 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-6 bg-gray-50 rounded-xl px-4 py-3">
            Apakah Anda yakin ingin menghapus data driver
            <span id="delete-driver-name" class="font-semibold text-gray-800"></span>?
            Data yang dihapus tidak dapat dipulihkan.
        </p>
        <div class="flex items-center justify-end gap-3">
            <button
                type="button"
                onclick="closeDeleteModal()"
                id="btn-cancel-delete"
                class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition-colors">
                Batal
            </button>
            <button
                type="button"
                onclick="submitDelete()"
                id="btn-confirm-delete"
                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let deleteTargetId = null;

    function confirmDelete(id, nama) {
        deleteTargetId = id;
        document.getElementById('delete-driver-name').textContent = nama;
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteTargetId = null;
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function submitDelete() {
        if (deleteTargetId) {
            document.getElementById('delete-form-' + deleteTargetId).submit();
        }
    }

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>

@endsection
