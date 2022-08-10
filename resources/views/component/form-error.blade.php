@if ($errors->any())
<div class="alert alert-warning alert-dismissible alert-additional fade show" role="alert">
    <div class="alert-body">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <i class="ri-alert-line fs-16 align-middle"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading">Upss, Ada Kesalahan!</h5>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="alert-content">
        <p class="mb-0">Perhatikan kembali form yang diinput.</p>
    </div>
</div>
@endif