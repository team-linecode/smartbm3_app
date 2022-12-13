@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Selamat Datang !</h5>
                    <p class="text-muted">Masuk untuk mengakses halaman.</p>
                </div>
                <div class="p-2 mt-4">
                    <form action="{{ route('auth.post_login') }}" method="post">
                        @csrf

                        @include('component.default-alert')

                        <div class="mb-3">
                            <label for="username" class="form-label">Email / Username</label>
                            <input type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" name="username" placeholder="emailkamu@gmail.com" value="{{ old('username') }}" tabindex="1">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="float-end">
                                <a href="{{ route('auth.forgot') }}" class="text-muted">Lupa kata sandi?</a>
                            </div>
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Masukkan kata sandi" tabindex="2">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="auth-remember-check" name="remember" tabindex="3" checked>
                            <label class="form-check-label" for="auth-remember-check">Ingat saya</label>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100" type="submit" tabindex="4">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="mt-4 text-center">
            <p class="mb-0">Saya tidak tahu akun saya! <a href="https://wa.me/6285156465410" target="_blank" class="fw-semibold text-primary text-decoration-underline"> Hubungi Admin </a> </p>
        </div>

    </div>
</div>
<!-- end row -->
@stop
