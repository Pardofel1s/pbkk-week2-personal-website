@extends('adminlte::page')

@section('title', 'Edit Mahasiswa')

@section('content_header')
    <h1>Edit Mahasiswa</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswa) }}">
                @method('PUT')
                @include('admin.mahasiswa.form')
            </form>
        </div>
    </div>
@endsection
