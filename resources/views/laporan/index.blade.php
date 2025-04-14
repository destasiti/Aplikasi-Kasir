@extends('layout.template')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="mb-4 text-center">Laporan Penjualan</h2>

    <div class="card p-4 shadow-sm">
        <form action="{{ route('laporan.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required 
                        value="{{ request('tanggal_mulai') }}">
                </div>

                <div class="col-md-5">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai:</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required 
                        value="{{ request('tanggal_selesai') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100" name="lihat">Lihat Laporan</button>
                </div>
            </div>

            @if(request('tanggal_mulai') && request('tanggal_selesai') && count($penjualans) > 0)
                <div class="text-end mt-3">
                    <a href="{{ route('laporan.cetak', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}" 
                        class="btn btn-primary">Cetak Laporan</a>
                </div>
            @endif
        </form>
    </div>

    @if(request('tanggal_mulai') && request('tanggal_selesai'))
        @if(count($penjualans) > 0)
        <div class="mt-4 card shadow-sm">
            <!-- Card header dengan background biru dan teks putih -->
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0 text-white">Laporan Penjualan</h5>
                <small>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}</small>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
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
                            @php $totalKeseluruhan = 0; @endphp
                            @foreach($penjualans as $key => $penjualan)
                                @foreach($penjualan->details as $index => $detail)
                                <tr>
                                    @if($index === 0)
                                        <td rowspan="{{ count($penjualan->details) }}" class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td rowspan="{{ count($penjualan->details) }}" class="text-center align-middle">{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</td>
                                        <td rowspan="{{ count($penjualan->details) }}" class="text-center align-middle">{{ $penjualan->pelanggan->NamaPelanggan ?? 'Umum' }}</td>
                                    @endif
                                    <td>{{ $detail->produk->NamaProduk ?? '-' }}</td>
                                    <td class="text-center">{{ $detail->JumlahProduk }}</td><td class="text-end">
                                        Rp {{ number_format($detail->produk->Harga ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        Rp {{ number_format(($detail->produk->Harga ?? 0) * $detail->JumlahProduk, 0, ',', '.') }}
                                    </td>                                    
                                    @if($index === 0)
                                        <td rowspan="{{ count($penjualan->details) }}" class="text-end align-middle">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                        <td rowspan="{{ count($penjualan->details) }}" class="text-center align-middle">{{ optional($penjualan->pembayaran)->MetodeBayar ?? '-' }}</td>
                                    @endif
                                </tr>
                                @endforeach
                                @php $totalKeseluruhan += $penjualan->TotalHarga; @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary">
                                <th colspan="7" class="text-end">Total Keseluruhan:</th>
                                <th colspan="2" class="text-end">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="alert alert-warning mt-4 text-center">
            <h5 class="text-danger">Data pada tanggal tersebut tidak ada.</h5>
        </div>
        @endif
    @endif
</div>
@endsection
