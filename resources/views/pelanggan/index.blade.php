@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Daftar Pelanggan</h3>
            
            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('pelanggan.index') }}" class="d-flex mb-3">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan nama">
                <button type="submit" class="btn btn-primary">
                   Cari
                </button>
            </form>

            <!-- Tombol Tambah & Cetak Laporan (Hanya untuk Admin) -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if(auth()->user()->role_as == 'admin')
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Tambah Pelanggan
                    </a>
                @endif
                <a href="{{ route('pelanggan.exportPdf', request()->query()) }}" class="btn btn-warning">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
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
            
            <!-- Tabel Pelanggan -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Jenis Kelamin</th>
                            @if(auth()->user()->role_as == 'admin')
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 + ($pelanggan->currentPage() - 1) * $pelanggan->perPage() }}</td>
                                <td>{{ $item->NamaPelanggan }}</td>
                                <td>{{ $item->Alamat }}</td>
                                <td>{{ $item->Email }}</td>
                                <td>{{ $item->NomorTelepon }}</td>
                                <td>{{ $item->JenisKelamin }}</td>
                                
                                <!-- Aksi (Hanya Admin) -->
                                @if(auth()->user()->role_as == 'admin')
                                    <td class="text-center">
                                        <a href="{{ route('pelanggan.edit', $item->PelangganID) }}" class="btn btn-warning btn-sm me-1" title="Ubah">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete({{ $item->PelangganID }})">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $item->PelangganID }}" action="{{ route('pelanggan.destroy', $item->PelangganID) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data pelanggan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Info Data -->
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div>
                    {{ $pelanggan->links('pagination::bootstrap-4') }}
                </div>
                <p class="mt-2 text-muted">Menampilkan {{ $pelanggan->count() }} dari {{ $pelanggan->total() }} data pelanggan.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus pelanggan ini?")) {
            document.getElementById("delete-form-" + id).submit();
        }
    }
</script>
@endsection
