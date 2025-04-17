@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Daftar Barang Keluar</h3>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('stock_out.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama produk atau keterangan">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Tombol Tambah Manual -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('stock_out.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Barang Keluar Manual
                </a>
                {{-- Tombol cetak laporan jika kamu mau tambahkan fitur ini nanti --}}
                {{-- <a href="{{ route('laporan.stock_out.pdf') }}" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a> --}}
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
                <div id="success-message" class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 5000);
                </script>
            @endif

            <!-- Tabel Barang Keluar -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tanggal Keluar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockOuts as $index => $out)
                            <tr>
                                <td>{{ $index + 1 + ($stockOuts->currentPage() - 1) * $stockOuts->perPage() }}</td>
                                <td>{{ $out->produk->NamaProduk ?? '-' }}</td>
                                <td>{{ $out->Jumlah }}</td>
                                <td>{{ \Carbon\Carbon::parse($out->TanggalKeluar)->translatedFormat('d F Y') }}</td>
                                <td>{{ $out->Keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data barang keluar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info Data -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $stockOuts->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2 text-muted">Menampilkan {{ $stockOuts->count() }} dari {{ $stockOuts->total() }} data barang keluar.</p>
            </div>
        </div>
    </div>
</div>
@endsection
