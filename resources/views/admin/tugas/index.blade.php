@extends('adminlte::page')

@section('title', 'Data Tugas')

@section('content_header')
    <h1>Data Tugas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.tugas.index') }}" class="row g-2">
                <div class="col-md-7">
                    <label for="search" class="visually-hidden">Cari judul tugas</label>
                    <input type="search" id="search" name="search" class="form-control" placeholder="Cari judul tugas" value="{{ request('search') }}">
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
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Judul</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Tenggat</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tugas as $item)
                        <tr>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->departemen->nama }}</td>
                            <td>{{ $item->tenggat->format('d M Y H:i') }}</td>
                            <td>
                                <span class="badge {{ $item->tenggat->isPast() ? 'text-bg-secondary' : 'text-bg-success' }}">{{ $item->tenggat->isPast() ? 'Selesai' : 'Aktif' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Tidak ada data yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $tugas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
