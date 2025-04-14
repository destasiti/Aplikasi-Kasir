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
    color: #333 !important; 
    vertical-align: middle;
    font-size: 14px;
    padding: 8px;
    text-align: center;
    font-weight: normal; /* Tidak terlalu tebal */
}

/* Header tabel */
.table thead th {
    text-align: center;
    background-color: #f8f9fa !important;
    color: #333;
    font-size: 14px;
    padding: 10px;
    border-bottom: 2px solid #ddd; /* Border lebih soft */
}

/* Border tabel lebih rapi */
.table {
    border-collapse: collapse;
}

.table th, .table td {
    border: 1px solid #ddd; /* Border lebih soft */
}

/* Badge style lebih ringan */
.badge {
    padding: 5px 10px;
    font-size: 12px;
    font-weight: normal; /* Kurangi ketebalan */
    border-radius: 5px;
}

/* Badge warna */
.badge-danger {
    background-color: #ff6b6b !important;
    color: white !important;
}

.badge-warning {
    background-color: #ffcc00 !important;
    color: black !important;
}

/* Jika tidak ada data */
.no-data {
    text-align: center;
    font-style: italic;
    color: gray;
    font-size: 14px;
    padding: 10px;
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
        <!-- Selamat Datang --><div class="row"> 
    <div class="col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="text-center">
                    <h3 class="card-title text-primary"><b>Selamat Datang, {{ Auth::user()->name }}! 🚀 </b></h3>
                    <p class="mb-4">
                        Sekarang <span class="fw-bold">kamu</span> bisa mengelola transaksi <b>Kasir SMKI UTAMA.</b>
                    </p>
                </div>
                <div class="image-container" style="max-width: 150px;">
                    <img src="{{ asset('asset/img/flowers.png') }}" alt="Gambar Selamat Datang" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>


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

        <div class="row">
            <!-- Produk Best Seller -->
            <div class="col-lg-6 col-md-12 mb-3">
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
        
            <!-- Produk dengan Stok Rendah -->
            <div class="col-lg-6 col-md-12 mb-3">
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
        </div>
@endsection        