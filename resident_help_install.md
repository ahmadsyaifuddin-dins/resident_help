# Resident Help - Sistem Manajemen & Pengaduan Perumahan

Aplikasi web berbasis Laravel untuk manajemen data hunian, kepemilikan unit, dan layanan pengaduan (maintenance) warga perumahan. Dilengkapi dengan fitur tracking tiket, laporan PDF otomatis, dan dashboard statistik.

---

## 🚀 Fitur Utama

### 1. Modul Admin
- **Dashboard Statistik:** Grafik penjualan unit, tren keluhan bulanan, dan status tukang
- **Master Data:** Manajemen Unit Rumah (Blok/No), Data Tukang/Teknisi, dan Data User
- **Pusat Laporan (5+ Output):**
  1. Rekapitulasi Keluhan (PDF)
  2. Analisis Kategori Kerusakan (PDF)
  3. Kinerja Respon / SLA (PDF)
  4. Data & Kinerja Teknisi (PDF)
  5. Indeks Kepuasan Pelanggan (PDF)
  6. Export Database Nasabah (Excel)
- **Disposisi Tiket:** Menerima laporan warga → menugaskan teknisi → update status (Pending/Proses/Selesai)

### 2. Modul Warga / Nasabah
- **Register Mandiri:** Pilihan role (Warga/Nasabah) dengan validasi No HP
- **Rumah Saya:** Melihat detail unit, spesifikasi bangunan, dan status masa garansi (Realtime Countdown)
- **Lapor Kerusakan:** Form pengaduan dengan upload foto bukti kerusakan
- **Cetak Tiket:** Cetak bukti pendaftaran keluhan (struk) untuk pegangan saat teknisi datang
- **Rating & Review:** Memberikan bintang dan ulasan setelah perbaikan selesai

---

## 🛠️ Persyaratan Sistem

Pastikan laptop Anda sudah terinstall:

- **PHP** >= 8.1
- **Composer** (Dependency Manager PHP)
- **Node.js** & **NPM** (untuk build frontend)
- **Database MySQL** (Laragon)
- **Git** (opsional, untuk clone repository)

---

## 📦 Langkah-Langkah Installasi

### 1. Clone / Extract Project

Extract file zip project ke folder kerja Anda (misal: `C:/xampp/htdocs/` atau `C:/laragon/www/`)

```bash
# Atau jika menggunakan Git
git clone <repository-url> resident-help
cd resident-help
```

### 2. Install Dependency PHP

Buka terminal/command prompt di folder project, kemudian jalankan:

```bash
composer install
```

**Catatan:** Proses ini akan mengunduh semua library PHP yang dibutuhkan Laravel. Pastikan koneksi internet stabil.

### 3. Install Dependency Frontend

Install library Tailwind CSS dan script pendukung lainnya:

```bash
npm install
npm run build
```

**Penjelasan:**
- `npm install` → menginstall dependencies dari `package.json`
- `npm run build` → compile asset CSS dan JavaScript untuk production

### 4. Konfigurasi Environment

**a. Copy File Environment**

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

**b. Edit File `.env`**

Buka file `.env` dengan text editor, kemudian sesuaikan konfigurasi database:

```env
APP_NAME="Resident Help"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_resident_help
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi MySQL Anda.

### 5. Buat Database

Buka **PHPMyAdmin** (biasanya di `http://localhost/phpmyadmin`), kemudian buat database baru dengan nama:

```
db_resident_help
```

**Cara:**
1. Klik tab "Databases"
2. Isi nama database: `db_resident_help`
3. Pilih Collation: `utf8mb4_unicode_ci`
4. Klik "Create"

### 6. Generate Key & Migrasi Database

Jalankan perintah berikut secara berurutan:

```bash
# Generate application key
php artisan key:generate

# Buat symbolic link untuk storage
php artisan storage:link

# Migrasi database dan isi data dummy
php artisan migrate:fresh --seed
```

**Penjelasan:**
- `key:generate` → membuat encryption key untuk aplikasi
- `storage:link` → membuat link simbolik agar file upload bisa diakses publik
- `migrate:fresh --seed` → membuat tabel database dan mengisi data dummy untuk testing

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

Buka browser dan akses URL tersebut.

---

## 🔑 Akun Login Default

Gunakan akun berikut untuk pengetesan awal:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@admin.com | password |
| **Nasabah** | nasabah@gmail.com | password |
| **Warga** | warga@gmail.com | password |

---

## 🔧 Troubleshooting

### Problem: Gambar upload tidak muncul
**Solusi:** Pastikan sudah menjalankan perintah:
```bash
php artisan storage:link
```

### Problem: Error saat composer install
**Solusi:** 
- Pastikan PHP sudah terinstall dan masuk ke PATH
- Cek versi PHP: `php -v` (minimal 8.1)
- Update composer: `composer self-update`

### Problem: Error saat npm install
**Solusi:**
- Pastikan Node.js sudah terinstall
- Cek versi Node: `node -v` (minimal v16)
- Clear cache: `npm cache clean --force`

### Problem: SQLSTATE Connection refused
**Solusi:**
- Pastikan MySQL/Apache sudah running di XAMPP/Laragon
- Cek konfigurasi `.env` (DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD)
- Test koneksi database dari PHPMyAdmin

### Problem: PDF tidak ter-generate dengan baik
**Solusi:**
- Library DomPDF membutuhkan koneksi internet untuk download font
- Pastikan koneksi internet stabil saat pertama kali generate PDF
- Clear cache: `php artisan cache:clear`

---

## 📝 Catatan Tambahan

- **Format Uang:** Input harga otomatis berubah format (misal: 100000 → 100.000) menggunakan JavaScript
- **Laporan PDF:** Menggunakan library DomPDF untuk generate laporan
- **Upload File:** Maksimal 2MB per file, format: JPG, PNG, PDF
- **Session Timeout:** Default 120 menit, bisa diubah di `config/session.php`

---

## 🚀 Development Mode

Jika ingin mengaktifkan hot-reload untuk development:

```bash
# Terminal 1: Jalankan Laravel
php artisan serve

# Terminal 2: Jalankan Vite (hot-reload)
npm run dev
```

---

## 📚 Struktur Folder Penting

```
resident-help/
├── app/                    # Logic aplikasi (Controllers, Models)
├── config/                 # File konfigurasi
├── database/
│   ├── migrations/         # Schema database
│   └── seeders/           # Data dummy
├── public/                 # Asset publik (CSS, JS, gambar)
├── resources/
│   ├── views/             # Template Blade
│   └── css/js/            # Source file frontend
├── routes/
│   └── web.php            # Routing aplikasi
├── storage/
│   └── app/public/        # File upload user
└── .env                   # Konfigurasi environment
```