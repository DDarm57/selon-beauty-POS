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
                        <a href="{{ route('products.create') }}">
                            <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3"">

                                <i class=" bx bxs-archive-in btn-icon-prepend"></i> Tambah </button>
                        </a>
                        <div class="template-demo table-responsive">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Harga Retail</th>
                                        <th>Harga Agen</th>
                                        <th>Diskon</th>
                                        <th>Stok</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->isEmpty())
                                        <tr>
                                            <td colspan="8" class="text-center">Data Kosong</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>Rp.{{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>Rp.{{ number_format($item->agent_price, 0, ',', '.') }}</td>
                                                <td>Rp.{{ number_format($item->discount, 0, ',', '.') }}</td>
                                                <td>{{ $item->stock }}</td>

                                                <td class="w-25">
                                                    @foreach ($item->categories as $category)
                                                        <span class="badge bg-secondary">{{ $category->name }}</span>
                                                    @endforeach
                                                </td>

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
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Input pencarian -->
                        {{-- <input type="text" id="search" class="form-control mb-4" placeholder="Cari produk...">
                        <div id="product-container" class="row g-3">
                            @if ($data->isEmpty())
                                <p class="text-center">Tidak ada produk yang ditemukan.</p>
                            @else
                                @foreach ($data as $product)
                                    <a href="">
                                        <div class="col-6 col-md-3">
                                            <div class="card card-product">
                                                @if ($product->image)
                                                    <img src="{{ asset('img/products/' . $product->image) }}"
                    class="card-img-top product-image" alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('img/products/default.png') }}"
                        class="card-img-top product-image" alt="{{ $product->name }}">
                    @endif

                    <div class="card-body-product p-2">
                        <h5 class="mt-1 text-primary product-title">{{ $product->name }}</h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-text-product">
                                Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="card-text-product">
                                Stok:{{ '80' }}</p>
                        </div>
                    </div>

                    <div class="card-footer">
                        <span>Kategori:</span>
                        <div class="d-flex align-items-center g-2">

                            @foreach ($product->categories as $item)
                            <span
                                class="badge font-weight-light rounded-pill bg-secondary mr-4">
                                {{ $item->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            </a>
            @endforeach
            @endif
        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-panel ends -->
@endsection
