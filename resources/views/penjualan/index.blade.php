@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4 text-center">Daftar Penjualan</h3>
            
            <form method="GET" action="{{ route('penjualan.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama pelanggan atau nama kasir">
                <button type="submit" class="btn btn-primary">
                     Cari
                </button>
            </form>

            <a href="{{ route('penjualan.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>  
            
            
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
            
            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                <p class="text-center">Menampilkan data dari tanggal <strong>{{ request('tanggal_mulai') }}</strong> sampai <strong>{{ request('tanggal_selesai') }}</strong></p>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kasir</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Total Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $index => $penjualan)
                            <tr>
                                <td>{{ $index + 1 + ($penjualans->currentPage() - 1) * $penjualans->perPage() }}</td>
                                <td>{{ $penjualan->user->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</td>
                                <td>
                                    @if (optional($penjualan->pelanggan)->NamaPelanggan)
                                        {{ $penjualan->pelanggan->NamaPelanggan }}
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">NON-MEMBER</span>
                                    @endif
                                </td>
                                                                <td>
                                    @foreach ($penjualan->details as $detail)
                                        {{ $detail->produk->NamaProduk }} ({{ $detail->JumlahProduk }}) <br>
                                    @endforeach
                                </td>
                                <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('penjualan.show', $penjualan->PenjualanID) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    @if($penjualan->pembayaran)
                                    <a href="{{ url('pembayaran/struk/' . $penjualan->pembayaran->PembayaranID) }}" class="btn btn-sm btn-warning me-1" title="Cetak Struk">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                @endif
                                
                                
                                    <form action="{{ route('penjualan.destroy', $penjualan->PenjualanID) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                               
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $penjualans->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2">Menampilkan {{ $penjualans->count() }} dari {{ $penjualans->total() }} data penjualan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
