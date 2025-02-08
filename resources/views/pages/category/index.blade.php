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
                        <a href="{{ route('categories.create') }}">
                            <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3"">

                                <i class="bx bxs-layer-plus btn-icon-prepend"></i> Tambah </button>
                        </a>
                        <div class="template-demo table-responsive">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Nama Kategori</th>
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
                                                <td>{{ $item->name }}</td>

                                                <td>
                                                    <div class="flex flex-column flex-sm-row gap-2">
                                                        <a href="{{ route('categories.edit', $item->id) }}">
                                                            <button type="button"
                                                                class="btn btn-warning btn-icon-text btn-md">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-icon-text btn-md"
                                                            onclick="openDeleteCategoryModal({{ $item->id }}, '{{ $item->name }}')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <!-- Vertically centered Modal-->
                            <!-- Delete Category Modal-->
                            <!-- Modal Delete Produk -->
                            <div class="modal fade" id="delete-modal" tabindex="-1" style="display: none;"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus Kategori ini?
                                            <p class="fw-bold mt-3" id="name"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form id="delete-form" method="POST" style="display:inline;">
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
