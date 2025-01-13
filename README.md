<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Aplikasi Persediaan

Aplikasi Persediaan adalah aplikasi berbasis web yang dirancang untuk mendukung pengelolaan barang persediaan secara terpusat dan efisien di gudang suatu kantor atau perusahaan berskala kecil. Aplikasi ini memungkinkan pengguna untuk mengajukan permintaan barang, supervisor untuk memvalidasi permintaan, dan admin untuk mengelola stok barang.

## Langkah-Langkah Instalasi Aplikasi Persediaan
README: Langkah-Langkah Instalasi Aplikasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi dari GitHub:

1. Buat Database
   - Di sistem database Anda, buat database baru dengan nama `inv_app`.

2. Clone atau Pull Code dari GitHub
   - Unduh kode aplikasi dengan perintah berikut di terminal:
     git clone https://github.com/malfianperdana/persediaan_app
   - Atau, jika Anda sudah memiliki repositori, gunakan perintah:
     git pull

3. Konfigurasi File .env
   - Taruh file `.env` di folder proyek aplikasi. (File env : https://bit.ly/fileenv)
   - Buka file `.env` menggunakan editor teks.
   - Sesuaikan kredensial database di bagian berikut:
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=inv_app
     DB_USERNAME=<username_database>
     DB_PASSWORD=<password_database>

4. Buka Terminal di Folder Proyek
   - Arahkan terminal ke lokasi folder proyek menggunakan perintah:
     cd <path_ke_folder_proyek>

5. Pasang Dependencies
   - Jalankan perintah berikut untuk menginstal dependencies Node.js:
     npm install
   - Sambil menunggu proses ini selesai, Anda juga bisa menjalankan perintah untuk menginstal dependencies PHP:
     composer install
   - Catatan: Pastikan Node.js dan Composer sudah terinstal di komputer Anda.

6. Migrasi Database
   - Setelah instalasi dependencies selesai, jalankan perintah berikut untuk membuat tabel di database:
     php artisan migrate

7. Jalankan Server Aplikasi
   - Untuk mengaktifkan server aplikasi, jalankan perintah berikut:
     php artisan serve
   - Aplikasi akan berjalan di alamat http://localhost:8000 secara default.

8. Buka Aplikasi di Browser
   - Akses aplikasi melalui browser dengan mengetikkan:
     http://localhost:8000

Persiapan Prasyarat

- Node.js: Untuk menginstal `npm`, unduh dan instal Node.js dari Node.js Official Website: https://nodejs.org/
- Composer: Untuk menginstal `composer`, unduh dan instal Composer dari Composer Official Website: https://getcomposer.org/

Dengan mengikuti panduan ini, Anda seharusnya bisa menjalankan aplikasi tanpa masalah. Jika menemui kesulitan, jangan ragu untuk menghubungi tim pengembang.

Aplikasi ini dibuat untuk memenuhi tugas Mata Kuliah Pengembangan Perangkat Lunak
