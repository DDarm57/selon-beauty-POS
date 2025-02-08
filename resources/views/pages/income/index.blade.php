@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('incomes') }}">Keuangan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <a href="">
                            <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3"">

                                <i class="bi bi-printer btn-icon-prepend"></i> Cetak </button>
                        </a>
                        {{-- <div class="template-demo table-responsive">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>Perihal</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">Data Kosong</td>
                                        </tr>
                                    @else
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description ?? '-' }}</td>

                                                <td>Rp.{{ number_format($item->amount, 0, ',', '.') }}</td>
                                                <td>{{ date('d F Y', strtotime($item->date)) }}</td>

                                                <td>
                                                    <div class="flex flex-column flex-sm-row gap-2">
                                                        <a href="{{ route('expenses.edit', $item->id) }}">
                                                            <button type="button"
                                                                class="btn btn-warning btn-icon-text btn-md">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-icon-text btn-md"
                                                            data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>

                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="delete-modal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus data ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <form action="{{ route('expenses.destroy', $item->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-icon-text btn-md">Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- End Vertically centered Modal-->
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- main-panel ends -->
@endsection
