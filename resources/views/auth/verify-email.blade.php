@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('auth_header', __('adminlte::adminlte.verify_message'))

@section('auth_body')
    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success" role="alert">{{ __('adminlte::adminlte.verify_email_sent') }}</div>
    @endif

    <p>{{ __('adminlte::adminlte.verify_check_your_email') }}</p>

    <form method="POST" action="{{ route('verification.send') }}" class="mb-2">
        @csrf
        <button type="submit" class="btn btn-primary w-100">{{ __('adminlte::adminlte.verify_request_another') }}</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link w-100">{{ __('adminlte::adminlte.log_out') }}</button>
    </form>
@endsection
