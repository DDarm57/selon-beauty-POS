@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('stocks') }}">Stok</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Penambahan Stok</h4>
                        <div class="template-demo table-responsive">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Stok Masuk</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Data Kosong</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->stock }}</td>
                                                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                <td class="d-flex gap-2">
                                                    @php
                                                        // Hitung selisih hari antara tanggal stok dibuat dengan sekarang
                                                        $isDisabled =
                                                            Carbon\Carbon::parse($item->created_at)->diffInDays(
                                                                Carbon\Carbon::now(),
                                                            ) > 7;
                                                    @endphp
                                                    <button class="btn btn-warning"
                                                        onclick="openEditStockModal({{ $item->id }}, {{ $item->stock }})"
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                        <i class="bi bi-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-icon-text btn-md"
                                                        onclick="openDeleteStockModal({{ $item->id }})">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <!-- Vertically centered Modal-->
                            <!-- Modal Edit Stok -->
                            <div class="modal fade" id="edit-stock-modal" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Riwayat Stok</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="edit-stock-form" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" id="edit-stock-id" name="stock_id_update">

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="edit-stock-input" class="form-label">Jumlah Stok</label>
                                                    <input type="number" min="1" class="form-control"
                                                        id="edit-stock-input" name="stock_update">
                                                    <small class="text-danger d-none" id="edit-stock-error"></small>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete Stock -->
                            <div class="modal fade" id="delete-stock-modal" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Tambahan Stok</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form id="delete-stock-form" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon-text btn-md">Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
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
