@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Daftar Kategori Produk</h3>
            
            <form method="GET" action="{{ route('kategori.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama kategori">
                <button type="submit" class="btn btn-primary"></i> Cari</button>
            </form>
            
            <a href="{{ route('kategori.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Tambah Kategori
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
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                            <tr>
                                <td>{{ $index + 1 + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                                <td>{{ $kategori->NamaKategori }}</td>
                                <td>{{ $kategori->Deskripsi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kategori.edit', $kategori->KategoriID) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kategori->KategoriID) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?')" class="d-inline">
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
                                <td colspan="4" class="text-center">Tidak ada data kategori produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $kategoris->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2">Menampilkan {{ $kategoris->count() }} dari {{ $kategoris->total() }} data kategori.</p>
            </div>
        </div>
    </div>
</div>
@endsection
