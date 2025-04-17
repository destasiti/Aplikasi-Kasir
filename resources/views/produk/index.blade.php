@extends('layout.template') 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
@php
use App\Models\StockOut;
use Carbon\Carbon;
$hariIni = Carbon::today();
@endphp

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Daftar Produk</h3>
            
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('produk.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama produk">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Tombol Tambah Produk -->
            <a href="{{ route('produk.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-box"></i> Tambah Produk
            </a>

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

            <!-- Tabel Produk -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th>Tanggal Kedaluwarsa</th>
                            <th>Status</th>
                            <th>Aksi kedaluwarsa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $index => $item)
                        @php
                            $kedaluwarsa = $item->Kedaluwarsa ? Carbon::parse($item->Kedaluwarsa) : null;
                            $isExpired = $kedaluwarsa && $kedaluwarsa->lessThanOrEqualTo(now());
                            $isSoonExpired = $kedaluwarsa && !$isExpired && $kedaluwarsa->diffInDays(now()) <= 7;
                            $sudahDipindah = $kedaluwarsa &&
                                StockOut::where('ProdukID', $item->ProdukID)
                                        ->whereDate('Kedaluwarsa', $item->Kedaluwarsa)
                                        ->exists();
                        @endphp
                        <tr>
                            <td>{{ $index + 1 + ($produk->currentPage() - 1) * $produk->perPage() }}</td>
                            <td>
                                @if($item->FotoProduk)
                                    <img src="{{ asset('storage/' . $item->FotoProduk) }}" alt="Foto Produk" width="100" height="100">
                                @else
                                    <span class="badge bg-secondary">Tidak Ada Gambar</span>
                                @endif
                            </td>
                            <td>{{ $item->NamaProduk }}</td>
                            <td>Rp {{ number_format($item->Harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->Stok == 0)
                                    <span class="badge bg-danger px-3 py-2">Kosong</span>
                                @else
                                    {{ $item->Stok }}
                                @endif
                            </td>
                            <td>{{ $item->kategori ? $item->kategori->NamaKategori : '-' }}</td>
                            <td>
                                @if (!$kedaluwarsa)
                                    <span class="badge bg-secondary">Belum Ada</span>
                                @elseif ($isExpired || $kedaluwarsa->isToday())
                                    <span class="badge bg-danger">{{ $kedaluwarsa->translatedFormat('d F Y') }}</span>
                                @else
                                    {{ $kedaluwarsa->translatedFormat('d F Y') }}
                                @endif
                            </td>
                            <td>
                                @if ($item->Stok == 0)
                                    <span class="badge bg-secondary">Tidak Ada</span>
                                @elseif (!$kedaluwarsa)
                                    <span class="badge bg-secondary">Belum Ada</span>
                                @elseif ($isExpired)
                                    <span class="badge bg-danger">Kedaluwarsa</span>
                                @elseif ($isSoonExpired)
                                    <span class="badge bg-warning text-dark">Segera Kedaluwarsa</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td>
                                @if(($isSoonExpired || $isExpired) && $item->Stok > 0 && !$sudahDipindah)
                                    <form action="{{ route('produk.pindahKeStockOut') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="ProdukID" value="{{ $item->ProdukID }}">
                                        <input type="hidden" name="Jumlah" value="{{ $item->Stok }}">
                                        <input type="hidden" name="Keterangan" value="Kedaluwarsa">
                                        <button class="btn btn-warning btn-sm">Pindahkan ke Barang Keluar</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Tidak Ada Aksi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $item->ProdukID) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $item->ProdukID) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
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
                            <td colspan="10" class="text-center text-muted">Tidak ada data produk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $produk->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2">Menampilkan {{ $produk->count() }} dari {{ $produk->total() }} data produk.</p>
            </div>
        </div>
    </div>
</div>
@endsection
