@extends('layouts.manage', ['title' => 'Data Peminjaman Lab'])

@section('content')
    <div class="mb-3">
        <label for="user" class="form-label">Penanggung Jawab</label>
        <select class="form-select select2 @error('user') is-invalid @enderror" name="user" id="user">
            <option value="" hidden>Pilih Nama</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ select_old($user->id, old('user')) }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('user')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
    </div>
@stop
