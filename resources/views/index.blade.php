<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Detail Penjualan</title>
    
    <!-- CSS Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .card {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 600px;
            margin: auto;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .form-container {
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .total-harga {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        .button-container {
            margin-top: 10px;
        }
        button {
            padding: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card">
    <h3>Tambah Detail Penjualan</h3>
    <div class="form-container">
        <form action="#" method="POST">
            <label for="TanggalPenjualan">Tanggal Transaksi</label>
            <input type="date" id="TanggalPenjualan" value="<?= date('Y-m-d') ?>" readonly><br><br>

            <label for="PelangganID">Pilih Pelanggan:</label>
            <select id="PelangganID" class="form-select select2" required>
                <option value="">-- Pilih Pelanggan --</option>
                <option value="1">Andi</option>
                <option value="2">Budi</option>
                <option value="3">Citra</option>
            </select>

            <h4>Daftar Produk</h4>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produkBody"></tbody>
            </table>

            <button type="button" id="tambahProduk">Tambah Produk</button>

            <div class="total-harga">Total Harga: <span id="TotalHarga">0</span></div>

            <div class="button-container">
                <button type="submit">Simpan</button>
                <button type="button" onclick="window.history.back()">Kembali</button>
            </div>
        </form>
    </div>
</div>

<!-- JQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk pelanggan
        $('.select2').select2({
            placeholder: "Cari...",
            allowClear: true,
            width: '100%'
        });

        const produkBody = $("#produkBody");
        const tambahProdukBtn = $("#tambahProduk");
        const totalHargaSpan = $("#TotalHarga");

        function hitungTotal() {
            let totalHarga = 0;
            $(".subTotalInput").each(function() {
                totalHarga += parseInt($(this).val().replace(/\./g, '') || 0);
            });
            totalHargaSpan.text(totalHarga.toLocaleString('id-ID'));
        }

        function buatBarisProduk() {
            const row = $(`
            <tr>
                <td>
                    <select class="produkSelect form-select" required>
                        <option value="">-- Pilih Produk --</option>
                        <option value="1" data-harga="10000">Pensil</option>
                        <option value="2" data-harga="20000">Buku</option>
                        <option value="3" data-harga="5000">Penghapus</option>
                    </select>
                </td>
                <td><input type="number" class="jumlahInput" min="1" required></td>
                <td><input type="text" class="subTotalInput" readonly required></td>
                <td><button type="button" class="hapusBaris">Hapus</button></td>
            </tr>
            `);

            produkBody.append(row);

            // Inisialisasi Select2 untuk dropdown produk yang baru ditambahkan
            row.find(".produkSelect").select2({
                placeholder: "-- Pilih Produk --",
                allowClear: true,
                width: '100%'
            });

            attachEvents(row);
        }

        function attachEvents(row) {
            row.find(".produkSelect").on("change", function() { hitungSubtotal(row); });
            row.find(".jumlahInput").on("input", function() { hitungSubtotal(row); });
            row.find(".hapusBaris").on("click", function() {
                row.remove();
                hitungTotal();
            });
        }

        function hitungSubtotal(row) {
            const produkSelect = row.find(".produkSelect");
            const jumlahInput = row.find(".jumlahInput");
            const subTotalInput = row.find(".subTotalInput");

            const hargaProduk = produkSelect.find(":selected").data("harga") || 0;
            const jumlahProduk = jumlahInput.val() || 0;
            const subTotal = hargaProduk * jumlahProduk;
            subTotalInput.val(subTotal.toLocaleString('id-ID'));

            hitungTotal();
        }

        tambahProdukBtn.on("click", buatBarisProduk);
    });
</script>

</body>
</html>
