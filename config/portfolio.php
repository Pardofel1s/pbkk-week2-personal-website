<?php

return [
    'name' => 'Kamal Zaky Adinata',
    'short_name' => 'Kamal',
    'nrp' => '5025241153',
    'brand' => 'PARDOFELIS',
    'location' => 'Surabaya, Indonesia',
    'email' => 'nonamexz1728@gmail.com',
    'phone' => '082142560082',
    'whatsapp' => '6282142560082',
    'socials' => [
        'GitHub' => 'https://github.com/Pardofel1s',
        'LinkedIn' => 'https://www.linkedin.com/in/kamalzadinata/',
    ],
    'repository' => 'https://github.com/Pardofel1s/pbkk-personal-website/tree/feature/personal-website-complete',
    'projects' => [
        ['title' => 'A little corner of the internet.', 'subtitle' => 'Personal website', 'description' => 'Rumah digital untuk profil, eksperimen visual, dan catatan belajar. Dibangun untuk tugas pertama PBKK.', 'stack' => ['Laravel', 'Blade', 'Bootstrap'], 'status' => 'In Progress', 'visual' => 'portfolio', 'route' => 'home'],
        ['title' => 'Small details, a little motion.', 'subtitle' => 'CSS playground', 'description' => 'Eksperimen kartu bertumpuk, permukaan kaca, dan warna organik yang bisa dicoba langsung di Home.', 'stack' => ['CSS', 'JavaScript'], 'status' => 'Experimental', 'visual' => 'playground', 'route' => 'home', 'anchor' => '#playground'],
        ['title' => 'A place for everyday numbers.', 'subtitle' => 'Kalkulator dinamis', 'description' => 'Empat operasi dasar, input desimal, dan hasil yang bisa dibuka kembali melalui URL.', 'stack' => ['PHP', 'Laravel'], 'status' => 'Finished', 'visual' => 'calculator', 'route' => 'calculator'],
    ],
    // Referensi website ini; ganti dengan koleksi pribadi sesuai keinginan.
    'collection' => [
        ['title' => 'Playfair Display', 'category' => 'Typography', 'description' => 'Serif ekspresif yang menjadi suara utama judul website ini.', 'visual' => 'type', 'mark' => 'Aa', 'url' => 'https://fonts.google.com/specimen/Playfair+Display'],
        ['title' => 'Warm Editorial Aura', 'category' => 'Design', 'description' => 'Catatan warna: coral, peach, dan hijau yang bertemu di satu kanvas.', 'visual' => 'palette', 'mark' => '', 'url' => null],
        ['title' => 'Laravel documentation', 'category' => 'Learning', 'description' => 'Referensi untuk menelusuri route, controller, dan Blade.', 'visual' => 'laravel', 'mark' => '{ L }', 'url' => 'https://laravel.com/docs'],
        ['title' => 'Manrope', 'category' => 'Typography', 'description' => 'Sans-serif yang menjaga navigasi dan isi tetap sederhana.', 'visual' => 'manrope', 'mark' => 'Mm', 'url' => 'https://fonts.google.com/specimen/Manrope'],
        ['title' => 'CSS on MDN', 'category' => 'Learning', 'description' => 'Tempat kembali saat bereksperimen dengan layout dan transisi.', 'visual' => 'mdn', 'mark' => 'CSS', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/CSS'],
        ['title' => 'The envelope study', 'category' => 'Design', 'description' => 'Studi tumpukan kertas dari mockup awal, diwujudkan menjadi interaksi CSS.', 'visual' => 'envelope', 'mark' => '↗', 'url' => null],
    ],
    'articles' => [
        'route-controller-dan-view' => [
            'title' => 'Satu URL, tiga bagian yang bekerja bersama.', 'category' => 'Laravel', 'date' => '2026-09-05', 'reading_time' => '3 menit',
            'summary' => 'Menelusuri perjalanan request dari address bar sampai menjadi halaman Home.',
            'sections' => [
                ['heading' => 'Mulai dari sebuah alamat', 'text' => 'Saat pengunjung membuka halaman Home, browser mengirimkan request GET ke /. Router mencocokkan alamat dan metode HTTP itu dengan aturan yang sudah didaftarkan. Aturan route menunjukkan controller dan method yang akan menangani permintaan.'],
                ['heading' => 'Controller menyiapkan respons', 'text' => 'PageController::index() menyiapkan nama dan NRP, lalu menyerahkan data tersebut ke view home. Untuk profil statik, data dapat berasal dari konfigurasi sederhana. Database baru diperlukan ketika aplikasi membutuhkan penyimpanan dan perubahan data.'],
                ['heading' => 'Blade menjadi halaman yang terlihat', 'text' => 'Blade menerima data dan merender HTML. Penulisan {{ $nama }} menampilkan nama dengan escaping HTML. Browser kemudian menampilkan HTML hasilnya. Pemisahan ini membuat perubahan alamat, pengolahan data, dan tampilan lebih mudah ditelusuri.'],
            ],
        ],
        'menerjemahkan-warm-editorial-aura' => [
            'title' => 'Dari palet warna menjadi sebuah suasana.', 'category' => 'Design', 'date' => '2026-09-05', 'reading_time' => '2 menit',
            'summary' => 'Catatan implementasi gradasi hangat, tipografi serif, dan ruang kosong dari DESIGN.md.',
            'sections' => [
                ['heading' => 'Satu palet, peran yang berbeda', 'text' => 'Coral menjadi aksen pada badge dan kartu. Hijau memberi arah pada tombol utama, sementara peach menjadi dasar gradasi. Teks panjang menggunakan warna espresso yang lebih gelap agar tetap mudah dibaca.'],
                ['heading' => 'Tipografi membentuk hierarki', 'text' => 'Playfair Display digunakan untuk judul ekspresif. Manrope digunakan untuk paragraf dan navigasi. Ukuran judul beradaptasi dengan lebar layar, sementara isi artikel memiliki lebar baca terbatas agar mata tidak menelusuri baris yang terlalu panjang.'],
                ['heading' => 'Gerakan yang punya tujuan', 'text' => 'Kartu pada Home dapat dibuka melalui tombol. Transisi memperlihatkan hubungan antara tumpukan dan kartu di dalamnya. Pengaturan reduced motion dihormati supaya interaksi tetap nyaman bagi pengunjung yang memilih mengurangi animasi.'],
            ],
        ],
        'checkpoint-pertama-dengan-git' => [
            'title' => 'Menyimpan proses, bukan hanya hasil akhir.', 'category' => 'Learning', 'date' => '2026-09-05', 'reading_time' => '3 menit',
            'summary' => 'Menggunakan checkpoint dan branch untuk membandingkan versi belajar dengan versi lengkap.',
            'sections' => [
                ['heading' => 'Commit sebagai titik yang bisa dikunjungi lagi', 'text' => 'Commit menyimpan snapshot file yang dilacak Git. Versi awal Home dapat dipertahankan sebagai titik belajar, sehingga perubahan berikutnya bisa dibandingkan dengan fondasi yang lebih sederhana.'],
                ['heading' => 'Branch untuk arah pengerjaan yang berbeda', 'text' => 'Branch main menyimpan checkpoint awal. Branch feature/personal-website-complete mengembangkan website lengkap. Kedua branch mempunyai riwayat awal yang sama, tetapi dapat berkembang secara terpisah.'],
                ['heading' => 'Worktree untuk dua folder sekaligus', 'text' => 'Git worktree memungkinkan kedua branch dibuka di folder yang berbeda. Versi awal tetap bisa dijalankan saat versi lengkap sedang dikerjakan. File lokal seperti .env, vendor, dan database SQLite tidak ikut masuk ke repositori.'],
            ],
        ],
    ],
];
