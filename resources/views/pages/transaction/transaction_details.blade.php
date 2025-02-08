@extends('layout.app')

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products') }}">Data Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Auth::user()->role == '1')
                            <a href="{{ route('transaction.print_notes', $transaction->id_transaction) }}" target="_blank">
                                <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3">
                                    <i class=" bx bxs-archive-in btn-icon-prepend"></i> Print Nota
                                </button>
                            </a>
                            <button type="button" id="delete-transaction"
                                class="mt-4 btn btn-danger btn-icon-text btn-md mb-3">
                                <i class=" bi bi-trash-fill btn-icon-prepend"></i> Hapus Transaksi
                            </button>
                        @endif
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Kode Transaksi</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><strong>{{ $transaction->transaction_code }}</strong></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Tgl / Waktu</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <strong>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y') }} /
                                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</strong>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Total Qty</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><strong>{{ $transaction->total_qty }}</strong></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Total Transaksi</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><strong>Rp.
                                                {{ number_format($transaction->total_price) }}</strong></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Bayar</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><strong>Rp.
                                                {{ number_format($transaction->pay) }}</strong></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Kembalian</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><strong>Rp.
                                                {{ number_format($transaction->change) }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-md-0 mt-4">
                                <div class="template-demo table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Jumlah(Qty)</th>
                                                <th>harga</th>
                                                @if ($transaction->role == 1)
                                                    <th>Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($transaction_details->isEmpty())
                                                <tr>
                                                    <td colspan="6" class="text-center">Data Kosong</td>
                                                </tr>
                                            @else
                                                @foreach ($transaction_details as $item)
                                                    <tr>
                                                        <td>{{ $item->code }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>Rp.{{ number_format($item->price, 0, '.', '.') }}</td>
                                                        @if ($transaction->role == 1)
                                                            <td>
                                                                <div class="flex flex-column flex-sm-row gap-2">
                                                                    <a href="{{ route('products.edit', $item->id) }}">
                                                                        <button type="button"
                                                                            class="btn btn-warning btn-icon-text btn-md">
                                                                            <i class="bi bi-eye"></i>
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <h5><strong>Total</strong></h5>
                                        <h5 class="px-2">:</h5>
                                        <h5>Rp. {{ number_format($transaction->total_price) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('transaction_history') }}">
                    <button type="button" class="btn btn-secondary">Kembali</button>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#delete-transaction').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Hapus Transaksi ?",
                text: "Apakah anda yakin ingin menghapus transaksi ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus transaksi!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "{{ route('transaction.delete', $transaction->id) }}";
                }
            });
        });
    </script>
@endsection
