# PBKK Week 4 — Blade Templating & Vite

NRP: **5025241153** · S1 Teknik Informatika ITS

Mini-website akademik individu berbasis Laravel untuk Tugas 4 PBKK. Website ini memuat profil akademik, rancangan Agentic AI, serta formulir masukan. Implementasinya mempraktikkan Blade templating, master layout, reusable components, passing data dari controller, serta bundling Tailwind melalui Vite.

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

Salin `.env` hanya pada instalasi pertama. Buka http://127.0.0.1:8002. Session dan cache memakai file. Tailwind dan CSS diproses melalui Vite lokal tanpa CDN; interaksi situs memakai berkas JavaScript lokal. Font Manrope dan Playfair Display disimpan lokal di `public/fonts`.

## Routes tugas mandiri

Tiga halaman inti tugas menggunakan named routes dan satu `PageController`. Formulir ide menggunakan route POST yang terpisah; route tambahan Week 2 tetap dilayani `AcademicController`.

| Route | Method controller | Nama route | Peran |
| --- | --- | --- | --- |
| `/` | `PageController@index` | `home` | Sambutan dan profil singkat |
| `/beranda?user=Andi` | `PageController@index` | `beranda` | Challenge pesan pengguna dinamis |
| `/profil-mahasiswa` | `PageController@profile` | `profile` | Halaman profil akademis |
| `/ide-agent/{tema?}` | `PageController@agent` | `agent.idea` | Ide Agentic AI dengan tema opsional; default General Assistant Agent |
| `/ide-agent/masukan` | `PageController@submitIdea` | `agent.idea.submit` | Validasi dan penerimaan masukan ide |
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

Komponen custom dipakai dengan props, merged attributes, dan default slot:

- `<x-info-card>` untuk menampilkan label dan nilai profil secara reusable.
- `<x-status-banner>` untuk notifikasi status dengan tipe `success`, `warning`, `error`, atau `info`.

Banner digunakan untuk pesan form dan ucapan selamat datang. Data profil dikirim dari controller dan dicetak melalui sintaks Blade ter-escape `{{ }}`. View juga menggunakan directive kondisional dan parameter query `user` serta `mode`.

## Ide Agentic AI

Halaman Ide-Riset memperkenalkan rancangan Agentic AI untuk DAST. Tema dapat diberikan melalui parameter opsional, misalnya `/ide-agent/dast`; jika kosong, tema default adalah General Assistant Agent. Form meminta nama dan ide, memvalidasi isinya, lalu menampilkan tanda terima untuk sesi demo. Masukan belum disimpan permanen atau masuk database. Implementasi scanner atau agen belum menjadi bagian tugas ini.

## Verifikasi

```powershell
php artisan route:list --except-vendor
php artisan test
php vendor/bin/pint --test app/Http/Controllers/AcademicController.php routes/web.php tests/Feature/AcademicTest.php
```

## Demo maksimal 3 menit

1. Tunjukkan master layout, lalu buka `/`, `/profil-mahasiswa`, dan `/ide-agent/dast`.
2. Tunjukkan `<x-info-card>`, `<x-status-banner>`, dan formulir masukan.
3. Buka `/ide-agent?mode=dark` dan `/beranda?user=Andi` untuk menunjukkan dua challenge.
4. Jalankan `npm run build` dan `php artisan route:list`.

Unggah tautan repository publik ke LMS paling lambat H-1 jadwal perkuliahan minggu depan. Siapkan demo acak maksimal 3 menit pada awal Pertemuan 5. `.env` dan `vendor/` dikecualikan melalui `.gitignore`.

## Tampilan dan navigasi

Mode terang/gelap tersedia dari tombol di header. Pilihan disimpan di browser; kunjungan pertama mengikuti tema perangkat. Tampilan memakai konsep personal field journal: tumpukan surat interaktif di Home, halaman proyek berbentuk studi editorial, koleksi seperti rak spesimen, blog sebagai indeks catatan, dan kalkulator sebagai lembar kerja dua panel. Tombol K membuka pemutar SoundCloud resmi untuk *Everything Goes On*. Tombol putar dan progress bar di panel memakai Widget API SoundCloud; waveform native tetap tersedia sebagai cadangan. Musik mulai setelah pengunjung menekan putar, tetap berjalan saat panel ditutup, dan pemutar baru dimuat saat pertama kali dibuka.

Animasi mengikuti aksi pengguna dan kemunculan konten, bukan loop dekoratif. Pembaca surat memakai native dialog dan mendukung Escape serta tombol panah. Cursor desktop meninggalkan guratan tinta kecil pada mode terang dan glint hangat pada mode gelap; efek dimatikan pada layar sentuh dan preferensi reduced motion. Catatan referensi dan keputusan desain tersedia di [`docs/design/UI_REDESIGN.md`](docs/design/UI_REDESIGN.md).

Studi visual tambahan mencatat **2.108 listing portofolio Awwwards** sebagai katalog indeks, lalu meninjau langsung sampel bertingkat 24 entri: 15 dapat dinilai secara visual, dua hanya termuat sebagian, dan empat tidak tersedia pada browser pemeriksaan. Angka katalog bukan klaim bahwa 2.108 situs semuanya dibuka. Metode, hasil, dan keterbatasannya ada di [`docs/research/portfolio-live-review.md`](docs/research/portfolio-live-review.md).

## Kesesuaian Tugas 4

- `/`, `/profil-mahasiswa`, dan `/ide-agent` ditangani `PageController` serta mewarisi satu master layout.
- `<x-info-card>` dan `<x-status-banner>` memakai props, attributes, dan slot.
- Form masukan tervalidasi dan memberi tanda terima sesi tanpa database.
- Tailwind dipasang dari NPM dan di-bundle lewat Vite lokal; tidak memakai CDN.
- Challenge tema `?mode=dark` dan sapaan `/beranda?user=Andi` dapat didemokan.
- `.env`, `vendor/`, `node_modules/`, dan hasil build lokal dikecualikan dari Git.
