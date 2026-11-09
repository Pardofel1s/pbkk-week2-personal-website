@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

@section('content_header')
    <h1>Data Mahasiswa</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="row g-2">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Cari nama atau NRP</label>
                    <input type="search" id="search" name="search" class="form-control @error('search') is-invalid @enderror" placeholder="Cari nama atau NRP" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="departemen_id" class="visually-hidden">Departemen</label>
                    <select id="departemen_id" name="departemen_id" class="form-select">
                        <option value="">Semua departemen</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}" @selected(request('departemen_id') == $departemen->id)>{{ $departemen->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="visually-hidden">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua status</option>
                        <option value="1" @selected(request('status') === '1')>Aktif</option>
                        <option value="0" @selected(request('status') === '0')>Cuti</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">NRP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Angkatan</th>
                        <th scope="col">Status</th>
                        <th scope="col"><span class="visually-hidden">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $mahasiswa->nrp }}</td>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->departemen->nama }}</td>
                            <td>{{ $mahasiswa->angkatan }}</td>
                            <td>
                                <span class="badge {{ $mahasiswa->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $mahasiswa->is_active ? 'Aktif' : 'Cuti' }}</span>
                            </td>
                            <td class="text-end text-nowrap">
                                @can('kelola-mahasiswa')
                                    <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                @endcan
                                @can('hapus-mahasiswa')
                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" class="d-inline" onsubmit="return confirm('Hapus data mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada data yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            @can('kelola-mahasiswa')
                <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">Tambah Mahasiswa</a>
            @endcan
            {{ $mahasiswas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
