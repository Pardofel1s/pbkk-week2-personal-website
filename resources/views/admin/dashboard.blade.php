@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    @role('admin')
        <div class="alert alert-info">Masuk sebagai <strong>Admin</strong>: akses penuh, termasuk hapus data.</div>
    @else
        <div class="alert alert-secondary">Masuk sebagai <strong>Staf</strong>: dapat melihat, menambah, dan mengedit data.</div>
    @endrole

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <x-adminlte-small-box title="{{ $totalMahasiswa }}" text="Total Mahasiswa Aktif" icon="bi bi-mortarboard" theme="primary" />
        </div>
        <div class="col-lg-4 col-md-6">
            <x-adminlte-small-box title="{{ $totalDosen }}" text="Total Staf Dosen" icon="bi bi-person-badge" theme="success" />
        </div>
        <div class="col-lg-4 col-md-6">
            <x-adminlte-small-box title="{{ $totalTugasAktif }}" text="Total Tugas Aktif" icon="bi bi-journal-text" theme="warning" />
        </div>
    </div>
@endsection
