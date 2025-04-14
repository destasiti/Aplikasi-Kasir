@extends('layout.template')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Detail Penjualan</h5>
                    <small class="text-muted">Informasi Transaksi</small>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Tanggal Transaksi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light" value="{{ $penjualan->TanggalPenjualan }}"
                                readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Pelanggan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control bg-light"
                                value="{{ optional($penjualan->pelanggan)->NamaPelanggan ?? 'Non-Member' }}" readonly>
                        </div>
                    </div>

                    <h5 class="mt-4">Produk yang Dibeli</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($penjualan->details && $penjualan->details->count() > 0)
                                    @foreach ($penjualan->details as $detail)
                                        <tr>
                                            <td>{{ $detail->produk->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                                            <td>{{ $detail->JumlahProduk ?? 0 }}</td>
                                            <td>Rp{{ number_format($detail->produk->Harga ?? 0, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($detail->SubTotal ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Tidak ada data produk</td>
                                    </tr>
                                @endif
                            </tbody>

                            <tfoot>
                                <tr class="table-primary">
                                    <td colspan="3" class="text-end">Total Harga:</td>
                                    <td>Rp{{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary px-4 py-2" onclick="window.history.back();">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection