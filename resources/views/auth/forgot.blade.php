@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Lupa Kata Sandi?</h5>
                    <p class="text-muted">Atur ulang kata sandi kamu disini</p>

                    <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl">
                    </lord-icon>

                </div>

                <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                    Masukkan email dan kami akan mengirimkan link untuk mengubah kata sandi
                </div>
                <div class="p-2">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan Email">
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
            <p class="mb-0">Ahaa! Saya ingat kata sandinya... <a href="{{ route('auth.login') }}" class="fw-semibold text-primary text-decoration-underline"> Klik Disini </a> </p>
        </div>

    </div>
</div>
<!-- end row -->
@stop
