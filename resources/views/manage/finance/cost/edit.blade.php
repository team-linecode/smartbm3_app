@extends('layouts.manage', ['title' => 'Biaya Sekolah'])

@section('content')

@include('component.form-error')

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="text-center">
                <a href="{{ route('app.finance.cost.detail', [$schoolyear->slug, $cost->slug]) }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
                <h4 class="card-title text-center text-uppercase mb-0 d-inline">Edit Biaya</h4>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('app.finance.cost.update', [$schoolyear->slug, $cost->slug]) }}" method="post">
            @csrf
            @method('put')

            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="name" class="form-label">Nama Biaya</label>
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? $cost->name }}" placeholder="Masukkan nama biaya">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="schoolyear" class="form-label">Tahun Ajaran</label>
                </div>
                <div class="col-lg-9">
                    <div>{{ $schoolyear->name }}</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="costCategory" class="form-label">Kategori Biaya</label>
                </div>
                <div class="col-lg-9">
                    <div>{{ $cost->cost_category->name }}</div>
                </div>
            </div>
            <div class="row mb-3" id="setCost">
                <div class="col-lg-3">
                    <label class="form-label">Atur Biaya</label>
                </div>
                <div class="col-lg-9">
                    <!-- SPP -->
                    @if($cost->cost_category->slug == 'spp')
                    <div id="setSPP">
                        @foreach($cost->details as $i => $cost_detail)
                        <div class="row gx-2 gx-md-4 mb-3">
                            <div class="col-lg-2">
                                <label for="amount{{ $i }}" class="form-label">Kelas {{ $cost_detail->classroom->alias }}</label>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control currency @error('amounts.' . $cost_detail->classroom->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $cost_detail->classroom->id }}]" value="{{ old('amounts.' . $cost_detail->classroom->id) ?? number_format($cost_detail->amount) }}" placeholder="Masukkan jumlah biaya">
                                <span class="input-group-text bg-white">x 12 Bln</span>
                            </div>
                            @error('amounts.' . $cost_detail->classroom->id)<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- UJIAN -->
                    @if($cost->cost_category->slug == 'ujian')
                    <div id="setUjian">
                        <div class="row">
                            @foreach($cost->details as $i => $cost_detail)
                            <div class="col-lg-6">
                                <label class="form-label">Semester {{ $cost_detail->semester->number }} ({{ $cost_detail->semester->type }})</label>
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <label for="amount{{ $i }}" class="form-label mt-2">Rp. </label>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control currency @error('amounts.' . $cost_detail->semester->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $cost_detail->semester->id }}]" value="{{ old('amounts.' . $cost_detail->semester->id) ?? number_format($cost_detail->amount) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts.' . $cost_detail->semester->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- DAFTAR ULANG -->
                    @if($cost->cost_category->slug == 'daftar-ulang')
                    <div id="setDaftarUlang">
                        @foreach($cost->details as $i => $cost_detail)
                        <div class="mb-3">
                            <label class="form-label">Kelas&nbsp;{{ $cost_detail->classroom->alias }}</label>
                            <input type="text" class="form-control currency @error('amounts.' . $cost_detail->classroom->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $cost_detail->classroom->id }}]" value="{{ old('amounts.' . $cost_detail->classroom->id) ?? number_format($cost_detail->amount) }}" placeholder="Masukkan jumlah biaya">
                            @error('amounts.' . $cost_detail->classroom->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- GEDUNG -->
                    @if($cost->cost_category->slug == 'gedung')
                    <div id="setGedung">
                        <div class="row">
                            @foreach($cost->details as $i => $cost_detail)
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Gelombang&nbsp;{{ $cost_detail->group->alias }}</label>
                                    <input type="text" class="form-control currency @error('amounts.' . $cost_detail->group->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $cost_detail->group->id }}]" value="{{ old('amounts.' . $cost_detail->group->id) ?? number_format($cost_detail->amount) }}" placeholder="Masukkan jumlah biaya">
                                    @error('amounts.' . $cost_detail->group->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- LAIN-LAIN -->
                    @if($cost->cost_category->slug == 'lain-lain')
                    <div id="setLainLain">
                        <div class="row gx-2 gx-md-4">
                            @foreach($cost->details as $i => $cost_detail)
                            <div class="col-6">
                                <div class="row mb-3">
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control currency @error('amounts') is-invalid @enderror" id="amount" name="amounts" value="{{ old('amounts') ?? number_format($cost_detail->amount) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@stop

@push('include-script')
@include('component.jquery')

<script>
    $('#costCategory').change(function() {
        // Show Description
        const id = $(this).val();
        const desc = $(this).children('#desc' + id).val()
        $('#note').html('Note: ' + desc)
        // Show Input
        let slug = $(this).children('#slug' + id).val()
        $('#setCost').removeClass('d-none')
        if (slug == 'spp') {
            // Show
            $('#setSPP').removeClass('d-none')
            // Hide
            $('#setUjian').addClass('d-none')
            $('#setDaftarUlang').addClass('d-none')
            $('#setLainLain').addClass('d-none')
        } else if (slug == 'ujian') {
            // Show
            $('#setUjian').removeClass('d-none')
            // Hide
            $('#setSPP').addClass('d-none')
            $('#setDaftarUlang').addClass('d-none')
            $('#setLainLain').addClass('d-none')
        } else if (slug == 'daftar-ulang') {
            // Show
            $('#setDaftarUlang').removeClass('d-none')
            // Hide
            $('#setSPP').addClass('d-none')
            $('#setUjian').addClass('d-none')
            $('#setLainLain').addClass('d-none')
        } else {
            // Show
            $('#setLainLain').removeClass('d-none')
            // Hide
            $('#setSPP').addClass('d-none')
            $('#setUjian').addClass('d-none')
            $('#setDaftarUlang').addClass('d-none')
        }
    })
</script>
@endpush
