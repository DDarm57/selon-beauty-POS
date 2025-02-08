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
                            <form class="forms-sample mt-4" action="{{ route('users.update', $data->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="name-input" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ $data->name }}"
                                            class="form-control" id="name-input" required autofocus autocomplete="off">
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
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="d-flex justify-content-between align-items-center col-sm-10 mt-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                id="status-toggle" value="{{ $data->status }}"
                                                @if ($data->status == 'active') checked="true" @endif>
                                            <label class="form-check-label" for="status-toggle">Aktif/Non-aktif</label>
                                        </div>

                                        <button id="reset-password" type="button" class="btn btn-danger btn-sm">Reset
                                            Password</button>
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

@section('scripts')
    <script>
        $('#reset-password').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Reset Password ?",
                text: "Akun: {{ $data->name }} akan direset passwordnya",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, reset password!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ensure you redirect to the correct route for resetting the password
                    window.location = "{{ route('users.reset', $data->id) }}";
                }
            });
        });
    </script>
@endsection
