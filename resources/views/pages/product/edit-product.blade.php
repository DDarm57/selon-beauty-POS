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
                                            <img class="w-100 img-fluid" src="{{ asset('img/products/' . $data->image) }}"
                                                alt="{{ $data->name }}">
                                        @else
                                            <img class="w-100 img-fluid" src="{{ asset('img/products/default.png') }}"
                                                alt="{{ $data->name }}">
                                        @endif
                                        <h4 class="mt-4">Stok Tersedia: {{ $data->stock }}</h4>

                                        <div id="barcode-container" hidden>
                                            <svg id="barcode" class="w-100"></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <form class="forms-sample mt-4" enctype="multipart/form-data"
                                        action="{{ route('products.update', $data->id) }}" method="POST"
                                        id="formUpdateProduct">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="name-input" class="col-sm-2 col-form-label">Produk</label>
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
                                            <label for="code-input" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="d-flex justify-content-between col-sm-10">
                                                <input type="hidden" name="" id="code_now"
                                                    value="{{ $data->code }}">
                                                <input type="text" name="code"
                                                    @if (old('code')) value="{{ old('code') }}"
                                                @else
                                                value="{{ $data->code }}" @endif
                                                    class="form-control w-75" id="code-input" required autocomplete="off">
                                                @if ($errors->has('code'))
                                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                                @endif
                                                <button type="button" class="btn btn-primary w-25">
                                                    <i class="bi bi-upc-scan"> </i>Scan
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="price-input" class="col-sm-2 col-form-label">Harga</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="rp">Rp.</span>
                                                    <input type="text" id="price-input" class="form-control"
                                                        name="price" aria-label="rp" aria-describedby="rp"
                                                        @if (old('price')) value="{{ old('price') }}"
                                                    @else
                                                    value="{{ number_format($data->price, '0', ',', '.') }}" @endif
                                                        class="form-control" id="price-input" required autocomplete="off"
                                                        oninput="formatCurrency(this)">
                                                    @if ($errors->has('price'))
                                                        <small class="text-danger">{{ $errors->first('price') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="agent_price-input" class="col-sm-2 col-form-label">Harga
                                                Agen</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="rp">Rp.</span>
                                                    <input type="text" id="agent_price-input" class="form-control"
                                                        name="agent_price" aria-label="rp" aria-describedby="rp"
                                                        @if (old('agent_price')) value="{{ old('agent_price') }}"
                                                      @else
                                                      value="{{ number_format($data->agent_price, '0', ',', '.') }}" @endif
                                                        class="form-control" id="agent_price-input" required
                                                        autocomplete="off" oninput="formatCurrency(this)">
                                                    @if ($errors->has('agent_price'))
                                                        <small
                                                            class="text-danger">{{ $errors->first('agent_price') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="discount-input" class="col-sm-2 col-form-label">Diskon</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="rp">Rp.</span>
                                                    <input type="text" id="discount-input" class="form-control"
                                                        name="discount" aria-label="rp" aria-describedby="rp"
                                                        @if (old('discount')) value="{{ old('discount') }}"
                                                      @else
                                                      value="{{ number_format($data->discount, '0', ',', '.') }}" @endif
                                                        class="form-control" id="discount-input" required
                                                        autocomplete="off" oninput="formatCurrency(this)">
                                                    @if ($errors->has('discount'))
                                                        <small
                                                            class="text-danger">{{ $errors->first('discount') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="price-input" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-10">
                                                <div class="row row-cols-2 row-cols-md-4 g-2">
                                                    @foreach ($category as $category)
                                                        <!-- Checkbox items -->
                                                        <div>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="category{{ $category->id }}" name="categories[]"
                                                                    value="{{ $category->id }}"
                                                                    @if (in_array($category->id, $data->categories->pluck('id')->toArray())) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="category{{ $category->id }}">
                                                                    {{ $category->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if ($errors->has('categories'))
                                                    <small class="text-danger">{{ $errors->first('categories') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="image-input" class="col-sm-2 col-form-label">File Upload</label>
                                            <div class="col-sm-10">
                                                <input name="image" class="form-control" type="file"
                                                    id="image-input">
                                            </div>
                                            @if ($errors->has('image'))
                                                <small class="text-danger">{{ $errors->first('image') }}</small>
                                            @endif
                                        </div>

                                        <div class="text-end mt-4 d-flex justify-content-end gap-2">
                                            <button type="submit" class="btn btn-lg btn-primary"><i
                                                    class="bi bi-arrow-repeat" id="updateProduct"></i></button>

                                            <button type="button" class="btn btn-lg btn-info btn-icon-text btn-md"
                                                data-bs-toggle="modal" data-bs-target="#stock-modal"><i
                                                    class="bi bi-plus"></i></button>

                                            <button type="button" class="btn btn-lg btn-danger btn-icon-text btn-md"
                                                data-bs-toggle="modal" data-bs-target="#delete-product-modal"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Stok</h4>
                            <div class="template-demo table-responsive">
                                <table class="table table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Stok Masuk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data->stocks as $key => $stock)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($stock->created_at)->format('d F Y') }}
                                                </td>
                                                <td>{{ $stock->stock }}</td>
                                                <td class="d-flex gap-2">
                                                    @php
                                                        // Hitung selisih hari antara tanggal stok dibuat dengan sekarang
                                                        $isDisabled =
                                                            Carbon\Carbon::parse($stock->created_at)->diffInDays(
                                                                Carbon\Carbon::now(),
                                                            ) > 7;
                                                    @endphp
                                                    <button class="btn btn-warning"
                                                        onclick="openEditStockModal({{ $stock->id }}, {{ $stock->stock }})"
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                        <i class="bi bi-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-icon-text btn-md"
                                                        onclick="openDeleteStockModal({{ $stock->id }})">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada riwayat stok.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Modal Tambah Stok --}}
                        <div class="modal fade" id="stock-modal" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Stok</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('products.add-stock') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="stock-input" class="form-label">Jumlah Stok</label>
                                                <input type="number" min="1" class="form-control"
                                                    id="stock-input" name="stock">
                                                @if ($errors->has('stock'))
                                                    <small class="text-danger">{{ $errors->first('stock') }}</small>
                                                @endif
                                                <input type="hidden" name="product_id" value="{{ $data->id }}">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

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

                        <!-- Modal Delete Produk -->
                        <div class="modal fade" id="delete-product-modal" tabindex="-1" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus Produk ini?
                                        <p class="fw-bold mt-3">{{ $data->name }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('products.destroy', $data->id) }}" method="POST"
                                            style="display:inline;">
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
    <!-- main-panel ends -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var inputVal = $("#code-input").val();

            if (inputVal !== "") {
                $("#barcode-container").prop("hidden", false);

                JsBarcode("#barcode", inputVal, {
                    format: "CODE128",
                    displayValue: true,
                    fontSize: 16
                });
            } else {
                alert("Masukkan teks kode terlebih dahulu!");
            }

            $(document).on('click', '#updateProduct', function(e) {
                e.preventDefault();

                let data_code = $('#code-now').val();
                let code_input = $('#code-input').val();

                if (data_code != code_input) {
                    Swal.fire({
                        title: "Update product ?",
                        text: "Kode product telah di ubah apakah yakin ingin update data?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, update data!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#formUpdateProduct').submit();
                        }
                    });
                }
            });
        })
    </script>
@endsection
