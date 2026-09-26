<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $visitorName = trim((string) request('user', ''));

        return $this->page('home', compact('visitorName'));
    }

    public function about(): View
    {
        return $this->page('about');
    }

    public function profile(): View
    {
        return view('academic', array_merge($this->shared(), [
            'title' => config('portfolio.name'),
            'description' => config('portfolio.bio'),
            'showProfile' => true,
        ]));
    }

    public function agent(?string $tema = null): View
    {
        $tema = $tema ?: 'General Assistant Agent';
        $description = match (strtolower($tema)) {
            'dast' => 'Rancangan Agentic AI untuk Dynamic Application Security Testing. Agen memetakan endpoint, memilih pengujian berdasarkan respons HTTP, lalu menyusun laporan temuan dan saran perbaikan. MVP diuji secara legal pada aplikasi lokal seperti DVWA atau OWASP Juice Shop.',
            'general assistant agent' => 'Asisten AI yang membantu pengguna memahami permintaan, memilih alat yang sesuai, dan menyusun langkah penyelesaian secara terarah.',
            default => 'Tema platform AI: '.$tema.'. Rincian rancangan untuk tema ini belum ditambahkan.',
        };

        return view('academic', array_merge($this->shared(), [
            'title' => strtolower($tema) === 'dast' ? 'Agentic AI / DAST' : $tema,
            'description' => $description,
        ]));
    }

    public function project(): RedirectResponse
    {
        return redirect()->route('agent', ['tema' => 'dast']);
    }

    public function projects(): View
    {
        return $this->page('projects');
    }

    public function contact(): View
    {
        return $this->page('contact');
    }

    public function collection(): View
    {
        return $this->page('collection');
    }

    public function blog(): View
    {
        return $this->page('blog');
    }

    public function article(string $slug): View
    {
        $article = config('portfolio.articles')[$slug] ?? null;
        abort_unless($article, 404);

        return $this->page('article', compact('article'));
    }

    public function calculator(): View
    {
        return $this->page('calculator', ['angka1' => '', 'angka2' => '', 'operasi' => 'tambah', 'result' => null, 'calculationError' => null]);
    }

    public function calculateForm(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'angka1' => ['required', 'string', 'max:32'],
            'angka2' => ['required', 'string', 'max:32'],
            'operasi' => ['required', 'in:tambah,kurang,kali,bagi'],
        ]);

        return redirect()->route('calculate', $input);
    }

    public function hitung(string $angka1, string $angka2, string $operasi): Response
    {
        $result = null;
        $calculationError = null;
        $numberPattern = '/^-?(?:\d+(?:\.\d*)?|\.\d+)$/D';

        if (! in_array($operasi, ['tambah', 'kurang', 'kali', 'bagi'], true)) {
            $calculationError = 'Pilih operasi tambah, kurang, kali, atau bagi.';
        } elseif (strlen($angka1) > 32 || strlen($angka2) > 32 || ! preg_match($numberPattern, $angka1) || ! preg_match($numberPattern, $angka2)) {
            $calculationError = 'Masukkan dua angka yang valid. Gunakan titik untuk desimal, misalnya 2.5.';
        } elseif (abs((float) $angka1) > 1e12 || abs((float) $angka2) > 1e12) {
            $calculationError = 'Gunakan angka antara -1 triliun dan 1 triliun.';
        } elseif ($operasi === 'bagi' && (float) $angka2 === 0.0) {
            $calculationError = 'Angka tidak dapat dibagi dengan nol. Coba ubah angka kedua.';
        } else {
            $value = match ($operasi) {
                'tambah' => (float) $angka1 + (float) $angka2,
                'kurang' => (float) $angka1 - (float) $angka2,
                'kali' => (float) $angka1 * (float) $angka2,
                'bagi' => (float) $angka1 / (float) $angka2,
            };
            $result = sprintf('%.12g', $value == 0 ? 0 : $value);
        }

        return response()->view('calculator', array_merge($this->shared(), compact('angka1', 'angka2', 'operasi', 'result', 'calculationError')), $calculationError ? 422 : 200);
    }

    private function page(string $view, array $data = []): View
    {
        return view($view, array_merge($this->shared(), $data));
    }

    private function shared(): array
    {
        return ['profile' => config('portfolio')];
    }
}
