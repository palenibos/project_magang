<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiDriver BPU - Sistem Pendataan Driver BPU BPJS Ketenagakerjaan ShopeeFood">
    <title>@yield('title', 'SiDriver BPU') — BPJS Ketenagakerjaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-64 flex-shrink-0 bg-gradient-to-b from-green-800 to-green-900 text-white flex flex-col shadow-xl">

        {{-- Logo & Brand --}}
        <div class="px-6 py-5 border-b border-green-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h2m2-10h5l3 3v5h-2m-5 0H9"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold leading-tight">SiDriver BPU</h1>
                    <p class="text-green-300 text-xs">BPJS Ketenagakerjaan</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            @php
                $navClass = fn($route) => request()->routeIs($route)
                    ? 'flex items-center gap-3 px-4 py-2.5 rounded-xl bg-white/20 text-white font-semibold text-sm shadow-inner'
                    : 'flex items-center gap-3 px-4 py-2.5 rounded-xl text-green-100 hover:bg-white/10 hover:text-white text-sm transition-all duration-150';
            @endphp

            <a href="{{ route('dashboard') }}" class="{{ $navClass('dashboard') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="pt-2 pb-1">
                <p class="text-green-400 text-xs font-semibold uppercase tracking-wider px-4">Data Driver</p>
            </div>

            <a href="{{ route('drivers.index') }}" class="{{ $navClass('drivers.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Data Harian
            </a>

            <a href="{{ route('drivers.create') }}" class="{{ $navClass('drivers.create') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Tambah Driver
            </a>

            <div class="pt-2 pb-1">
                <p class="text-green-400 text-xs font-semibold uppercase tracking-wider px-4">Rekap</p>
            </div>

            <a href="{{ route('rekap.bulanan') }}" class="{{ $navClass('rekap.bulanan') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Rekap Bulanan
            </a>

            <a href="{{ route('rekap.tahunan') }}" class="{{ $navClass('rekap.tahunan') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Rekap Tahunan
            </a>

            <div class="pt-2 pb-1">
                <p class="text-green-400 text-xs font-semibold uppercase tracking-wider px-4">Laporan</p>
            </div>

            <a href="{{ route('export.index') }}" class="{{ $navClass('export.index') }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
        </nav>

        {{-- User Profile & Logout --}}
        <div class="px-4 py-4 border-t border-green-700">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-green-300 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-green-200 hover:bg-white/10 hover:text-white text-sm transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                <p class="text-sm text-gray-500 mt-0.5">@yield('page-subtitle', 'Selamat datang di SiDriver BPU')</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                <p class="text-xs text-gray-400">{{ now()->format('H:i') }} WIB</p>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-8 pt-4">
            @if(session('success'))
                <div id="flash-success" class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-0 text-sm shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-0 text-sm shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-8 py-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Auto-hide flash message
    setTimeout(() => {
        const flash = document.getElementById('flash-success');
        if (flash) flash.style.opacity = '0', flash.style.transition = 'opacity 0.5s', setTimeout(() => flash.remove(), 500);
    }, 4000);
</script>

</body>
</html>
