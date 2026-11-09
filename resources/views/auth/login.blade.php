@extends('adminlte::auth.login')

@section('auth_body')
    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    @parent
@endsection

@section('auth_footer')
    @parent

    {{-- Demo accounts exist only through the seeder; never render their password outside local. --}}
    @env('local')
        <hr>
        <p class="text-center small mb-2">Login instan akun demo</p>
        <div class="d-grid gap-2">
            @foreach (['admin@portal.test' => 'Admin', 'staf@portal.test' => 'Staf', 'user@portal.test' => 'Pengguna Biasa'] as $email => $label)
                <button type="button" class="btn btn-outline-secondary btn-sm" data-demo-login="{{ $email }}">Masuk sebagai {{ $label }}</button>
            @endforeach
        </div>
    @endenv
@endsection

@section('js')
    @env('local')
        <script>
            document.querySelectorAll('[data-demo-login]').forEach((button) => {
                button.addEventListener('click', () => {
                    const form = document.getElementById('email').form;
                    form.email.value = button.dataset.demoLogin;
                    form.password.value = 'password';
                    form.submit();
                });
            });
        </script>
    @endenv
@endsection
