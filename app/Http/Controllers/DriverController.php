<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Data harian — default hari ini, bisa filter tanggal lain
     */
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());
        $drivers = Driver::harian($tanggal)
            ->orderBy('created_at', 'asc')
            ->get(['id', 'nama_lengkap', 'created_at', 'status', 'keterangan']);

        return view('drivers.index', compact('drivers', 'tanggal'));
    }

    /**
     * Form input driver baru
     */
    public function create()
    {
        $banks = $this->getBankList();
        return view('drivers.create', compact('banks'));
    }

    /**
     * Simpan driver baru + logika NIK ganda
     */
    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();

        // Cek NIK ganda
        $nikSudahAda = Driver::where('nik', $data['nik'])->exists();

        // tanggal_daftar sudah ada di $data (dari validated)
        $data['status']     = 'valid';
        $data['keterangan'] = $request->keterangan ?? null;

        if ($nikSudahAda) {
            $data['status']     = 'bermasalah';
            $data['keterangan'] = 'NIK ganda';
        }

        Driver::create($data);

        return redirect()
            ->route('drivers.index', ['tanggal' => $data['tanggal_daftar']])
            ->with('success', 'Data driver berhasil disimpan.');
    }

    /**
     * Detail lengkap satu driver (termasuk data sensitif)
     */
    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    /**
     * Form edit data driver
     */
    public function edit(Driver $driver)
    {
        $banks = $this->getBankList();
        return view('drivers.edit', compact('driver', 'banks'));
    }

    /**
     * Update data driver
     */
    public function update(StoreDriverRequest $request, Driver $driver)
    {
        $data = $request->validated();

        // Cek NIK ganda dengan ID selain driver ini
        $nikSudahAda = Driver::where('nik', $data['nik'])->where('id', '!=', $driver->id)->exists();

        $data['status']     = 'valid';
        $data['keterangan'] = $request->keterangan ?? null;

        if ($nikSudahAda) {
            $data['status']     = 'bermasalah';
            $data['keterangan'] = 'NIK ganda';
        }

        // Force update the updated_at timestamp so the "Diedit pada" badge always shows up
        $driver->touch();
        $driver->update($data);

        return redirect()
            ->route('drivers.show', $driver->id)
            ->with('success', 'Data driver berhasil diperbarui.');
    }

    /**
     * Hapus data driver
     */
    public function destroy(Driver $driver)
    {
        $tanggal = $driver->tanggal_daftar->toDateString();
        $driver->delete();

        return redirect()
            ->route('drivers.index', ['tanggal' => $tanggal])
            ->with('success', 'Data driver berhasil dihapus.');
    }

    /**
     * Daftar semua bank di Indonesia
     */
    private function getBankList(): array
    {
        return [
            // Bank BUMN
            'Bank Rakyat Indonesia (BRI)',
            'Bank Negara Indonesia (BNI)',
            'Bank Mandiri',
            'Bank Tabungan Negara (BTN)',
            // Bank Swasta Nasional Besar
            'Bank Central Asia (BCA)',
            'Bank CIMB Niaga',
            'Bank Danamon Indonesia',
            'Bank Permata',
            'Bank Pan Indonesia (Panin)',
            'Bank OCBC NISP',
            'Bank Maybank Indonesia',
            'Bank Mega',
            'Bank Sinarmas',
            'Bank Bukopin',
            'Bank BTPN',
            'Bank Commonwealth',
            'Bank Ekonomi Raharja',
            'Bank Ina Perdana',
            // Bank Syariah
            'Bank Syariah Indonesia (BSI)',
            'Bank Muamalat Indonesia',
            'Bank Mega Syariah',
            'Bank BCA Syariah',
            'Bank BNI Syariah (BSI)',
            'Bank BRI Syariah (BSI)',
            'Bank Panin Dubai Syariah',
            'Bank BTPN Syariah',
            // Bank Pembangunan Daerah (BPD)
            'Bank DKI',
            'Bank BJB (Jabar Banten)',
            'Bank Jateng (Jawa Tengah)',
            'Bank Jatim (Jawa Timur)',
            'Bank Jogja (BPD DIY)',
            'Bank Bali',
            'Bank NTB Syariah',
            'Bank NTT',
            'Bank Maluku Malut',
            'Bank Sulselbar',
            'Bank Sulteng',
            'Bank Sultra',
            'Bank Sulut-Go',
            'Bank Papua',
            'Bank Kaltimtara',
            'Bank Kalteng',
            'Bank Kalbar',
            'Bank Kalsel',
            'Bank Aceh',
            'Bank Sumut',
            'Bank Sumbar',
            'Bank Riau Kepri',
            'Bank Jambi',
            'Bank Sumsel Babel',
            'Bank Bengkulu',
            'Bank Lampung',
            // Bank Digital & Fintech
            'Bank Jago',
            'Bank Jenius (BTPN)',
            'Bank Seabank',
            'Bank Neo Commerce',
            'Bank Allo Bank',
            'Bank Blu (BCA Digital)',
            'Bank Superbank',
            'Neobank',
            // Bank Asing
            'Citibank',
            'HSBC Indonesia',
            'Standard Chartered Indonesia',
            'Deutsche Bank Indonesia',
            'Bank of China Indonesia',
            // Lainnya
            'Lainnya',
        ];
    }
}
