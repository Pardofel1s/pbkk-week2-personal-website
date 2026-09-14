# PBKK Week 2 — Kamal Zaky Adinata

NRP: **5025241153** · S1 Teknik Informatika ITS

Profil akademis individu berbasis Laravel, dikembangkan dari `personal-website-complete` pada branch `import/website-sources` repository shzirley/pbkk-kelompok4 (snapshot af18555). Desain dan fitur personal dipertahankan. Commit pertama menyimpan source sebelum perubahan Week 2.

## Menjalankan

PHP 8.3+ dan Composer diperlukan. Dari folder proyek:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan serve --port=8002
```

Salin `.env` hanya pada instalasi pertama. Buka http://127.0.0.1:8002. Session dan cache memakai file; tidak perlu database atau npm build untuk halaman portfolio ini. Font Manrope dan Playfair Display disimpan lokal (lisensi ada di public/fonts). Bootstrap masih menggunakan CDN dan memerlukan internet.

## Routes Week 2

Semua route menggunakan GET dan named routes. Logika akademis ada pada `AcademicController`.

| Route | Method controller | Nama route | Peran |
| --- | --- | --- | --- |
| `/` | `PageController@index` | `home` | Sambutan dan profil singkat |
| `/mahasiswa/{nrp}` | `profile` | `student` | Profil pemilik NRP, tepat 10 digit |
| `/agent/{tema?}` | `agent` | `agent` | Tema opsional, default General Assistant Agent |
| `/hitung-ipk/{ipk1}/{ipk2}` | `gpa` | `gpa.calculate` | Rata-rata dua IP, rentang 0–4 |
| `/dashboard` | `dashboard` | `dashboard.index` | Navigasi akademis |
| `/dashboard/mahasiswa/{nrp}` | `profile` | `dashboard.student` | Profil dalam prefix dashboard |
| `/dashboard/agent/{tema?}` | `agent` | `dashboard.agent` | Tema AI dalam prefix dashboard |
| `/dashboard/ipk` | `gpaForm` | `dashboard.gpa` | Form IP |
| `/dashboard/ipk/submit` | `submit` | `dashboard.gpa.submit` | Validasi form dan redirect hasil |
| Route tidak ditemukan | `missing` | `fallback` | Halaman 404 |

Route portfolio lama tetap tersedia. `/project-idea` mengarahkan ke named route tema DAST. NRP valid yang bukan milik pemilik situs menghasilkan 404. Rata-rata IP memakai bobot semester sama, bukan penghitungan IPK resmi berbobot SKS.

## Ide proyek

Agentic AI untuk Dynamic Application Security Testing (DAST): memetakan halaman dan form, memilih pengujian berdasarkan respons HTTP, dan membuat laporan temuan serta saran perbaikan. Ini masih rancangan, dengan target pengujian lokal DVWA atau OWASP Juice Shop.

## Verifikasi

```powershell
php artisan route:list --except-vendor
php artisan test
php vendor/bin/pint --test app/Http/Controllers/AcademicController.php routes/web.php tests/Feature/AcademicTest.php
```

## Demo 5 menit

1. Home dan profil: tunjukkan parameter NRP wajib serta regex 10 digit.
2. Buka tema agent kosong dan tema DAST: jelaskan nilai default.
3. Buka dashboard: tunjukkan prefix dan named routes pada navigasi.
4. Hitung IP 3.5 dan 4; coba nilai salah serta halaman yang tidak tersedia.
5. Tunjukkan route:list dan alur route → controller → Blade.

Unggah tautan repository publik ke LMS paling lambat H-1 Pertemuan 3. `.env` dan `vendor/` tidak disertakan di Git.

## Tampilan dan navigasi

Mode terang/gelap tersedia dari tombol di header. Pilihan disimpan di browser; kunjungan pertama mengikuti tema perangkat. Dashboard menyediakan kartu untuk profil, ide DAST, dan kalkulator IPK. Sambutan ITS menyatu dengan hero Home. Animasi mengikuti preferensi reduced motion perangkat.

## Checklist pengumpulan

- Home, profil NRP wajib, tema AI opsional dengan default, dan kalkulator dua IP tersedia.
- Regex NRP tepat 10 digit, prefix dashboard, fallback 404, dan named routes diterapkan.
- Parameter kalkulator bernama ipk1 dan ipk2; URL contoh: /hitung-ipk/3.5/4.
- Unggah link repository ini ke LMS dan persiapkan demo 5 menit sesuai panduan di atas.
