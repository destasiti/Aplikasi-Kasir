@extends('layout.template')

@section('content')
    <div class="container mt-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-white">MANAJEMEN PRODUK</h5>
                    <small>Form tambah stok produk</small>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- FORM TAMBAH PEMBELIAN PRODUK -->
                    <form method="POST" action="{{ route('stock.in') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Pilih Produk -->
                            <div class="col-md-4">
                                <label for="ProdukID" class="fw-bold">Pilih Produk</label>
                                <select name="ProdukID" id="ProdukID" class="form-control select2" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->ProdukID }}">{{ $item->NamaProduk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih Supplier -->
                            <div class="col-md-4">
                                <label for="SupplierID" class="fw-bold">Pilih Supplier</label>
                                <select name="SupplierID" id="SupplierID" class="form-control select2" required>
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($supplier as $item)
                                        <option value="{{ $item->SupplierID }}">{{ $item->NamaSupplier }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <!-- Jumlah -->
                            <div class="col-md-4">
                                <label for="Jumlah" class="fw-bold">Jumlah</label>
                                <input type="number" name="Jumlah" id="Jumlah" min="1" class="form-control"
                                    placeholder="Masukkan jumlah" required>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- Harga Beli -->
                            <!-- Harga Beli -->
                            <div class="col-md-4">
                                <label for="HargaBeli" class="fw-bold">Harga Beli</label>
                                <input type="text" id="HargaBeli" class="form-control" placeholder="Rp 0"
                                    oninput="formatHarga()" required>
                                <input type="hidden" name="HargaBeli" id="HargaBeliHidden"> <!-- Ini dikirim ke backend -->
                                <small class="text-muted">Harga dalam Rupiah</small>
                            </div>



                            <!-- Tanggal Pembelian -->
                            <div class="col-md-4">
                                <label for="TanggalMasuk" class="fw-bold">Tanggal Pembelian</label>
                                <input type="date" name="TanggalMasuk" id="TanggalMasuk" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>

                            <!-- Tanggal Kedaluwarsa -->
                            <div class="col-md-4">
                                <label for="Kedaluwarsa" class="fw-bold">Tanggal Kedaluwarsa</label>
                                <input type="date" name="Kedaluwarsa" id="Kedaluwarsa" class="form-control" required>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function formatHarga() {
                    let inputHarga = document.getElementById("HargaBeli");
                    let hiddenInput = document.getElementById("HargaBeliHidden");

                    // Ambil hanya angka (tanpa Rp, titik, koma)
                    let angkaBersih = inputHarga.value.replace(/\D/g, "");

                    // Format angka ke Rp
                    let formatRupiah = angkaBersih ? "Rp " + new Intl.NumberFormat("id-ID").format(angkaBersih) : "Rp 0";

                    // Set kembali ke input tampilan
                    inputHarga.value = formatRupiah;

                    // Simpan angka ke input hidden
                    hiddenInput.value = angkaBersih || 0; // Jika kosong, kirim 0
                }
            </script>

            <!-- FORM PENCARIAN DAN DOWNLOAD PDF -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-white">RIWAYAT BELANJA PRODUK</h5>
                    <small>Riwayat belanja</small>
                </div>
                <div>
                    <div class="card-body">
                        <form action="{{ route('stock.search') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label for="tanggal_mulai" class="fw-bold">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_selesai" class="fw-bold">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-success me-2">Cari</button>
                                <a href="{{ route('stock.pdf', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}" class="btn btn-danger">Download PDF</a>
                            </div>
                        </form>
                    </div>
            
                    @if(request('tanggal_mulai') && request('tanggal_selesai'))
                        <div class="alert alert-info text-center mx-3">
                            Pencarian tanggal: <strong>{{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d-m-Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d-m-Y') }}</strong>
                        </div>
                    @endif
            
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="text-center bg-light">
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
                                    @forelse ($stockIns as $stock)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration + ($stockIns->currentPage() - 1) * $stockIns->perPage() }}</td>
                                            <td class="text-start">{{ $stock->produk->NamaProduk ?? 'Tidak Ditemukan' }}</td>
                                            <td class="text-start">{{ $stock->supplier->NamaSupplier ?? 'Tidak Ditemukan' }}</td>
                                            <td>{{ $stock->Jumlah }}</td>                                            <td>Rp {{ number_format($stock->HargaBeli, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($stock->TanggalMasuk)->format('d-m-Y') }}</td>
                                            <td class="{{ \Carbon\Carbon::parse($stock->Kedaluwarsa)->isPast() ? 'bg-danger text-white' : '' }}">
                                                {{ \Carbon\Carbon::parse($stock->Kedaluwarsa)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-danger fw-bold">Tidak ada data yang tampil sesuai tanggal</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            {{ $stockIns->links('pagination::bootstrap-4') }}
                            <p class="mt-2">Menampilkan {{ $stockIns->count() }} dari {{ $stockIns->total() }} data</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SCRIPT SELECT2 & FORMAT RUPIAH -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        placeholder: "Pilih opsi...",
                        allowClear: true
                    });

                    // Format Rupiah pada input harga beli
                    $('#HargaBeli').on('input', function() {
                        let angka = $(this).val().replace(/[^,\d]/g, ''); // Hanya angka
                        $(this).val(formatRupiah(angka, 'Rp '));
                    });

                    function formatRupiah(angka, prefix) {
                        let number_string = angka.replace(/[^,\d]/g, '').toString(),
                            split = number_string.split(','),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                        if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }

                        return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
                    }
                });

                function cleanHargaBeli() {
                    let hargaBeliInput = document.getElementById('HargaBeli');
                    hargaBeliInput.value = hargaBeliInput.value.replace(/\D/g, ''); // Hapus semua karakter kecuali angka
                }
            </script>
        </div><p>&nbsp;<p>
        @endsection
