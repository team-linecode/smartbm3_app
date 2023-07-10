@extends('layouts.manage', ['title' => 'Letter'])

@push('include-style')
@include('component.datatables-style')
<style>
    p {
        margin: 0 !important;
    }

    .title-smk {
        font-size: 5vh;
    }

    hr {
        height: 5px !important;
        background-color: black !important;
        opacity: 1 !important;
    }

    .letter-desc{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
    }
    
    .cambria{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
    }

    .letter-title{
        font-size: 3vh !important;
        color: black;
        font-weight: bold;
    }

    p{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        font-size: 20px;
    }
    
    h1,
    h2,
    h3,
    h4,
    h5,
    h6{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        color: black !important;
        font-weight: bold !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 p-5">
                        <div class="d-flex justify-content-between">
                            <div class="logo-jabar">
                                <img src="{{ Storage::url('logo/logo-jabar.png') }}" alt="" class="img-fluid" width="150px">
                            </div>
                            <div class="title-text text-center" style="font-size: 4vh; font-weight: bold; font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
                                <h3>PEMERINTAH PROVINSI JAWA BARAT</h3>
                                <h3>DINAS PENDIDIKAN</h3>
                                <h3>YAYASAN BINA PERTIWI MANDIRI</h3>
                                <h2 class="title-smk">SMK BINA MANDIRI MULTIMEDIA</h2>
                            </div>
                            <div class="logo-bm5">
                                <img src="{{ Storage::url('logo/bm3.png') }}" alt="" class="img-fluid" width="170px">
                            </div>
                        </div>
                        <small class="text-center d-block">Jalan Raya Cileungsi Jonggol Km.1 Desa Cileungsi Kidul Kecamatan Cileungsi Kabupaten Bogor Provinsi Jawa Barat.</small>
                        <small class="text-center d-block">Tlp. (021) 82491984 Fax. (021) 82482930. E-Mail: smkbinamandirimultimedia@gmail.com Website : smkbm3.sch.id NPSN:69984405</small>
                        <hr>
                        <div class="letter-desc">
                            <h5 class="text-center cambria letter-title text-uppercase"><u>{{ $letter_category->name }}</u></h5>
                            <div class="d-flex justify-content-center">
                                <h5 class="text-center cambria letter-title">Nomor : </h5>
                                <h4 class="text-center cambria text-dark">&nbsp;{{ $letter['letter_number'] }}</h4>
                            </div>

                            <p>Yang bertanda tangan dibawah ini :</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('include-script')
@include('component.datatables-script')
@endpush