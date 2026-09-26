# PBKK Week 4 — Blade Templating & Vite

NRP: **5025241153** · S1 Teknik Informatika ITS

Website profil akademis individu berbasis Laravel untuk tugas mandiri PBKK. Aplikasi ini mempraktikkan Blade templating, master layout, reusable components, passing data dari controller, serta bundling Bootstrap dan Tailwind melalui Vite.

## Menjalankan

PHP 8.3+ dan Composer diperlukan. Dari folder proyek:

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
npm run build
php artisan serve --port=8002
```

Salin `.env` hanya pada instalasi pertama. Buka http://127.0.0.1:8002. Session dan cache memakai file. Bootstrap, Tailwind, CSS, dan JavaScript entry point diproses melalui Vite; tidak ada Bootstrap CDN. Font Manrope dan Playfair Display disimpan lokal di `public/fonts`.

## Routes tugas mandiri

Semua route menggunakan GET dan named routes. Logika akademis ada pada `AcademicController`.

| Route | Method controller | Nama route | Peran |
| --- | --- | --- | --- |
| `/` | `PageController@index` | `home` | Sambutan dan profil singkat |
| `/beranda?user=Andi` | `PageController@index` | `beranda` | Challenge pesan pengguna dinamis |
| `/profil-mahasiswa` | `PageController@profile` | `profile` | Halaman profil akademis |
| `/ide-agent/{tema?}` | `PageController@agent` | `agent.idea` | Ide Agentic AI dengan tema opsional |
| `/mahasiswa/{nrp}` | `profile` | `student` | Profil pemilik NRP, tepat 10 digit |
| `/agent/{tema?}` | `agent` | `agent` | Tema opsional, default General Assistant Agent |
| `/hitung-ipk/{ipk1}/{ipk2}` | `gpa` | `gpa.calculate` | Rata-rata dua IP, rentang 0–4 |
| `/dashboard` | `dashboard` | `dashboard.index` | Navigasi akademis |
| `/dashboard/mahasiswa/{nrp}` | `profile` | `dashboard.student` | Profil dalam prefix dashboard |
| `/dashboard/agent/{tema?}` | `agent` | `dashboard.agent` | Tema AI dalam prefix dashboard |
| `/dashboard/ipk` | `gpaForm` | `dashboard.gpa` | Form IP |
| `/dashboard/ipk/submit` | `submit` | `dashboard.gpa.submit` | Validasi form dan redirect hasil |
| Route tidak ditemukan | `missing` | `fallback` | Halaman 404 |

Route portfolio dan route Week 2 tetap tersedia sebagai fitur tambahan. NRP valid yang bukan milik pemilik situs menghasilkan 404. Rata-rata IP memakai bobot semester sama, bukan penghitungan IPK resmi berbobot SKS.

## Blade dan komponen reusable

Semua halaman mewarisi `resources/views/layouts/app.blade.php` melalui `@extends`. Layout memusatkan title dinamis, navigasi, `@yield('content')`, footer, dan directive `@vite`.

Dua komponen custom digunakan pada view akademis:

- `<x-info-card>` untuk menampilkan label dan nilai profil secara reusable.
- `<x-status-banner>` untuk notifikasi status dengan tipe `success`, `warning`, `error`, atau `info`.

Data profil dikirim dari controller dan dicetak melalui sintaks Blade ter-escape `{{ }}`. View juga menggunakan directive kondisional dan parameter query `user` serta `mode`.

## Ide Agentic AI

Halaman Agent memperkenalkan gagasan Agentic AI untuk DAST. Tema dapat diberikan melalui parameter opsional, misalnya `/ide-agent/dast`; jika kosong, tema default adalah General Assistant Agent. Implementasi scanner atau agen belum menjadi bagian tugas ini.

## Verifikasi

```powershell
php artisan route:list --except-vendor
php artisan test
php vendor/bin/pint --test app/Http/Controllers/AcademicController.php routes/web.php tests/Feature/AcademicTest.php
```

## Demo maksimal 3 menit

1. Tunjukkan master layout dan tiga halaman anak.
2. Tunjukkan `<x-info-card>` dan `<x-status-banner>`.
3. Buka `/profil-mahasiswa` dan `/ide-agent/dast?mode=dark`.
4. Buka `/beranda?user=Andi` untuk menunjukkan data query dinamis.
5. Jalankan `npm run build` dan `php artisan route:list`.

Unggah tautan repository publik ke LMS paling lambat H-1 Pertemuan 3. `.env` dan `vendor/` tidak disertakan di Git.

## Tampilan dan navigasi

Mode terang/gelap tersedia dari tombol di header. Pilihan disimpan di browser; kunjungan pertama mengikuti tema perangkat. Dashboard menyediakan kartu untuk profil, ide DAST, dan kalkulator IPK. Sambutan ITS menyatu dengan hero Home. Animasi mengikuti preferensi reduced motion perangkat.

## Checklist pengumpulan

- Master layout dipakai seluruh halaman dan tidak ada duplikasi struktur HTML global.
- `<x-info-card>` dan `<x-status-banner>` dibuat serta dipanggil dari view.
- Bootstrap/Tailwind dipasang dari NPM dan di-bundle melalui Vite.
- Route `/`, `/profil-mahasiswa`, `/ide-agent`, parameter `user`, dan parameter `mode` dapat didemokan.
- Unggah link repository ini ke LMS dan siapkan demo maksimal 3 menit.
