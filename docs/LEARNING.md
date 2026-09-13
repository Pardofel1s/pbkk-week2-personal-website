# Panduan belajar dan Git

## Makna perintah Git

- `git init -b main`: mulai repositori lokal dengan branch main.
- `git add .`: masukkan perubahan yang tidak diabaikan ke staging.
- `git commit -m "pesan"`: simpan snapshot lokal.
- `git remote add origin URL`: hubungkan repositori lokal ke GitHub (sekali).
- `git push -u origin main`: unggah branch dan atur tujuan push berikutnya.
- `git switch -c nama-branch`: buat branch baru dan pindah ke sana, dalam folder yang sama.
- `git worktree add -b nama-branch ../folder-baru main`: buat branch dari main di folder kedua.
- `git diff main..feature/personal-website-complete`: bandingkan kode kedua versi.

Pada workspace ini semua tahap init, checkpoint, dan worktree sudah dikerjakan; tidak perlu diulang.

## Mengunggah perubahan belajar berikutnya

Jalankan dari folder personal-website (branch main):

```powershell
git status
git add .
git commit -m "Belajar: tambahkan halaman About"
git push
```

Ganti pesan commit sesuai perubahan. Jika tidak ada perubahan, tidak perlu commit.

## Mengunggah perubahan versi lengkap

Jalankan dari folder personal-website-complete:

```powershell
git status
git add .
git commit -m "Update personal website"
git push
```

Push pertama branch lengkap menggunakan:
```powershell
git push -u origin feature/personal-website-complete
```

## Melihat perbedaan untuk belajar

```powershell
git diff main..feature/personal-website-complete -- routes/web.php
git diff main..feature/personal-website-complete -- app/Http/Controllers/PageController.php
git diff main..feature/personal-website-complete -- resources/views/home.blade.php
git show checkpoint-home:app/Http/Controllers/PageController.php
```

Untuk membuat branch latihan baru tanpa mengubah main:

```powershell
git switch -c latihan/about
```

Perintah di atas dijalankan dalam folder personal-website ketika pekerjaan lokal sudah disimpan. Folder itu lalu memakai branch latihan/about, sedangkan versi lengkap tetap tersedia dalam foldernya sendiri.

## Alur yang dijelaskan saat demo

Browser meminta GET / → routes/web.php memilih PageController::index → controller menyiapkan data dari config/portfolio.php → home.blade.php mewarisi layouts/app.blade.php → Laravel mengirim HTML ke browser.

Router mendaftarkan pemetaan URL dan metode HTTP; baris route bukan pemanggilan langsung index(). Controller baru dijalankan saat ada request yang cocok. Controller dan route dipisah untuk membedakan aturan URL dari pengolahan permintaan.

Kalkulator: browser meminta /hitung/10/5/kali → PageController::hitung memvalidasi parameter dan menghitung → calculator.blade.php menampilkan 50. Coba /hitung/10/0/bagi untuk memperlihatkan penanganan error.

## Kerangka presentasi kelompok minimal 5 slide

1. Identitas anggota dan lingkungan PHP/Composer/Laravel.
2. Struktur folder: routes, app/Http/Controllers, resources/views, public.
3. Diagram alur route → controller → view.
4. Screenshot dan navigasi website; jelaskan penggunaan layout Blade bersama.
5. Demo kalkulator, validasi, GitHub, dan refleksi singkat.

Ini kerangka isi, bukan file presentasi final. Sesuaikan dengan anggota kelompok dan hasil instalasi mereka.
