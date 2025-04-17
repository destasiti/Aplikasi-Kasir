@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4 text-center">Daftar Barang Keluar</h3>
            
            <form method="GET" action="{{ route('stock_out.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama produk">
                <button type="submit" class="btn btn-primary">
                   </i> Cari
                </button>
            </form>

            <a href="{{ route('stock_out.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Barang Keluar
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
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Tanggal Keluar</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stockOuts as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->produk)
                                        {{ $item->produk->NamaProduk }}
                                    @else
                                        <span class="badge bg-danger">Produk tidak ditemukan</span>
                                    @endif
                                </td>
                                <td>{{ $item->Jumlah }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->TanggalKeluar)->format('d-m-Y') }}</td>
                                <td>{{ $item->Keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    {{-- <a href="{{ route('stock_out.show', $item->StockOutID) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a> --}}
                                    <form action="{{ route('stock_out.destroy', $item->StockOutID) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?')">
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
                                <td colspan="6" class="text-center">Tidak ada data barang keluar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <p class="mt-2">
                    Menampilkan {{ $stockOuts->count() }} data barang keluar.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection