@extends('layout.template')

<!-- Tambahkan jQuery dan Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Detail Penjualan</h5>
                <small class="text-muted">Form Tambah Data</small>
            </div>
            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Kasir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="TanggalPenjualan">Tanggal Transaksi</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="TanggalPenjualan" name="TanggalPenjualan"
                                value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Jenis Pelanggan</label>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="JenisPelanggan" id="member"
                                    value="member" checked>
                                <label class="form-check-label" for="member">Member</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="JenisPelanggan" id="non_member"
                                    value="non_member">
                                <label class="form-check-label" for="non_member">Non-Member</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row" id="PelangganField">
                        <label class="col-sm-3 col-form-label" for="PelangganID">Pilih Pelanggan</label>
                        <div class="col-sm-9">
                            <select class="form-select select2" id="PelangganID" name="PelangganID">
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($pelanggan as $p)
                                    <option value="{{ $p->PelangganID }}">{{ $p->NamaPelanggan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const memberRadio = document.getElementById("member");
                            const nonMemberRadio = document.getElementById("non_member");
                            const pelangganField = document.getElementById("PelangganField");

                            function togglePelangganField() {
                                pelangganField.style.display = memberRadio.checked ? "flex" : "none";
                            }

                            memberRadio.addEventListener("change", togglePelangganField);
                            nonMemberRadio.addEventListener("change", togglePelangganField);
                            togglePelangganField();
                        });
                    </script>

                    <h5 class="mt-4">Daftar Produk</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="produkBody"></tbody>
                    </table>

                    <button type="button" class="btn btn-success mb-3" id="tambahProduk">Tambah Produk</button>

                    <div class="total-harga mb-3 text-end">
                        <strong>Total Harga: <span id="TotalHarga">0</span></strong>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Kembali</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
            placeholder: "-- Pilih --",
            allowClear: true
        });

        const produkBody = document.getElementById("produkBody");
        const tambahProdukBtn = document.getElementById("tambahProduk");
        const totalHargaSpan = document.getElementById("TotalHarga");
        const produkList = @json($produk);

        function formatRupiah(angka) {
            return "Rp " + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(angka);
        }

        function hitungTotal() {
            let totalHarga = 0;
            document.querySelectorAll(".subTotalInput").forEach(input => {
                totalHarga += parseInt(input.dataset.value) || 0;
            });
            totalHargaSpan.textContent = formatRupiah(totalHarga);
        }

        function buatBarisProduk() {
            const row = document.createElement("tr");
            let options = `<option value="">-- Pilih Produk --</option>`;
            produkList.forEach(prod => {
                if (prod.Stok > 0) {
                    options += `<option value="${prod.ProdukID}" data-harga="${prod.Harga}" data-stok="${prod.Stok}">${prod.NamaProduk}</option>`;
                } else {
                    options += `<option value="" disabled>${prod.NamaProduk} (Stok Habis)</option>`;
                }
            });

            row.innerHTML = `
                <td><select class="form-select produkSelect select2" name="ProdukID[]" required>${options}</select></td>
                <td><input type="text" class="form-control hargaProduk" name="HargaProduk[]" readonly></td>
                <td><input type="number" class="form-control jumlahInput" name="JumlahProduk[]" min="1" value="0" required></td>
                <td><input type="text" class="form-control subTotalInput" readonly data-value="0"></td>
                <td><button type="button" class="btn btn-danger hapusBaris">Hapus</button></td>
            `;

            produkBody.appendChild(row);

            $(row).find('.select2').select2({ width: '100%', placeholder: "-- Pilih Produk --", allowClear: true });

            row.querySelector(".produkSelect").addEventListener("change", function () {
                hitungSubtotal(row);
            });
            row.querySelector(".jumlahInput").addEventListener("input", function () {
                hitungSubtotal(row);
            });
            row.querySelector(".hapusBaris").addEventListener("click", function () {
                row.remove();
                hitungTotal();
            });
        }

        function hitungSubtotal(row) {
            const produkSelect = row.querySelector(".produkSelect");
            const hargaInput = row.querySelector(".hargaProduk");
            const jumlahInput = row.querySelector(".jumlahInput");
            const subTotalInput = row.querySelector(".subTotalInput");
            const hargaProduk = produkSelect.options[produkSelect.selectedIndex].dataset.harga || 0;
            const stokProduk = produkSelect.options[produkSelect.selectedIndex].dataset.stok || 0;

            hargaInput.value = formatRupiah(hargaProduk);

            if (stokProduk == 0) {
                alert("Stok habis!");
                jumlahInput.value = "";
                subTotalInput.value = "";
                return;
            }

            jumlahInput.setAttribute("max", stokProduk);
            const jumlahProduk = jumlahInput.value ? parseInt(jumlahInput.value) : 0;
            const subTotal = hargaProduk * jumlahProduk;
            subTotalInput.value = formatRupiah(subTotal);
            subTotalInput.dataset.value = subTotal;
            hitungTotal();
        }

        // Tambahkan satu baris produk saat halaman dimuat
        buatBarisProduk();

        tambahProdukBtn.addEventListener("click", buatBarisProduk);
    });
</script>
@endsection
