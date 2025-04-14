@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Pembayaran - Transaksi #{{ $penjualan->PenjualanID }}</h5>
                <small class="text-muted">Detail Pembelian</small>
            </div>
            <div class="card-body p-4">
                <!-- Informasi Penjualan -->
                <div class="mb-3">
                    <p><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) }}</p>
                    <p><strong>Pelanggan:</strong> {{ optional($penjualan->pelanggan)->NamaPelanggan ?? 'Non-Member' }}</p>
                </div>
                
                <!-- Rincian Pembelian -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $detail)
                            <tr>
                                <td>{{ optional($detail->produk)->NamaProduk ?? 'Produk Tidak Ditemukan' }}</td>
                                <td class="text-center">{{ $detail->JumlahProduk }}</td>
                                <td class="text-end">Rp {{ number_format(optional($detail->produk)->Harga ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($detail->JumlahProduk * (optional($detail->produk)->Harga ?? 0), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total Harga:</th>
                                <th class="text-end">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Form Pembayaran -->
                <form action="{{ route('pembayaran.store', $penjualan->PenjualanID) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="MetodeBayar" class="form-label">Metode Pembayaran</label>
                        <select name="MetodeBayar" id="MetodeBayar" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="JumlahBayar" class="form-label">Jumlah Dibayarkan</label>
                        <input type="text" class="form-control text-end" name="JumlahBayar" id="JumlahBayar" required>
                    </div>
                    <div class="mb-3">
                        <label for="Kembalian" class="form-label">Kembalian</label>
                        <input type="text" class="form-control text-end" id="Kembalian" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Bayar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jumlahDibayarkanInput = document.getElementById('JumlahBayar');
        const kembalianInput = document.getElementById('Kembalian');
        const totalHarga = parseInt("{{ $penjualan->TotalHarga }}");

        function formatRupiah(angka) {
            return angka.toLocaleString('id-ID');
        }

        function parseRupiah(value) {
            return parseInt(value.replace(/[^\d]/g, '')) || 0;
        }

        jumlahDibayarkanInput.addEventListener('input', function () {
            let jumlahDibayarkan = parseRupiah(this.value);
            this.value = formatRupiah(jumlahDibayarkan);

            let kembalian = jumlahDibayarkan - totalHarga;
            kembalianInput.value = kembalian < 0 ? "Pembayaran kurang!" : formatRupiah(kembalian);

        });
    });
</script>
@endsection
