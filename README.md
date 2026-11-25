# Sistem Peminjaman Buku - Modul 4 PAW

Aplikasi perpustakaan berbasis Laravel untuk mengelola buku, anggota, peminjaman, pengembalian, dan denda keterlambatan.

## Persiapan

1. Pastikan PHP, Composer, dan MySQL tersedia. Jalankan MySQL melalui XAMPP atau Laragon.
2. Pasang dependency:

   ```bash
   composer install
   ```

3. Buat file konfigurasi lokal dan application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Di Windows Command Prompt gunakan `copy .env.example .env`.

4. Atur koneksi database di `.env`, lalu isi kredensial akun seed secara lokal dengan email dan password kuat:

   ```dotenv
   SEED_ADMIN_EMAIL=
   SEED_ADMIN_PASSWORD=
   SEED_STUDENT_EMAIL=
   SEED_STUDENT_PASSWORD=
   ```

   Kredensial ini wajib disetel sebelum menjalankan seeder dan tidak boleh dimasukkan ke repository.

## Menjalankan aplikasi

Jalankan migrasi, isi data contoh, buat symlink penyimpanan sampul, lalu mulai server:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000`. Akun admin dan mahasiswa dibuat dari nilai `SEED_*` di `.env`.

## Pengujian

```bash
php artisan test
```
