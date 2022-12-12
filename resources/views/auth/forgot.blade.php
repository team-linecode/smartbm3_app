@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Lupa Kata Sandi?</h5>
                        <p class="text-muted">Atur ulang kata sandi kamu disini</p>

                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c"
                            class="avatar-xl"></lord-icon>

                    </div>

                    @include('component.default-alert')

                    <div class="p-2">
                        <form action="{{ route('auth.forgot.post') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-primary w-100" type="submit">Atur Ulang Kata Sandi</button>
                            </div>
                        </form><!-- end form -->
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Ahaa! Saya ingat kata sandinya... <a href="{{ route('auth.login') }}"
                        class="fw-semibold text-primary text-decoration-underline"> Klik Disini </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
@stop
