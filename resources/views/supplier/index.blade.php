@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Daftar Supplier</h3>
            
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('supplier.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>
            </form>

            <!-- Tombol Tambah & Cetak Laporan -->
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('supplier.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Tambah Supplier
                </a>
             
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
            
            <!-- Tabel supplier -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplier as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($supplier->currentPage() - 1) * $supplier->perPage() }}</td>
                                <td>{{ $item->NamaSupplier }}</td>
                                <td>{{ $item->Kontak ?? '-' }}</td>
                                <td>{{ $item->Alamat ?? '-' }}</td>
                               
                                <!-- Aksi -->
                                <td class="text-center">
                                    <a href="{{ route('supplier.edit', $item->SupplierID) }}" class="btn btn-warning btn-sm me-1" title="Ubah">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete({{ $item->SupplierID }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $item->SupplierID }}" action="{{ route('supplier.destroy', $item->SupplierID) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada data supplier</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info Data -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $supplier->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2 text-muted">Menampilkan {{ $supplier->count() }} dari {{ $supplier->total() }} data supplier.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus supplier ini?")) {
            document.getElementById("delete-form-" + id).submit();
        }
    }
</script>
@endsection
