<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:lihat-mahasiswa', only: ['index']),
            new Middleware('permission:kelola-mahasiswa', only: ['create', 'store', 'edit', 'update']),
            new Middleware('permission:hapus-mahasiswa', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $filter = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'departemen_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:0,1'],
        ]);

        $mahasiswas = Mahasiswa::query()
            ->with('departemen')
            ->when($filter['search'] ?? null, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nrp', 'like', "%$search%");
                });
            })
            ->when($filter['departemen_id'] ?? null, function ($query, $departemenId) {
                return $query->where('departemen_id', $departemenId);
            })
            // '0' is falsy, so when() must test presence rather than the value.
            ->when(isset($filter['status']), function ($query) use ($filter) {
                return $query->where('is_active', $filter['status']);
            })
            ->orderBy('nrp')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', [
            'mahasiswas' => $mahasiswas,
            'departemens' => Departemen::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.mahasiswa.create', [
            'mahasiswa' => new Mahasiswa(['is_active' => true]),
            'departemens' => Departemen::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Mahasiswa::create($this->validated($request));

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('admin.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'departemens' => Departemen::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($this->validated($request, $mahasiswa));

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        return redirect()->back()->with('success', 'Mahasiswa berhasil dihapus.');
    }

    private function validated(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        $data = $request->validate([
            'nrp' => ['required', 'digits:10', Rule::unique('mahasiswas')->ignore($mahasiswa)],
            'nama' => ['required', 'string', 'max:255'],
            'departemen_id' => ['required', 'exists:departemens,id'],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
        ]);

        return $data + ['is_active' => $request->boolean('is_active')];
    }
}
