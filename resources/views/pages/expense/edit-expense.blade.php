@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('expenses') }}">Pengeluaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample mt-4" action="{{ route('expenses.update', $data->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <label for="name-input" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ $data->name ?? old('name') }}"
                                            class="form-control" id="name-input" required autofocus autocomplete="off">
                                        @if ($errors->has('name'))
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea id="description" name="description" class="form-control" style="height: 100px" autocomplete="off">{{ $data->description ?? old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="amount-input" class="col-sm-3 col-form-label">Harga</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-text" id="rp">Rp.</span>
                                            <input type="text" id="amount-input" class="form-control" name="amount"
                                                aria-label="rp" aria-describedby="rp"
                                                value="{{ number_format($data->amount, '0', ',', '.') ?? number_format(old('amount'), '0', ',', '.') }}"
                                                class="form-control" id="amount-input" required autocomplete="off"
                                                oninput="formatCurrency(this)">
                                            @if ($errors->has('amount'))
                                                <small class="text-danger">{{ $errors->first('amount') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputDate" class="col-sm-3 col-form-label">Tanggal Pengeluaran</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="date" class="form-control"
                                            @if ($errors->has('date')) value="{{ old('date') }}"
                                        @else
                                        value="{{ $data->date ?? old('date') }}" @endif
                                            id="inputDate" required>
                                        @if ($errors->has('date'))
                                            <small class="text-danger">{{ $errors->first('date') }}</small>
                                            S
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('expenses') }}">
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
