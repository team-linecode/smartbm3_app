@extends('layouts.manage', ['title' => 'Biaya Sekolah'])

@section('content')

<!-- @include('component.form-error') -->

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div class="text-center">
                <a href="{{ route('app.finance.cost.show', $schoolyear->slug) }}" class="btn btn-light me-2"><i class="ri-arrow-left-s-line"></i></a>
            </div>
            <div>
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ $cost_category->name }}</button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        @foreach($cost_categories as $c_category)
                        <li><a class="dropdown-item {{ $cost_category->id == $c_category->id ? 'disabled' : '' }}" href="{{ route('app.finance.cost.create', [$schoolyear->slug, $c_category->id]) }}">{{ $c_category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('app.finance.cost.store', [$schoolyear->slug, $cost_category->id]) }}" method="post">
            @csrf

            <div class="row mb-3">
                <div class="col-lg-3">
                    <label for="name" class="form-label">Nama Biaya</label>
                </div>
                <div class="col-lg-9">
                    @if($cost_category->slug == 'ujian')
                    <select class="form-select @error('name') is-invalid @enderror" id="name" name="name">
                        <option value="" hidden>- Pilih Tipe Ujian -</option>
                        <option value="UTS" {{ select_old('UTS', old('name'), true, request('type')) }}>UTS</option>
                        <option value="UAS" {{ select_old('UAS', old('name'), true, request('type')) }}>UAS</option>
                        <option value="US" {{ select_old('US', old('name'), true, request('type')) }}>US</option>
                    </select>
                    @else
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama biaya">
                    @endif
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
                    <div>{{ $cost_category->name }}</div>
                </div>
            </div>
            <div class="row mb-3" id="setCost">
                <div class="col-lg-3">
                    <label class="form-label">Atur Biaya</label>
                </div>
                <div class="col-lg-9">
                    <!-- SPP -->
                    @if($cost_category->slug == 'spp')
                    <div id="setSPP">
                        @foreach($classrooms as $i => $classroom)
                        <div class="row gx-2 gx-md-4 mb-3">
                            <div class="col-lg-2">
                                <label for="amount{{ $i }}" class="form-label">Kelas {{ $classroom->alias }}</label>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control currency @error('amounts.' . $classroom->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $classroom->id }}]" value="{{ old('amounts.' . $classroom->id) }}" placeholder="Masukkan jumlah biaya">
                                <span class="input-group-text bg-white">x 12 Bln</span>
                            </div>
                            @error('amounts.' . $classroom->id)<div class="small text-danger mt-1">{{ $message }}</div>@enderror
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- UJIAN -->
                    @if($cost_category->slug == 'ujian')
                    <div id="setUjian">
                        <div class="row">
                            @if(request('type') == 'UTS' || !request('type'))
                            @foreach($semesters as $i => $semester)
                            <div class="col-lg-6" id="inputSemester{{ ($i+1) }}">
                                <label class="form-label">Semester {{ $semester->number }} ({{ $semester->type }})</label>
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <label for="amount{{ $i }}" class="form-label mt-2">Rp. </label>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control currency @error('amounts.' . $semester->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $semester->id }}]" value="{{ old('amounts.' . $semester->id) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts.' . $semester->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @elseif(request('type') == 'UAS')
                            @foreach($semesters->where('number', '!=', 6) as $i => $semester)
                            <div class="col-lg-6" id="inputSemester{{ ($i+1) }}">
                                <label class="form-label">Semester {{ $semester->number }} ({{ $semester->type }})</label>
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <label for="amount{{ $i }}" class="form-label mt-2">Rp. </label>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control currency @error('amounts.' . $semester->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $semester->id }}]" value="{{ old('amounts.' . $semester->id) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts.' . $semester->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            @foreach($semesters->where('number', 6) as $i => $semester)
                            <div class="col-lg-6" id="inputSemester{{ ($i+1) }}">
                                <label class="form-label">Semester {{ $semester->number }} ({{ $semester->type }})</label>
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <label for="amount{{ $i }}" class="form-label mt-2">Rp. </label>
                                    </div>
                                    <div class="col-11">
                                        <input type="text" class="form-control currency @error('amounts.' . $semester->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $semester->id }}]" value="{{ old('amounts.' . $semester->id) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts.' . $semester->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- DAFTAR ULANG -->
                    @if($cost_category->slug == 'daftar-ulang')
                    <div id="setDaftarUlang">
                        @foreach($classrooms->whereIn('name', ['XI', 'XII']) as $i => $classroom)
                        <div class="mb-3">
                            <label class="form-label">Kelas&nbsp;{{ $classroom->alias }}</label>
                            <input type="text" class="form-control currency @error('amounts.' . $classroom->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $classroom->id }}]" value="{{ old('amounts.' . $classroom->id) }}" placeholder="Masukkan jumlah biaya">
                            @error('amounts.' . $classroom->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- GEDUNG -->
                    @if($cost_category->slug == 'gedung')
                    <div id="setGedung">
                        <div class="row gx-2 gx-md-4">
                            @foreach($groups as $i => $group)
                            <div class="col-6">
                                <div class="row mb-3">
                                    <div class="col-lg-2">
                                        <label for="amount{{ $i }}" class="form-label mt-2">Gel. {{ $group->number }}</label>
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control currency @error('amounts.' . $group->id) is-invalid @enderror" id="amount{{ $i }}" name="amounts[{{ $group->id }}]" value="{{ old('amounts.' . $group->id) }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts.' . $group->id)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- LAIN-LAIN -->
                    @if($cost_category->slug == 'lain-lain')
                    <div id="setLainLain">
                        <div class="row gx-2 gx-md-4">
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control currency @error('amounts') is-invalid @enderror" id="amount" name="amounts[]" value="{{ old('amounts') }}" placeholder="Masukkan jumlah biaya">
                                        @error('amounts')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@stop

@push('include-script')
@include('component.jquery')

<script>
    $('select[name="name"]').change(function() {
        let val = $(this).val()
        window.location.href = '?type=' + val
    })
</script>
@endpush