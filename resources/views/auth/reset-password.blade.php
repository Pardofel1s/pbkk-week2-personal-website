@extends('adminlte::auth.passwords.reset', ['token' => $request->route('token')])

@section('password_reset_url', route('password.store'))
