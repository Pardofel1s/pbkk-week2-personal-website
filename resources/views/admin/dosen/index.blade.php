@extends('adminlte::page')

@section('title', 'Data Dosen')

@section('content_header')
    <h1>Data Dosen</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.dosen.index') }}" class="row g-2">
                <div class="col-md-10">
                    <label for="search" class="visually-hidden">Cari nama atau NIP</label>
                    <input type="search" id="search" name="search" class="form-control" placeholder="Cari nama atau NIP" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Departemen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                        <tr>
                            <td>{{ $dosen->nip }}</td>
                            <td>{{ $dosen->nama }}</td>
                            <td>{{ $dosen->departemen->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">Tidak ada data yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $dosens->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
