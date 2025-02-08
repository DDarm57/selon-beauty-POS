@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('users') }}">Data User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample mt-4" action="{{ route('users.store') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="name-input" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" id="name-input" required autofocus autocomplete="off">
                                        @if ($errors->has('name'))
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username-input" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username" value="{{ old('username') }}"
                                            class="form-control" id="username-input" required autocomplete="off">
                                        @if ($errors->has('username'))
                                            <small class="text-danger">{{ $errors->first('username') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control" id="email-input" required autocomplete="off">
                                        @if ($errors->has('email'))
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-input" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password-input"
                                            required>
                                        @if ($errors->has('password'))
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="confirm-password" class="col-sm-2 col-form-label">Konfirmasi
                                        Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="confirm-password" required>
                                        @if ($errors->has('password'))
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10 mt-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                id="status-toggle" checked="true" value="active">
                                            <label class="form-check-label" for="status-toggle">Aktif/Non-aktif</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('users') }}">
                                        <button type="button" class="btn btn-secondary">Kembali</button>
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main-panel ends -->
@endsection
