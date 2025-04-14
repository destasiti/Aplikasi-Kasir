@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
    @php
        use Carbon\Carbon;
        $hariIni = Carbon::today();
    @endphp

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4">Daftar Produk</h3>

                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('produk.index') }}" class="d-flex mb-3">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                        placeholder="Cari berdasarkan nama produk">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <!-- Tombol Tambah Produk (Hanya untuk Admin) -->
                @if (Auth::user()->role_as == 'admin')
                    <a href="{{ route('produk.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-box"></i> Tambah Produk
                    </a>
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
                                <th>Kedaluwarsa</th>
                                @if (Auth::user()->role_as == 'admin')
                                    <th class="text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $index => $item)
                                @php
                                    // Ambil Kedaluwarsa dari produk atau stock_in jika kosong
                                    $kedaluwarsa =
                                        !empty($item->Kedaluwarsa) && $item->Kedaluwarsa != '-'
                                            ? Carbon::parse($item->Kedaluwarsa)
                                            : ($item->stock_in
                                                ? Carbon::parse($item->stock_in->Kedaluwarsa)
                                                : null);

                                    // Jika kedaluwarsa tetap kosong, set tampilan '-'
                                    $kedaluwarsaText = $kedaluwarsa ? $kedaluwarsa->format('d-m-Y') : '-';

                                    // Cek apakah sudah kedaluwarsa
                                    $isExpired = $kedaluwarsa ? $kedaluwarsa->lessThanOrEqualTo($hariIni) : false;
                                    $isStockEmpty = $item->Stok == 0;
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 + ($produk->currentPage() - 1) * $produk->perPage() }}</td>

                                    <!-- Kolom Foto -->
                                    <td>
                                        @if ($item->FotoProduk && file_exists(public_path('storage/' . $item->FotoProduk)))
                                            <img src="{{ asset('storage/' . $item->FotoProduk) }}" alt="Foto Produk"
                                                width="80" height="80" class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada Gambar</span>
                                        @endif
                                    </td>

                                    <!-- Nama Produk -->
                                    <td>{{ $item->NamaProduk }}</td>

                                    <!-- Harga -->
                                    <td>Rp {{ number_format($item->Harga, 0, ',', '.') }}</td>

                                    <!-- Stok -->
                                    <td>
                                        @if ($isStockEmpty)
                                            <span class="badge bg-danger px-3 py-2">Kosong</span>
                                        @else
                                            {{ $item->Stok }}
                                        @endif
                                    </td>

                                    <!-- Kategori -->
                                    <td>{{ $item->kategori ? $item->kategori->NamaKategori : '-' }}</td>

                                    <!-- Kedaluwarsa -->
                                    <td @if (!$kedaluwarsa)  @endif>

                                        @if ($kedaluwarsaText === '-')
                                            <span class="badge bg-danger">Belum Diisi</span>
                                            <span class="badge bg-success">{{ $kedaluwarsaText }}</span>

                                        @else
                                            @if ($isExpired)
                                                <span class="badge bg-danger">{{ $kedaluwarsaText }}</span>
                                            @else
                                                {{ $kedaluwarsaText }}
                                            @endif
                                        @endif
                                    </td>


                                    <!-- Aksi -->
                                    @if (Auth::user()->role_as == 'admin')
                                        <td class="text-center">
                                            <a href="{{ route('produk.edit', $item->ProdukID) }}"
                                                class="btn btn-sm btn-warning me-1" title="Ubah">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <form action="{{ route('produk.destroy', $item->ProdukID) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        {{ $produk->links('pagination::bootstrap-4') }}
                    </div>
                    <p class="mt-2">Menampilkan {{ $produk->count() }} dari {{ $produk->total() }} data Produk.</p>
                </div>
            </div>
        </div>
    </div>
    <p>&nbsp;
    @endsection
