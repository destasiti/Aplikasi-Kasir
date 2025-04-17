@extends('layout.template')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Warna putih untuk semua judul kategori */
        .card-header h5 {
            color: white !important;
        }
        /* Teks dalam tabel */
        .table tbody td {
            color: black !important;
            vertical-align: middle;
            font-size: 14px;
            padding: 10px;
            text-align: center;
        }
        /* Warna untuk badge */
        .badge-danger {
            background-color: #ff4d4d !important;
            color: white !important;
            font-weight: bold;
        }
        .badge-warning {
            background-color: #ffcc00 !important;
            color: black !important;
            font-weight: bold;
        }
        /* Header tabel */
        .table thead th {
            text-align: center;
            background-color: #212529 !important;
            color: white;
            font-size: 16px;
            padding: 12px;
        }
        /* Jika tidak ada data */
        .no-data {
            text-align: center;
            font-style: italic;
            color: gray;
            font-size: 14px;
        }
        /* Ukuran card dalam frame content */
        .dashboard-card {
            min-height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <!-- Selamat Datang -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="text-center">
                            <h3 class="card-title text-primary"><b>Selamat Datang, Admin Smart Tech! 🚀</b></h3>
                            <p class="mb-4">Sekarang <span class="fw-bold">Kamu</span> bisa mengelola <b>Kasir Admin SMKI
                                    UTAMA</b> dengan mudah dan efektif.</p>
                        </div>
                        <div class="image-container" style="max-width: 150px;">
                            <img src="{{ asset('asset/img/flowers.png') }}" alt="Gambar Selamat Datang" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
<p>
        <!-- Dashboard Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 mb-3">
                <div class="dashboard-card p-0 overflow-hidden"
                    style="border: 2px solid #007bff; border-radius: 8px; background-color: #007bff;">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="icon">
                            <img src="{{ asset('asset/img/boks.png') }}" alt="Product Icon" class="img-fluid"
                                style="max-width: 40px;">
                        </div>
                        <div class="details text-right">
                            <h5 class="text-white mb-1">{{ $totalProduk }}</h5>
                            <p class="text-white mb-0" style="font-size: 14px;">PRODUK</p>
                        </div>
                    </div>
                    <div class="text-center p-2" style="background-color: white;">
                        <a href="{{ route('produk.index') }}" class="d-block text-primary fw-bold"
                            style="padding: 8px 0; font-size: 14px; text-decoration: none;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Total Pelanggan -->
            <div class="col-lg-3 col-md-3 col-sm-4 mb-3">
                <div class="dashboard-card p-0 overflow-hidden"
                    style="border: 2px solid #ffc107; border-radius: 8px; background-color: #ffc107;">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="icon">
                            <img src="{{ asset('asset/img/user.png') }}" alt="Customer Icon" class="img-fluid"
                                style="max-width: 40px;">
                        </div>
                        <div class="details text-right">
                            <h5 class="text-white mb-1">{{ $totalPelanggan }}</h5>
                            <p class="text-white mb-0" style="font-size: 14px;">PELANGGAN</p>
                        </div>
                    </div>
                    <div class="text-center p-2" style="background-color: white;">
                        <a href="{{ route('pelanggan.index') }}" class="d-block text-warning fw-bold"
                            style="padding: 8px 0; font-size: 14px; text-decoration: none;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-4 mb-3">
                <div class="dashboard-card p-0 overflow-hidden"
                    style="border: 2px solid #94229c; border-radius: 8px; background-color: #94229c;">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="icon">
                            <img src="{{ asset('asset/img/transaksi.png') }}" alt="Transaction Icon" class="img-fluid"
                                style="max-width: 40px;">
                        </div>
                        <div class="details text-right">
                            <h5 class="text-white mb-1">{{ $totalTransaksi }}</h5>
                            <p class="text-white mb-0" style="font-size: 14px;">TRANSAKSI</p>
                        </div>
                    </div>
                    <div class="text-center p-2" style="background-color: white;">
                        <a href="{{ route('penjualan.index') }}" class="d-block text-purple fw-bold"
                            style="padding: 8px 0; font-size: 14px; text-decoration: none; color: #94229c !important;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Total Kategori -->
            <div class="col-lg-3 col-md-3 col-sm-4 mb-3">
                <div class="dashboard-card p-0 overflow-hidden"
                    style="border: 2px solid #24a8a2; border-radius: 8px; background-color: #24a8a2;">
                    <div class="d-flex align-items-center justify-content-between p-3">
                        <div class="icon">
                            <img src="{{ asset('asset/img/kategori.png') }}" alt="Category Icon" class="img-fluid"
                                style="max-width: 40px;">
                        </div>
                        <div class="details text-right">
                            <h5 class="text-white mb-1">{{ $totalKategori }}</h5>
                            <p class="text-white mb-0" style="font-size: 14px;">KATEGORI</p>
                        </div>
                    </div>
                    <div class="text-center p-2" style="background-color: white;">
                        <a href="{{ route('kategori.index') }}" class="d-block text-teal fw-bold"
                            style="padding: 8px 0; font-size: 14px; text-decoration: none; color: #24a8a2 !important;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
<p>
        <!-- Main Row: Grafik dan Tabel di Sampingnya -->
        <div class="row">
            <!-- Kolom Kiri: Grafik Penjualan -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income"
                                    aria-selected="true">
                                    Penjualan
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab">Keuntungan</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body px-3">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                <div class="d-flex p-4 pt-3">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" alt="User"
                                            width="40" />
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Penjualan</small>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h6>
                                            <small class="text-success fw-semibold">
                                                <i class="bx bx-chevron-up"></i> +{{ $persentaseKenaikan }}%
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Container Grafik -->
                                <div style="width: 100%; height: 300px;">
                                    <canvas id="penjualanChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <!-- Produk dengan Stok Rendah -->
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-exclamation-triangle"></i> Produk dengan Stok Rendah (≤5)
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($produkHampirHabis->count())
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produkHampirHabis as $produk)
                                                <tr>
                                                    <td>{{ $produk->NamaProduk }}</td>
                                                    <td>
                                                        <span class="badge badge-danger bg-danger text-white">
                                                            {{ $produk->Stok }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="no-data">Tidak ada produk dengan stok rendah.</p>
                                @endif
                            </div>
                        </div>
                    </div>
{{-- <p>
                    <!-- Produk Mendekati Kedaluwarsa -->
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-clock"></i> Produk Mendekati Kedaluwarsa (≤30 Hari)
                                </h5>
                            </div>
                            <div class="card-body">
                                @if ($produkMenjelangKedaluwarsa->count())
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Kedaluwarsa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($produkMenjelangKedaluwarsa as $produk)
                                                <tr>
                                                    <td>{{ $produk->NamaProduk }}</td>
                                                    <td>
                                                        <span class="badge badge-danger bg-danger text-white">
                                                            {{ \Carbon\Carbon::parse($produk->stock_in->Kedaluwarsa)->format('d-m-Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="no-data">Tidak ada produk yang mendekati kedaluwarsa.</p>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                </div></div></div>
                <p>
<div class="row">
    <!-- Produk Best Seller -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-success">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-star"></i> Produk Best Seller
                </h5>
            </div>
            <div class="card-body">
                @if ($produkBestSeller->count())
                    <table class="table table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produkBestSeller as $index => $produk)
                                <tr>
                                    <td>{{ $produk->NamaProduk }}</td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            {{ $bestSellers[$index]->total_terjual }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="no-data text-center">Tidak ada produk best seller.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('penjualanChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Total Penjualan',
                    data: @json($dataPenjualan),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
