@if(session('alert-success'))
<div class="alert alert-success alert-dismissible alert-solid alert-label-icon fade show" role="alert">
    <i class="ri-check-double-line label-icon"></i>{!! session('alert-success') !!}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('alert-error'))
<div class="alert alert-danger alert-dismissible alert-solid alert-label-icon fade show" role="alert">
    <i class="ri-error-warning-line label-icon"></i>{!! session('alert-error') !!}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('alert-warning'))
<div class="alert alert-warning alert-dismissible alert-solid alert-label-icon fade show" role="alert">
    <i class="ri-alert-line label-icon"></i>{!! session('alert-warning') !!}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
