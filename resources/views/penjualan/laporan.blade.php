@extends('layout.template')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4 text-center">Laporan Penjualan</h3>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('penjualan.laporan') }}" class="d-flex gap-2 mb-3">
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control" style="max-width: 200px;">
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control" style="max-width: 200px;">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search"></i> Filter
                </button>
                @if(request('tanggal_mulai') && request('tanggal_selesai'))
                <a href="{{ route('penjualan.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
                @endif
            </form>

            <!-- Menampilkan rentang tanggal jika ada pencarian -->
            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                <p class="text-center">
                    Menampilkan laporan dari <strong>{{ request('tanggal_mulai') }}</strong> 
                    sampai <strong>{{ request('tanggal_selesai') }}</strong>
                </p>

                <!-- Tabel hanya muncul setelah pencarian -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Produk</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualans as $index => $penjualan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</td>
                                    <td>{{ optional($penjualan->pelanggan)->NamaPelanggan ?? 'NON-MEMBER' }}</td>
                                    <td>
                                        @foreach ($penjualan->details as $detail)
                                            {{ $detail->produk->NamaProduk }} ({{ $detail->JumlahProduk }}) <br>
                                        @endforeach
                                    </td>
                                    <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
