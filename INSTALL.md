# 🚀 Panduan Instalasi SiDriver BPU

## Persyaratan Sistem

| Komponen | Versi Minimum |
|---|---|
| PHP | 8.2+ |
| MySQL | 8.0+ |
| Composer | 2.x |
| Node.js | 18+ |
| npm | 9+ |

---

## Langkah Instalasi

### 1. Masuk ke Folder Project

```bash
cd "c:\Project Magang\sidriver-bpu"
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Konfigurasi Environment

File `.env` sudah dikonfigurasi otomatis. Sesuaikan jika perlu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sidriver_bpu
DB_USERNAME=root
DB_PASSWORD=           # ← isi password MySQL Anda jika ada
```

### 4. Install Package Excel (maatwebsite/excel)

Package ini butuh koneksi internet. Jalankan setelah koneksi aktif:

```bash
composer require "maatwebsite/excel:3.1.69"
```

Jika gagal (timeout), coba dengan mirror:
```bash
composer config -g repos.packagist composer https://packagist.phpcomposer.com
composer require "maatwebsite/excel:3.1.69"
```

Setelah berhasil, publish konfigurasi:
```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

### 5. Buat Database MySQL

Buka MySQL client (Laragon, phpMyAdmin, atau command line), lalu jalankan:

```sql
CREATE DATABASE sidriver_bpu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via command line (sesuaikan path MySQL Anda):
```bash
# Jika menggunakan Laragon:
"C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysql.exe" -u root -e "CREATE DATABASE sidriver_bpu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Jika menggunakan XAMPP:
"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE sidriver_bpu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

> ⚠️ **Penting:** Pastikan Laragon / XAMPP / MySQL server sudah berjalan sebelum langkah ini!

### 6. Jalankan Migration

```bash
php artisan migrate
```

### 7. Buat User Admin

```bash
php artisan db:seed
```

Ini akan membuat akun admin:
- **Email:** `adminsopianjay@bpjstk.com`
- **Password:** `admin123`

### 8. Install Dependensi Frontend

```bash
npm install
npm run build
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

---

## Troubleshooting

### Error: "Class Maatwebsite\Excel\ExcelServiceProvider not found"

Install ulang package excel:
```bash
composer require "maatwebsite/excel:3.1.69"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
```

### Error: "No connection could be made" (MySQL)

Pastikan MySQL server aktif. Cek status di:
- **Laragon:** Klik tombol "Start All" di Laragon
- **XAMPP:** Klik "Start" pada MySQL di panel XAMPP

### Error: "php_zip extension not loaded"

Aktifkan extension `php_zip` di `php.ini`:
1. Buka `C:\laragon\etc\php\<versi>\php.ini`
2. Cari `;extension=zip` → hapus titik koma jadi `extension=zip`
3. Restart server

### Error: "Access denied for user root"

Edit `.env` dan isi password MySQL:
```env
DB_PASSWORD=password_anda
```

---

## Struktur File yang Dibuat

```
sidriver-bpu/
├── app/
│   ├── Exports/
│   │   └── DriversExport.php          # Kelas export Excel
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── DriverController.php    # CRUD + logika NIK ganda
│   │   │   ├── RekapController.php     # Rekap bulanan & tahunan
│   │   │   └── ExportController.php    # Download Excel
│   │   └── Requests/
│   │       └── StoreDriverRequest.php  # Validasi form
│   └── Models/
│       └── Driver.php                  # Model dengan scopes
├── database/
│   ├── migrations/
│   │   └── ..._create_drivers_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── auth/
│   │   └── login.blade.php            # Halaman login BPJS
│   ├── layouts/
│   │   └── app.blade.php              # Layout utama + sidebar
│   ├── drivers/
│   │   ├── index.blade.php            # Data harian
│   │   ├── create.blade.php           # Form input driver
│   │   └── show.blade.php             # Detail driver
│   ├── rekap/
│   │   ├── bulanan.blade.php          # Rekap per bulan
│   │   └── tahunan.blade.php          # Rekap per tahun
│   ├── export/
│   │   └── index.blade.php            # Form export Excel
│   └── dashboard.blade.php            # Dashboard utama
└── routes/
    ├── web.php                         # Routes aplikasi
    └── auth.php                        # Routes autentikasi
```

---

## Info Akun Admin

| Field | Value |
|---|---|
| Email | `adminsopianjay@bpjstk.com` |
| Password | `admin123` |

---

## Fitur Bisnis

- ✅ Input data driver (NIK, nama, TTL, HP, email, ibu kandung, bank, rekening)
- ✅ Deteksi NIK ganda otomatis → status `bermasalah` + keterangan "NIK ganda"
- ✅ Data sensitif disembunyikan di tabel, hanya tampil di halaman detail
- ✅ Rekap harian / bulanan / tahunan otomatis dari kolom `tanggal_daftar`
- ✅ Export Excel (.xlsx) untuk semua periode, dengan header berwarna hijau BPJS
- ✅ Dashboard dengan statistik real-time
- ✅ Dropdown 60+ bank Indonesia

## Kolom Export Excel

NIK → Nama Lengkap → Tempat Lahir → Tanggal Lahir → Nomor HP → Alamat Email → Nama Ibu Kandung → Nama Bank → Nomor Rekening → Status → Tanggal Daftar
