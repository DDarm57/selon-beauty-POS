@extends('layout.app')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> {{ $title }} </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories') }}">Produk</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3" id="btnModalPrint">
                        <i class="bi bi-printer btn-icon-prepend"></i>
                        Cetak
                    </button> -->
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <form action="" class="d-inline">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a href="{{ route('transaction_history') }}" class="btn btn-secondary">Reset</a>
                                            </div>
                                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $search_form['start_date'] }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $search_form['end_date'] }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-success" id="exportExcelButton">Export</button>
                        </div>
                    </div>
                    <div class="template-demo table-responsive">
                        <table class="table table-striped datatable table-history-transaction">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tgl/Waktu</th>
                                    <th>Kasir</th>
                                    <!-- <th>Nama Customer</th> -->
                                    <th>Total Qty</th>
                                    <th>Total Transaksi</th>
                                    <th>Total Potongan</th>
                                    <th>Total Sesudah Diskon</th>
                                    <th>Bayar</th>
                                    <th>Kembali</th>
                                    <th>Pembayaran</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transactions->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center">Data Kosong</td>
                                </tr>
                                @else
                                @foreach ($transactions as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->transaction_code }}</td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($item->created_at)) }} /
                                        {{ date('H:i', strtotime($item->created_at)) }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <!-- <td>{{ $item->customer_name }}</td> -->
                                    <td>{{ $item->total_qty }}</td>
                                    <td>Rp.{{ number_format($item->total_price, 0, '.', '.') }}</td>
                                    @php
                                    $total_potongan = $item->total_price - $item->total_price_after_discount;
                                    @endphp
                                    <td>RP.{{ number_format($total_potongan, 0, '.', '.') }}</td>
                                    <td>RP.{{ number_format($item->total_price_after_discount, 0, '.', '.') }}</td>
                                    <td>Rp.{{ number_format($item->pay, 0, '.', '.') }}</td>
                                    <td>RP.{{ number_format($item->change, 0, '.', '.') }}</td>
                                    <td style="text-transform: capitalize;">{{ $item->payments }}</td>
                                    <td style="text-transform: capitalize;">{{ $item->transaction_tipe }}</td>
                                    <td>
                                        <a href="{{ route('transaction_details', $item->id_transaction) }}"
                                            class="btn btn-info">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
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
    $(document).ready(function() {
        $('#btnModalPrint').on('click', function() {
            $('#exampleModal').modal('show');
            $('#exampleModal .modal-title').text('Cetak Laporan Transaksi');
        });

        $('#exportExcelButton').click(function() {
            let start_date = $("#start_date").val();
            let end_date = $("#end_date").val();

            if (start_date == '' || end_date == '') {
                Swal.fire({
                    icon: "error",
                    title: "Tanggal tidak boleh kosong",
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }

            if (start_date > end_date) {
                Swal.fire({
                    icon: "error",
                    title: "Tanggal awal tidak boleh lebih besar dari tanggal akhir",
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }

            Swal.fire({
                title: "Download Excel",
                text: "Data history transaksi akan di export di tanggal " + start_date + ' - ' + end_date,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Export"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Exported!",
                        text: "Data berhasil di export.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Clone tabel utama tanpa mengubah struktur aslinya
                    let tableData = $(".table-history-transaction");

                    // Ekspor ke Excel
                    tableData.table2excel({
                        exclude: ".noExl",
                        name: "Transactions",
                        filename: `Laporan_Transaksi_${start_date}-${end_date}.xls`,
                        fileext: ".xls"
                    });

                }
            });
        });
    })
</script>
@endsection