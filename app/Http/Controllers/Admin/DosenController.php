<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->validate(['search' => ['nullable', 'string', 'max:100']]);

        $dosens = Dosen::query()
            ->with('departemen')
            ->when($filter['search'] ?? null, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dosen.index', compact('dosens'));
    }
}
