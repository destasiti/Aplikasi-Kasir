@extends('layout.template')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Transaksi</h2>
        <a href="{{ route('transaksi.create', ['penjualanID' => $penjualanID ?? 1]) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Transaksi
        </a>        
    </div>
    
    <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex mb-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari berdasarkan ID Penjualan atau Metode Bayar">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
    </form>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Penjualan ID</th>
                    <th>Metode Bayar</th>
                    <th>Status Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->TransaksiID }}</td>
                    <td>{{ $t->PenjualanID }}</td>
                    <td>{{ $t->MetodeBayar }}</td>
                    <td>
                        <span class="badge {{ $t->StatusBayar == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                            {{ $t->StatusBayar }}
                        </span>
                    </td>
                    <td>Rp{{ number_format($t->JumlahBayar, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($t->Kembalian, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', $t->TransaksiID) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('transaksi.destroy', $t->TransaksiID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
