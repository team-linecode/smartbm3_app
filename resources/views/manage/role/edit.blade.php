@extends('layouts.manage', ['title' => 'Role'])

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <a href="{{ route('app.role.index') }}" class="btn btn-primary">
                                <i class="ri ri-arrow-left-line"></i>
                            </a>
                        </div>
                        <div>
                            <h4 class="card-title text-center text-uppercase mb-2 mb-md-0 mb-lg-0">Edit Role</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('app.role.update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="row align-items-center mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Role</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') ?? $role->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row align-items-start mb-5">
                            <div class="col-sm-3">
                                <label for="permission" class="form-label">Permission</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="permission-column">
                                        @foreach ($permissions as $i => $permission)
                                            <div class="col-12">
                                                <div class="form-check mb-2" style="break-inside: avoid-column;">
                                                    <input class="form-check-input" name="permissions[]"
                                                        value="{{ $permission->name }}" type="checkbox"
                                                        id="checkbox{{ $i }}"
                                                        {{ cb_old($permission->name, old('permissions'), true, $role->permissions->pluck('name')->toArray()) }}>
                                                    <label class="form-check-label" for="checkbox{{ $i }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('permissions')
                                    <div class="small text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
