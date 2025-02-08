@extends('layout.app')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row gap-3 gap-md-0">
            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Produk terjual hari ini</h5>
                        <div>
                            <h4>{{ $total_sales }} Produk</h4>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Penghasilan kotor hari ini</h5>
                        <div>
                            <h4>Rp.{{ number_format($earnings, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Penghasilan bersih hari ini</h5>
                        <div>
                            <h4>Rp.{{ number_format($net_income, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Pengeluaran hari ini</h5>
                        <div>
                            <h4>Rp.{{ number_format($expenses, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
