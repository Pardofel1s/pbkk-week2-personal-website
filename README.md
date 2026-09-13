# Pardofelis — Kamal's personal website

Personal website untuk tugas pertama PBKK, menggunakan Laravel 13, Blade, Bootstrap 5 melalui CDN, dan CSS/JavaScript khusus berdasarkan **Warm Editorial Aura**.

## Dua versi untuk belajar

| Versi | Git | Folder lokal pada workspace ini |
| --- | --- | --- |
| Home sederhana buatan Kamal | `main`, tag `checkpoint-home`, commit `3576eae` | `../personal-website` |
| Website lengkap | `feature/personal-website-complete` | `../personal-website-complete` |

Kedua folder adalah Git worktree dari repositori yang sama. Branch versi lengkap tidak digabungkan ke `main`. Jangan memakai `git switch` ke branch yang sedang dipakai worktree lain; buka folder yang sesuai.

## Menjalankan versi lengkap setelah clone baru

Persyaratan: PHP 8.3+ (diverifikasi dengan PHP 8.4.14), Composer, ekstensi Laravel dan PDO SQLite. Git, PHP, Composer sudah tersedia di komputer yang digunakan saat implementasi.

PowerShell:

```powershell
git clone --branch feature/personal-website-complete https://github.com/Pardofel1s/pbkk-personal-website.git
cd pbkk-personal-website
composer install
Copy-Item .env.example .env
composer run-script post-create-project-cmd
php artisan serve --port=8001
```

Buka http://127.0.0.1:8001. Untuk worktree lokal yang telah disiapkan, cukup jalankan `php artisan serve --port=8001` jika servernya belum hidup. Jika port terpakai, gunakan port lain yang kosong.

Tidak perlu `npm install` atau build Vite untuk halaman portofolio ini. Bootstrap dimuat dari CDN sesuai tugas, font dari Google Fonts, serta CSS/JS langsung dari `public`. Koneksi internet diperlukan untuk Bootstrap dan font tersebut; font sistem tersedia sebagai fallback. Dependensi Vite bawaan dipertahankan agar dapat dipelajari kemudian.

Untuk demo gunakan `php artisan serve`, bukan `composer run dev` bawaan yang ikut menjalankan worker dan Laravel Pail.

## Isi website

- Home: nama lengkap, NRP, kartu envelope yang bisa dibuka, demo kartu, slider blur, dan pilihan warna.
- About: profil Departemen Teknik Informatika ITS beserta tautan sumber resmi.
- Projects: tiga item yang benar-benar ada di versi ini: personal website, CSS playground, dan kalkulator.
- Project Idea: usulan **Database Health Checker & Performance Monitor**. Masih bahan diskusi, bukan keputusan kelompok atau implementasi AI.
- Contact: email, WhatsApp, GitHub, LinkedIn yang diberikan pemilik.
- Collection: enam referensi visual dan belajar, dengan filter kategori.
- Blog: tiga catatan implementasi lengkap, halaman detail, pencarian dan filter, serta keadaan tanpa hasil.
- Kalkulator: tambah, kurang, kali, bagi, angka negatif/desimal, validasi angka dan operasi, serta penanganan pembagian nol.
- Halaman 404, navigasi aktif, menu mobile, fokus keyboard, dan reduced motion.

## Pemetaan ketentuan dosen

| Ketentuan | Implementasi |
| --- | --- |
| GET / | PageController::index → home.blade.php |
| Nama lengkap + NRP | Kamal Zaky Adinata — 5025241153 |
| GET /about | PageController::about → about.blade.php |
| GET /project-idea | PageController::project → project.blade.php |
| Tidak ada closure untuk merender halaman | Seluruh route aplikasi dalam routes/web.php diarahkan ke PageController |
| GET /hitung/{angka1}/{angka2}/{operasi} | PageController::hitung menghitung di PHP |
| Empat operasi | tambah, kurang, kali, bagi |
| Bootstrap 5/Tailwind via CDN | Bootstrap 5.3.8 CSS melalui jsDelivr |
| Navbar responsif | Home, About, Projects, Collection, Blog, Kalkulator, Contact |
| GitHub, tanpa vendor dan .env | .gitignore bawaan; SQLite lokal juga diabaikan |

