@extends('layouts.app')

@section('title', 'Login')

@section('content')
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Registrasi Berhasil',
    text: "{{ session('success') }}",
    confirmButtonColor: '#198754'
});
</script>
@endif
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h3 mb-3 fw-bold">Selamat Datang</h1>
                <p class="text-muted mb-4">Silakan masuk untuk melanjutkan ke aplikasi manajemen perawatan bus.</p>

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
