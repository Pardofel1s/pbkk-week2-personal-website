@extends('adminlte::page')

@section('title', 'Tambah Mahasiswa')

@section('content_header')
    <h1>Tambah Mahasiswa</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
                @include('admin.mahasiswa.form')
            </form>
        </div>
    </div>
@endsection