Form GET di /kalkulator mengirim input ke /kalkulator/submit, yang memvalidasi bentuk input lalu mengarahkan ke URL hitung yang diwajibkan. Hasil perhitungan tidak memakai eval atau perhitungan JavaScript. Input dibatasi ±1 triliun dan panjang 32 karakter; hasil ditampilkan hingga 12 digit signifikan. Input tak valid menghasilkan halaman error yang tetap dapat diedit dengan status HTTP 422.

## Urutan membaca kode

1. `routes/web.php`: peta URL dan controller tujuan.
2. `app/Http/Controllers/PageController.php`: method per halaman dan logika kalkulator.
3. `config/portfolio.php`: identitas, kontak, daftar project, koleksi, artikel.
4. `resources/views/layouts/app.blade.php`: kerangka bersama, font, CSS, navbar, footer.
5. `resources/views/home.blade.php`: konten Home menggunakan @extends dan @section.
6. `public/css/portfolio.css`: token warna, layout, komponen, dan breakpoint.
7. `public/js/portfolio.js`: perilaku interaktif tanpa mengubah perhitungan PHP.

Data statik tidak memerlukan model Eloquent tambahan. Model/migrasi bawaan Laravel tetap tersedia untuk latihan berikutnya.

## Menyesuaikan konten

Edit `config/portfolio.php` untuk kontak, proyek, koleksi, dan artikel. Ini konten publik website; jangan menaruh password atau API key di sana.

Edit `resources/views/project.blade.php` setelah kelompok menentukan ide final. Isi koleksi adalah referensi yang digunakan dalam website, bukan daftar hobi yang diasumsikan. Artikel adalah catatan implementasi awal yang boleh diedit oleh pemilik sebelum pengumpulan.

Pada preview project, visual dibuat sebagai komponen CSS yang merepresentasikan fitur website. Ganti dengan screenshot asli jika ingin memamerkan project lain.

## Verifikasi

```powershell
php artisan test --compact
php vendor/bin/pint --test
php artisan route:list --except-vendor
php artisan view:cache
node --check public/js/portfolio.js
```

Hasil implementasi: **29 tests passed, 86 assertions**. Rincian pemeriksaan browser ada di `docs/VALIDATION.md`.

## Pengumpulan dan demo

- Tautan branch yang berisi tugas lengkap: https://github.com/Pardofel1s/pbkk-personal-website/tree/feature/personal-website-complete
- Repositori dibuat private; berikan akses ke dosen atau sesuaikan visibilitas sesuai mekanisme pengumpulan kampus.
- Ambil screenshot Home yang menampilkan nama dan NRP.
- Menurut materi tugas: tautan GitHub + screenshot melalui LMS paling lambat H-1 pukul 23.59 WIB sebelum pertemuan 2.
- Kelompok menyiapkan minimal 5 slide dan siap demo individual maksimal 5 menit.
- Panduan Git dan kerangka demo: `docs/LEARNING.md`.

## Sumber

- Desain dan alur milik pengguna: `docs/design/DESIGN.md` dan `docs/design/WebFlow.md`.
- Profil jurusan: https://www.its.ac.id/informatika/
- Laravel: https://laravel.com/docs
- Bootstrap CDN: https://getbootstrap.com/docs/5.3/getting-started/introduction/
- Font: Playfair Display dan Manrope melalui Google Fonts.

## Animasi UI

`public/css/motion.css` mengatur gerakan visual dan `public/js/motion.js` mengatur scroll reveal, tilt, ripple, serta progress membaca. Tombol **Animations: on/off** di footer menyimpan preferensi. Pengaturan reduced motion perangkat selalu diutamakan. Transisi antarhalaman aktif pada browser yang mendukung View Transitions.
