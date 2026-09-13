<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademicController extends Controller
{
    private function page(string $title, string $description, array $extra = [])
    {
        return view('academic', array_merge(['profile' => config('portfolio'), 'title' => $title, 'description' => $description], $extra));
    }

    public function dashboard()
    {
        return $this->page('My academic space.', 'Profil, ide proyek, dan perjalanan belajar di Informatika ITS.');
    }

    public function profile(string $nrp)
    {
        abort_unless($nrp === config('portfolio.nrp'), 404);

        return $this->page(config('portfolio.name'), 'Mahasiswa S1 Teknik Informatika, Institut Teknologi Sepuluh Nopember. Angkatan 2024. Melalui PBKK, saya mempelajari routing, controller, dan pengembangan aplikasi menggunakan Laravel.', ['showProfile' => true]);
    }

    public function agent(string $tema = 'General Assistant Agent')
    {
        $description = match (strtolower($tema)) {
            'dast' => 'Pengembangan Agentic AI untuk Dynamic Application Security Testing (DAST). Agen dirancang untuk memetakan halaman dan form, menentukan pengujian berdasarkan respons HTTP, lalu menyusun laporan temuan beserta saran perbaikan. MVP akan diuji pada DVWA atau OWASP Juice Shop lokal. Proyek ini masih berupa rancangan.',
            'general assistant agent' => 'Asisten AI yang dirancang untuk membantu tugas sehari-hari, memahami permintaan pengguna, dan memilih alat yang sesuai untuk menyelesaikannya.',
            default => 'Tema platform AI: '.$tema.'. Rincian rancangan untuk tema ini belum ditambahkan.',
        };

        return $this->page(strtolower($tema) === 'dast' ? 'Agentic AI / DAST' : $tema, $description);
    }

    public function gpaForm()
    {
        return $this->page('Dua semester. Satu refleksi.', 'Hitung rata-rata IP dua semester dengan bobot yang sama. IPK resmi mengikuti bobot SKS.', ['showGpa' => true]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate(['ip1' => 'required|numeric|between:0,4', 'ip2' => 'required|numeric|between:0,4']);

        return redirect()->route('gpa.calculate', $data);
    }

    public function gpa(string $ip1, string $ip2)
    {
        foreach ([$ip1, $ip2] as $ip) {
            if (! preg_match('/^[0-9]+(?:\.[0-9]+)?$/D', $ip) || ! is_finite((float) $ip) || (float) $ip > 4) {
                return response()->view('academic', ['profile' => config('portfolio'), 'title' => 'IP belum valid.', 'description' => 'Masukkan IP antara 0 dan 4. Gunakan titik untuk angka desimal.', 'showGpa' => true], 422);
            }
        }
        $result = number_format(((float) $ip1 + (float) $ip2) / 2, 2, '.', '');

        return $this->page('Rata-rata IP: '.$result, "Semester pertama: {$ip1}. Semester kedua: {$ip2}. Hasil ini memakai bobot semester yang sama; IPK resmi mengikuti bobot SKS.", ['showGpa' => true]);
    }

    public function missing()
    {
        abort(404);
    }
}
