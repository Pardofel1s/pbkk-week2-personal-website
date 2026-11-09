<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TugasController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'departemen_id' => ['nullable', 'integer'],
        ]);

        $tugas = Tugas::query()
            ->with('departemen')
            ->when($filter['search'] ?? null, function ($query, $search) {
                return $query->where('judul', 'like', "%$search%");
            })
            ->when($filter['departemen_id'] ?? null, function ($query, $departemenId) {
                return $query->where('departemen_id', $departemenId);
            })
            ->orderByDesc('tenggat')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tugas.index', [
            'tugas' => $tugas,
            'departemens' => Departemen::orderBy('nama')->get(),
        ]);
    }
}
