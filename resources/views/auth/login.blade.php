@extends('adminlte::auth.login')

@section('auth_body')
    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    @parent
@endsection
