@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Atur Ulang Kata Sandi</h5>
                        <p class="text-muted">Gunakan password yang tidak mudah ditebak.</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form action="{{ route('auth.reset.post', $verify_token) }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="Masukkan password baru">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="repeat_password" class="form-label">Ulangi Kata Sandi</label>
                                <input type="password" class="form-control @error('repeat_password') is-invalid @enderror"
                                    name="repeat_password" id="repeat_password" placeholder="Ulangi Kata Sandi Baru">
                                @error('repeat_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit">Atur Ulang Kata Sandi</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Tidak jadi mengubah kata sandi? <a href="{{ route('auth.login') }}"
                        class="fw-semibold text-primary text-decoration-underline"> Masuk </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
@stop
