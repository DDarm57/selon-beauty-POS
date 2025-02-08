@extends('layout.app')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-search-container">
                        <form action="" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="cekData">Cek Data</button>
                        </form>
                    </div>
                    <div class="result-data-container mt-2" hidden>
                        <h4>Laporan Transaksi : </h4>
                        <table class="mb-2" id="table-header">
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td class="px-2">:</td>
                                <td id="result-search"></td>
                            </tr>
                        </table>
                        <div class="template-demo table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Kasir</th>
                                        <th>Total Qty</th>
                                        <th>Total Transaksi</th>
                                        <th>Bayar</th>
                                        <th>Kembali</th>
                                    </tr>
                                </thead>
                                <tbody id="resultTableData">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success" id="exportExcelButton" hidden>Ekspor</button>
                </div>
            </div>
        </div>
    </div>

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
                        <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3" id="btnModalPrint">
                            <i class="bi bi-printer btn-icon-prepend"></i>
                            Cetak
                        </button>
                        <div class="template-demo table-responsive">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tgl/Waktu</th>
                                        <th>Kasir</th>
                                        <!-- <th>Nama Customer</th> -->
                                        <th>Total Qty</th>
                                        <th>Total Transaksi</th>
                                        <th>Bayar</th>
                                        <th>Kembali</th>
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
                                                <td>Rp.{{ number_format($item->pay, 0, '.', '.') }}</td>
                                                <td>RP.{{ number_format($item->change, 0, '.', '.') }}</td>
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

            $("#cekData").on('click', function(e) {
                e.preventDefault();
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

                $.ajax({
                    url: "{{ route('getTransactionByDate') }}",
                    type: 'POST',
                    // method: 'POST',
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        $('.result-data-container').prop('hidden', false);
                        $("#exportExcelButton").prop('hidden', false);
                        // Kosongkan tabel sebelum menambahkan data baru
                        $('#resultTableData').empty();

                        // Pastikan response memiliki data
                        if (response.data) {
                            $('#result-search').text(response.search);
                            $.each(response.data, function(index, item) {
                                let html = `
                                <tr>
                                    <td>${item.no}</td>
                                    <td>${item.transaction_code}</td>
                                    <td>${item.name_cashier}</td>
                                    <td>${item.total_qty}</td>
                                    <td>Rp. ${item.total_price.toLocaleString('id-ID')}</td>
                                    <td>Rp. ${item.pay.toLocaleString('id-ID')}</td>
                                    <td>Rp. ${item.change.toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                                $('#resultTableData').append(html);
                            });

                            $('#exportExcelButton').click(function() {
                                // Buat tabel khusus untuk header (Tanggal Transaksi)
                                let tableHeader = `
                                <table>
                                    <tr>
                                        <th colspan="7" style="text-align:center; font-weight:bold;">Tanggal Transaksi</th>
                                    </tr>
                                    <tr>
                                        <th colspan="7" style="text-align:center;">2025-02-01 - 2025-02-07</th>
                                    </tr>
                                </table>
                                <br>
                            `;

                                // Clone tabel utama tanpa mengubah struktur aslinya
                                let tableData = $(".table").eq(0).clone();

                                // Gabungkan header dan tabel transaksi dalam satu elemen
                                let fullTable = $("<div></div>").append(tableHeader)
                                    .append(tableData);

                                // Pastikan `<thead>` tetap terlihat dalam ekspor
                                fullTable.find("thead").show();

                                // Ekspor ke Excel
                                fullTable.table2excel({
                                    exclude: ".noExl",
                                    name: "Transactions",
                                    filename: `Laporan_Transaksi_${response.search}.xls`,
                                    fileext: ".xls"
                                });
                            });

                        } else {
                            $('#resultTableData').append(
                                '<tr><td colspan="7">No data available</td></tr>');
                        }
                    },

                })
            })
        })
    </script>
@endsection
