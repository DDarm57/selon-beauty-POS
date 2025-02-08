@extends('layout.app')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('users') }}">Data User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('users.create') }}">
                                <button type="button" class="mt-4 btn btn-primary btn-icon-text btn-md mb-3"">

                                    <i class="bi bi-person-plus-fill btn-icon-prepend"></i> Tambah </button>
                            </a>

                            <div class="template-demo table-responsive">
                                <table class="table table-striped datatable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Status</th>
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
                                                    <td>{{ $item->username }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>
                                                        @if ($item->status == 'active')
                                                            <label
                                                                class="badge rounded-pill bg-success">{{ $item->status }}</label>
                                                        @else
                                                            <label
                                                                class="badge rounded-pill bg-danger">{{ $item->status }}</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="flex flex-column flex-sm-row gap-2">
                                                            <a href="{{ route('users.edit', $item->id) }}">
                                                                <button type="button"
                                                                    class="btn btn-warning btn-icon-text btn-md">
                                                                    <i class="bi bi-pencil-square"></i>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- main-panel ends -->
@endsection
