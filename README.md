# Portal IKA SMANSA 277 Sinjai

Portal resmi untuk pendataan dan informasi alumni IKA SMANSA / 277 Sinjai.

## Fitur Utama
- **Pendataan Alumni:** Pendaftaran dan pengelolaan profil alumni secara mandiri.
- **Sistem QR Code:** Pembuatan QR Code otomatis untuk rujukan dan verifikasi profil.
- **Dashboard Statistik:** Visualisasi data alumni yang interaktif.
- **Manajemen Berita:** Pengelolaan berita dan informasi terbaru untuk komunitas.

## Persyaratan Sistem
- PHP 8.2 ke atas
- MySQL atau MariaDB
- Node.js & NPM (untuk Tailwind CSS)

## Cara Instalasi
1. **Instal dependensi PHP:**
   ```bash
   composer install
   ```
2. **Instal dependensi JS:**
   ```bash
   npm install
   ```
3. **Konfigurasi Lingkungan:**
   Salin file `env` menjadi `.env` lalu sesuaikan `app.baseURL` dan konfigurasi database.
4. **Build Aset:**
   ```bash
   npm run build
   ```

## Pengembangan
- **Menjalankan Tailwind (Watch):** `npm run dev`
- **Menjalankan Server Lokal:** `php spark serve`

## Lisensi
[MIT](LICENSE)
