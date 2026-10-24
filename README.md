<p align="center">
  <img src="public/images/logo2.png" width="160" alt="ReUseMart Logo">
</p>

<h1 align="center">ReUseMart</h1>

<p align="center">
  <strong>Platform E-Commerce & Konsinyasi Barang Bekas Berkualitas</strong>
</p>

<p align="center">
  Platform web e-commerce berbasis konsinyasi (titip jual) dan penyaluran donasi sosial yang menghubungkan pembeli, penitip barang, pengelola gudang, customer service, kurir, hunter, organisasi sosial, dan pemilik bisnis (owner) dalam satu sistem terpadu.
</p>

---

## Fitur Utama

- **Katalog & Pembelian Pelanggan:** Pencarian produk titipan, filter kategori, keranjang belanja, integrasi rating penitip, pembayaran virtual account, serta pelacakan pengiriman dan pengambilan barang.
- **Portal Penitip Barang:** Pendaftaran barang titipan, pemantauan status penjualan barang, perhitungan bagi hasil dan saldo dompet, serta perpanjangan masa titip.
- **Portal Organisasi Sosial:** Pengajuan permohonan donasi barang, pelacakan riwayat alokasi bantuan, dan konfirmasi penerimaan barang donasi.
- **Manajemen Operasional Gudang:** Penerimaan barang dan pencatatan Quality Control (QC), pencetakan nota serah terima barang titipan, penataan stok gudang, proses pengembalian barang tidak terjual, serta penjadwalan kurir pengiriman.
- **Customer Service:** Verifikasi bukti pembayaran transaksi, layanan forum diskusi tanya-jawab produk, pengelolaan data penitip, dan pencatatan klaim reward merchandise pelanggan.
- **Laporan & Eksekutif Owner:** Dashboard visualisasi penjualan bulanan (Chart.js), laporan penjualan per kategori, laporan komisi bersih, laporan stok gudang, laporan barang habis masa titip, dan pengelolaan alokasi donasi sosial.

---

## Teknologi yang Digunakan

- **Backend Framework:** Laravel 11 (PHP 8.2+)
- **Database Engine:** MySQL / TiDB Cloud
- **Frontend & Styling:** Bootstrap 5.3, Blade Templating, Google Fonts (Plus Jakarta Sans)
- **Pencetakan Dokumen:** DomPDF / Barryvdh Laravel-DOMPDF untuk nota transaksi dan laporan resmi

---

## Kredensial Akun Pengujian

Akses halaman login pada alamat: `http://localhost:8000/login`

> **Petunjuk Login:**
> 1. Buka halaman login.
> 2. Pilih **Tipe Pengguna** (*Pegawai*, *Pembeli*, *Penitip*, atau *Organisasi*).
> 3. Masukkan kredensial pengujian berikut.

### 1. Akun Pegawai (Tipe Pengguna: Pegawai)

Setiap akun pegawai akan otomatis diarahkan ke dashboard operasional sesuai jabatannya.

| Jabatan | Nama Pegawai | Email Login | Password | Akses Halaman |
| :--- | :--- | :--- | :--- | :--- |
| **Owner** | Raka Pratama | `raka@reusmart.com` | `password123` | Dashboard Owner & Laporan Eksekutif |
| **Kepala Gudang** | Rani Astuti | `rani@reusmart.com` | `password123` | Dashboard Kepala Gudang |
| **Customer Service** | Dina Rahmawati | `dina@reusmart.com` | `password123` | Verifikasi Pembayaran & Diskusi |
| **Admin** | Andri Setiawan | `andri@reusmart.com` | `password123` | Manajemen Organisasi & Top Seller |
| **Pegawai Gudang** | Bayu Prasetyo | `bayu@reusmart.com` | `password123` | QC Barang, Nota Penitipan, Pengiriman |
| **Kurir** | Cahyono | `cahyono@reusmart.com` | `password123` | Jadwal Pengantaran Barang |
| **Hunter** | Tono Wahyudi | `tono@reusmart.com` | `password123` | Pengadaan Barang Titipan |

---

### 2. Akun Pembeli (Tipe Pengguna: Pembeli)

| Nama Pembeli | Email Login | Password | Status Akun |
| :--- | :--- | :--- | :--- |
| **Aulia Dindasari** | `dindz01@mail.com` | `password1` | Aktif |

---

### 3. Akun Penitip (Tipe Pengguna: Penitip)

| Nama Penitip | Email Login | Password | Status Akun |
| :--- | :--- | :--- | :--- |
| **Yohanis Mabel** | `yohanis@mail.com` | `pass123` | Aktif |

---

### 4. Akun Organisasi Sosial (Tipe Pengguna: Organisasi)

Pada form login, pilih tipe pengguna **Organisasi**, pilih nama organisasi pada menu dropdown, dan masukkan password terkait.

| Nama Organisasi | Password | Status Akun |
| :--- | :--- | :--- |
| **Panti Asuhan Pelita Hati** | `pelita123` | Aktif |

---

## Panduan Instalasi & Menjalankan Proyek

### Prasyarat Sistem
- PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `curl`, `mbstring`, `openssl`, `gd`)
- Composer
- Web Server / MySQL Database

### Langkah Instalasi

1. **Clone repositori:**
   ```bash
   git clone <url-repository-anda>
   cd reusmart_p3l_web
   ```

2. **Pasang dependensi PHP:**
   ```bash
   composer install
   ```

3. **Buat berkas konfigurasi lingkungan:**
   Salin berkas template lingkungan ke `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Konfigurasi basis data:**
   Buka berkas `.env` dan sesuaikan koneksi database Anda (nama basis data, username, dan password database lokal/server):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database_anda
   DB_PASSWORD=password_database_anda
   ```

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Basis Data:**
   ```bash
   php artisan migrate
   ```

7. **Bersihkan Cache Aplikasi:**
   ```bash
   php artisan optimize:clear
   ```

8. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban web pada alamat: `http://localhost:8000`

---

## Standar Arsitektur & Kualitas Kode

- **Separation of Concerns:** Pemisahan tanggung jawab yang jelas antara Controller, Service, Model, dan Blade View.
- **Custom UI Action Validation:** Seluruh formulir menerapkan atribut `novalidate` dan validasi antarmuka berbasis modal/toast kustom tanpa mengandalkan dialog native browser (`alert`, `confirm`, `prompt`).
- **Unified Brand Design:** Palet warna konsisten berbasis tema resmi ReUseMart (Olive Green `#6f8f46`) pada seluruh alur pengguna.
