<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        /* Global Style */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2.title {
            text-align: center;
            font-size: 18px;
            margin: 0;
            padding: 0;
        }
        .periode {
            text-align: center;
            margin-bottom: 10px;
        }

        /* Table Style */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        /* Header Biru, Teks Putih */
        thead tr th {
            background-color: #007bff;
            color: #fff;
            text-align: center;
        }

        /* Baris Total Keseluruhan */
        tfoot tr.total-row {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .align-middle { vertical-align: middle; }
    </style>
</head>
<body>

    <h2 class="title">Laporan Penjualan</h2>
    <p>&nbsp;</p>

    @if($tanggalMulai && $tanggalSelesai)
    <div class="periode">
        Periode:
        <strong>{{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}</strong>
        -
        <strong>{{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</strong>
    </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $totalKeseluruhan = 0;
            @endphp
            @foreach($penjualans as $penjualan)
                @php
                    $detailCount = count($penjualan->details);
                    $totalKeseluruhan += $penjualan->TotalHarga;
                @endphp

                @foreach($penjualan->details as $index => $detail)
                <tr>
                    {{-- Kolom No, Tanggal, Pelanggan (rowspan) --}}
                    @if($index === 0)
                        <td rowspan="{{ $detailCount }}" class="text-center align-middle">{{ $no++ }}</td>
                        <td rowspan="{{ $detailCount }}" class="text-center align-middle">
                            {{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}
                        </td>
                        <td rowspan="{{ $detailCount }}" class="text-center align-middle">
                            {{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}
                        </td>
                    @endif

                    {{-- Kolom Produk --}}
                    <td class="align-middle">
                        {{ $detail->produk->NamaProduk ?? '-' }}
                    </td>
                    {{-- Kolom Jumlah --}}
                    <td class="text-center align-middle">
                        {{ $detail->JumlahProduk }}
                    </td>
                    {{-- Kolom Harga --}}
                    <td class="text-right align-middle">
                        Rp {{ number_format($detail->produk->Harga ?? 0, 0, ',', '.') }}
                    </td>                    
                    {{-- Kolom Subtotal --}}
                    <td class="text-right align-middle">
                        Rp {{ number_format($detail->SubTotal, 0, ',', '.') }}
                    </td>

                    {{-- Kolom Total Harga & Metode Pembayaran (rowspan) --}}
                    @if($index === 0)
                        <td rowspan="{{ $detailCount }}" class="text-right align-middle">
                            Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
                        </td>
                        <td rowspan="{{ $detailCount }}" class="text-center align-middle">
                            {{ optional($penjualan->pembayaran)->MetodeBayar ?? '-' }}
                        </td>
                    @endif
                </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-right">Total Keseluruhan:</td>
                <td colspan="2" class="text-right">
                    Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
