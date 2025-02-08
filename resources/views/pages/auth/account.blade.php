@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('account', Auth::user()->id) }}">{{ $title }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Auth::user()->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample mt-4" action="{{ route('account.update', $data->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="name-input" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        @if ($data->role == '2')
                                            <input type="text" name="name" value="{{ $data->name }}"
                                                class="form-control" id="name-input" required autocomplete="off" readonly>
                                        @else
                                            <input type="text" name="name" value="{{ $data->name }}"
                                                class="form-control" id="name-input" required autofocus autocomplete="off">
                                        @endif
                                        @if ($errors->has('name'))
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="username-input" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="username"
                                            @if ($errors->has('username')) value="{{ old('username') }}"
                                            @else 
                                            value="{{ $data->username }}" @endif
                                            class="form-control" id="username-input" required autocomplete="off">
                                        @if ($errors->has('username'))
                                            <small class="text-danger">{{ $errors->first('username') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email-input" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" value="{{ $data->email }}"
                                            class="form-control" id="email-input" required autocomplete="off">
                                        @if ($errors->has('email'))
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="old-password-input" class="col-sm-2 col-form-label">Password Lama</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="old_password" class="form-control"
                                            id="old-password-input">
                                        @if ($errors->has('old_password'))
                                            <small class="text-danger">{{ $errors->first('old_password') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-input" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password-input">
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
                                            id="confirm-password">
                                        @if ($errors->has('password'))
                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('dashboard') }}">
                                        <button type="button" class="btn btn-secondary">Dashboard</button>
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
