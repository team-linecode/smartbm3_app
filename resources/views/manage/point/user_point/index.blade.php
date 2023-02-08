@extends('layouts.manage', ['title' => 'Data Poin'])

@push('include-style')
    @include('component.datatables-style')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <form>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="penalty_point" class="form-label">Pelanggaran</label>
                        <select class="form-select @error('penalty_point') is-invalid @enderror" name="penalty_point" id="penalty_point">
                            <option value="">Semua Pelanggaran</option>
                            @forelse ($penalty_categories as $penalty_category)
                            <optgroup label="{{ $penalty_category->code }}. {{ $penalty_category->name }}">
                                @foreach ($penalty_points as $penalty_point)
                                    @if ($penalty_category->id == $penalty_point->penalty_category_id)
                                    <option value="{{ $penalty_point->id }}" {{ select_old($penalty_point->id, request()->get('penalty_point')) }}>{{ $penalty_point->code }} {{ $penalty_point->name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            @empty
                                <option value="create_penalty_point">+ Tambah Poin Pelanggaran</option>
                            @endforelse
                        </select>
                        @error('penalty_point')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                        <label for="from_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="from_date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" value="{{ request()->get('from_date') ?? date('Y-m-d') }}">
                        @error('from_date')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="to_date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" value="{{ request()->get('to_date') ?? date('Y-m-d') }}">
                        @error('to_date')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date" class="d-block form-label">&nbsp;</label>
                        <button class="btn btn-primary w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-header">
            <div class="d-flex flex-column flex-sm-row flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h4 class="card-title text-center text-lg-start text-uppercase mb-2 mb-md-0 mb-lg-0">Data Poin
                    </h4>
                    <p class="mb-lg-0">Poin akan bertambah ketika siswa/i melakukan pelanggaran.</p>
                </div>
                <div class="text-center">
                    <a href="{{ route('app.user_point.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle w-100 mb-0 datatables">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Point</th>
                            <th scope="col">Tanggal&nbsp;&&nbsp;Waktu</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user_points as $user_point)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user_point->user->name }}</td>
                                <td>{!! $user_point->user->myClass() !!}</td>
                                <td>
                                    @if ($user_point->description != null)
                                        {{ $user_point->description }}
                                    @else
                                        <div class="d-flex">
                                            <div class="fw-medium me-2">
                                                {{ $user_point->penalty->code }}
                                            </div>
                                            <div>
                                                {{ $user_point->penalty->name }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user_point->type == 'plus')
                                        <i
                                            class="h5 align-middle ri-arrow-up-line text-danger"></i>&nbsp;Penambahan&nbsp;Poin
                                    @elseif ($user_point->type == 'minus')
                                        <i
                                            class="h5 align-middle ri-arrow-down-line text-success"></i>&nbsp;Pengurangan&nbsp;Poin
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $user_point->type == 'plus' ? '+' : '-' }}{{ $user_point->point ?? $user_point->penalty->point }}
                                </td>
                                <td>{!! str_replace(' ', '&nbsp;', date('d-m-Y / H:i', $user_point->date())) !!}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="edit">
                                            <a href="{{ route('app.user_point.edit', $user_point->id) }}"
                                                class="btn btn-sm btn-success">Edit</a>
                                        </div>
                                        <div class="remove">
                                            <form action="{{ route('app.user_point.destroy', $user_point->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-danger c-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div>
@stop

@push('include-script')
    @include('component.datatables-script')
    <script>
         $('#penalty_point').change(function(){
            if ($(this).val() == 'create_penalty_point') {
                window.location.href = "{{ route('app.penalty_point.create') }}"
            }
        })
        
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endpush
