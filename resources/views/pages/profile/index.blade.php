@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-5 d-flex flex-wrap">
                                <div class="col-md-3">
                                    <div class="mt-4">
                                        @if ($data->image)
                                            <img class="w-100 img-fluid" src="{{ asset('img/profile/' . $data->image) }}"
                                                alt="{{ $data->name }}">
                                        @else
                                            <img class="w-100 img-fluid" src="{{ asset('img/profile/default.png') }}"
                                                alt="{{ $data->name }}">
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <form class="forms-sample mt-4" enctype="multipart/form-data"
                                        action="{{ route('profile.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="name-input" class="col-sm-2 col-form-label">Toko</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name"
                                                    @if (old('name')) value="{{ old('name') }}"
                                                @else
                                                    value="{{ $data->name }}" @endif
                                                    class="form-control" id="name-input" required autofocus
                                                    autocomplete="off">
                                                @if ($errors->has('name'))
                                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email-input" class="col-sm-2 col-form-label">Email</label>
                                            <div class="d-flex justify-content-between col-sm-10">
                                                <input type="email" name="email"
                                                    @if (old('email')) value="{{ old('email') }}"
                                                @else
                                                    value="{{ $data->email }}" @endif
                                                    class="form-control" id="email-input" required autocomplete="off">
                                                @if ($errors->has('email'))
                                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="phone-input" class="col-sm-2 col-form-label">No. Telp</label>
                                            <div class="col-sm-10">
                                                <input type="text" maxlength="13" name="phone"
                                                    @if (old('phone')) value="{{ old('phone') }}"
                                                @else
                                                    value="{{ $data->phone }}" @endif
                                                    class="form-control" id="phone-input" required autocomplete="off">
                                                @if ($errors->has('phone'))
                                                    <small class="text-danger">{{ $errors->first('phone') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="address-input" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="d-flex justify-content-between col-sm-10">
                                                <input type="text" name="address"
                                                    @if (old('address')) value="{{ old('address') }}"
                                                @else
                                                    value="{{ $data->address }}" @endif
                                                    class="form-control" id="address-input" required autocomplete="off">
                                                @if ($errors->has('address'))
                                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="tiktok-input" class="col-sm-2 col-form-label">Tiktok</label>
                                            <div class="d-flex justify-content-between col-sm-10">
                                                <input type="text" name="tiktok"
                                                    @if (old('tiktok')) value="{{ old('tiktok') }}"
                                                @else
                                                    value="{{ $data->tiktok }}" @endif
                                                    class="form-control" id="tiktok-input" required autocomplete="off">
                                                @if ($errors->has('tiktok'))
                                                    <small class="text-danger">{{ $errors->first('tiktok') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="instagram-input" class="col-sm-2 col-form-label">Instagram</label>
                                            <div class="d-flex justify-content-between col-sm-10">
                                                <input type="text" name="instagram"
                                                    @if (old('instagram')) value="{{ old('instagram') }}"
                                                @else
                                                    value="{{ $data->instagram }}" @endif
                                                    class="form-control" id="instagram-input" required autocomplete="off">
                                                @if ($errors->has('instagram'))
                                                    <small class="text-danger">{{ $errors->first('instagram') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="image-input" class="col-sm-2 col-form-label">File Upload</label>
                                            <div class="col-sm-10">
                                                <input name="image" class="form-control" type="file" id="image-input">
                                            </div>
                                            @if ($errors->has('image'))
                                                <small class="text-danger">{{ $errors->first('image') }}</small>
                                            @endif
                                        </div>

                                        <div class="text-end mt-4 d-flex justify-content-end gap-2">

                                            <button type="submit" class="btn btn-lg btn-primary"><i
                                                    class="bi bi-arrow-repeat"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-panel ends -->
@endsection
