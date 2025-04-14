<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Belanja Produk</title>
    <style>
        body { font-family: sans-serif; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    {{-- Judul Laporan dengan Rentang Tanggal --}}
    <h3>Riwayat Belanja Produk</h3>
    <p>
        Periode: 
        @if(request()->tanggal_mulai && request()->tanggal_selesai)
            {{ \Carbon\Carbon::parse(request()->tanggal_mulai)->format('d M Y') }} 
            - 
            {{ \Carbon\Carbon::parse(request()->tanggal_selesai)->format('d M Y') }}
        @else
            Semua Periode
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Supplier</th>
                <th>Jumlah</th>
                <th>Harga Beli</th>
                <th>Tanggal Pembelian</th>
                <th>Kedaluwarsa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $index => $stock)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stock->produk->NamaProduk ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $stock->supplier->NamaSupplier ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $stock->Jumlah }}</td>
                    <td>Rp {{ number_format($stock->HargaBeli, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($stock->TanggalMasuk)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($stock->Kedaluwarsa)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
