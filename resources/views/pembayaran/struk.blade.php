@extends('layout.template')
                {{-- <p> dengan nama kasir  {{ $penjualan->user->name ?? 'Tidak Diketahui' }}</p> --}}

@section('content')
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            .no-print,
            .navbar,
            .sidebar {
                display: none !important;
            }

            @page {
                margin: 0;
            }
        }

        .struk-container {
            width: 58mm;
            padding: 10px;
            margin: auto;
            border: none;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 50px;
        }

        .text-center {
            text-align: center;
        }

        .dotted-line {
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            text-align: left;
            padding: 2px 0;
        }

        .total {
            font-weight: bold;
        }

        @page {
            margin: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
        }

        .struk {
            width: 80mm;
            background: white;
            font-family: monospace;
            padding: 5mm;
            margin: 10px auto;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .info,
        .total,
        .footer {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            margin-top: 5px;
            border-collapse: collapse;
        }

        table td {
            padding: 2px 0;
            text-align: left;
        }

        .total p {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }

        .footer p {
            margin: 5px 0;
        }

        .button-container {
            text-align: center;
            margin-top: 15px;
        }
    </style>

    @php
        $penjualan = optional($pembayaran->penjualan);
        $pelangganNama = optional(optional($penjualan)->pelanggan)->NamaPelanggan ?? 'Umum';
    @endphp

    <div class="container mt-5 d-flex justify-content-center">
        <div class="struk">
            <div class="header">
                @if ($profileToko && $profileToko->Logo)
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $profileToko->Logo) }}" alt="Logo Toko"
                            class="img-thumbnail d-block mx-auto" width="80">
                    </div>
                @endif
                <h4>{{ $profileToko->NamaToko ?? 'Nama Toko Tidak Ada' }}</h4>
                <p>{{ $profileToko->Alamat ?? 'Alamat Tidak Ada' }}</p>
                <p>Telp: {{ $profileToko->No_Telp ?? '-' }}</p>
            </div>

            <div class="info">
                <p><strong>Tanggal:</strong>
                    {{ optional($penjualan)->TanggalPenjualan ? date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) : '-' }}
                </p>
                <p><strong>Pelanggan:</strong> {{ $pelangganNama }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $pembayaran->MetodeBayar ?? '-' }}</p>
                <p><strong>Status:</strong> {{ $pembayaran->StatusBayar ?? '-' }}</p>
            </div>
            

            <hr>

            <table>
                <thead>
                    <tr>
                        <td><strong>Item</strong></td>
                        <td><strong>Jml</strong></td>
                        <td><strong>Harga</strong></td>
                        <td><strong>Subtotal</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach (optional($penjualan)->details ?? [] as $detail)
                        <tr>
                            <td>{{ $detail->produk->NamaProduk ?? '-' }}</td>
                            <td>{{ (int) $detail->JumlahProduk }}</td>
                            <td>Rp. {{ number_format((int) ($detail->produk->Harga ?? 0), 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format((int) ($detail->SubTotal ?? 0), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <div class="total">
                @php
                    $totalHarga = (int) ($penjualan->TotalHarga ?? 0);
                    $jumlahBayar = (int) ($pembayaran->JumlahBayar ?? 0);
                    $kembalian = $jumlahBayar - $totalHarga;
                @endphp

                <p><strong>Total:</strong> Rp. {{ number_format($totalHarga, 0, ',', '.') }}</p>
                <p><strong>Bayar:</strong> Rp. {{ number_format($jumlahBayar, 0, ',', '.') }}</p>
                <p><strong>Kembalian:</strong>
                    @if ($kembalian >= 0)
                        Rp. {{ number_format($kembalian, 0, ',', '.') }}
                    @else
                        <span style="color: red;">Pembayaran Kurang!</span>
                    @endif
                </p>
            </div>

            <hr>

            <div class="footer">
                <p id="greeting"></p>
                <p>** TERIMA KASIH **</p>
               
            </div>

            <div class="button-container no-print">
                <button onclick="window.print()" class="btn btn-primary btn-sm btn-print">Cetak Struk</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary btn-sm btn-back">Kembali</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var greetingText;
            var hour = new Date().getHours();

            if (hour < 12) {
                greetingText = "Selamat Pagi!";
            } else if (hour < 18) {
                greetingText = "Selamat Siang!";
            } else {
                greetingText = "Selamat Malam!";
            }

            document.getElementById('greeting').textContent = greetingText;
        });
    </script>
@endsection
