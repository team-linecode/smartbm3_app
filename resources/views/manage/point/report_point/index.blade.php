@extends('layouts.manage', ['title' => 'Laporan Poin'])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <label for="from_date">Dari Tanggal</label>
                        <input type="date" class="form-control" name="from_date" id="from_date">
                    </div>
                    <div class="col-lg-3">
                        <label for="to_date">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="to_date" id="to_date">
                    </div>
                    <div class="col-lg-3">
                        <label for="type">Tipe Poin</label>
                        <select class="form-select" name="type" id="type">
                            <option value="" hidden>Pilih Tipe</option>
                            <option value="all">Semua</option>
                            <option value="plus">Plus</option>
                            <option value="minus">Minus</option>
                        </select>
                    </div>
                    <div class="col-lg-3 align-self-end">
                        <button class="btn btn-success w-100"><i class="ri-file-excel-2-line align-middle"></i> Export Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
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
                            <th scope="col">Tanggal & Waktu</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div>
@stop
