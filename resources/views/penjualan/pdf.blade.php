<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table-responsive { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, p { text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>

    @if($tanggalMulai && $tanggalSelesai)
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</p>
    @else
        <p>Menampilkan Semua Data</p>
    @endif

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
                @forelse ($penjualans->sortByDesc('created_at')->values() as $penjualan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</td>
                        <td>{{ optional($penjualan->pelanggan)->NamaPelanggan ?? 'Non-Member' }}</td>
                        <td>
                            @foreach ($penjualan->details as $detail)
                                {{ $detail->produk->NamaProduk }} ({{ $detail->JumlahProduk }}) <br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
