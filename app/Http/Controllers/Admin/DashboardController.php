<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Tugas;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalMahasiswa' => Mahasiswa::where('is_active', true)->count(),
            'totalDosen' => Dosen::count(),
            'totalTugasAktif' => Tugas::where('tenggat', '>=', now())->count(),
        ]);
    }
}
