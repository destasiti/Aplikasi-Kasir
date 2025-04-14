<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; 
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 48%;
            margin-right: 4%;
            box-sizing: border-box;
        }
        button:nth-child(2) {
            background-color: #6c757d;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:active {
            background-color: #004085;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: '100%'
            });
        });

        function formatRupiah(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }
    </script>
</head>
<body>
    <form action="{{ route('penjualan.update', $penjualan->PenjualanID) }}" method="POST">
        @csrf
        @method('PUT')
        <h1>Edit Penjualan</h1>

        <label for="TanggalPenjualan">Tanggal Penjualan</label>
        <input type="date" name="TanggalPenjualan" id="TanggalPenjualan" value="{{ old('TanggalPenjualan', $penjualan->TanggalPenjualan) }}" required>

        <label for="TotalHarga">Total Harga</label>
        <input type="text" id="TotalHarga" name="TotalHarga" value="{{ old('TotalHarga', $penjualan->TotalHarga) }}" onkeyup="formatRupiah(this)" required>

        <label for="PelangganID">Pelanggan</label>
        <select name="PelangganID" id="PelangganID" class="js-example-basic-single" required>
            @foreach ($pelanggan as $p)
                <option value="{{ $p->PelangganID }}" {{ $p->PelangganID == $penjualan->PelangganID ? 'selected' : '' }}>
                    {{ $p->NamaPelanggan }}
                </option>
            @endforeach
        </select>
&nbsp;
        <div class="button-container">
            <button type="submit">Update</button>
            <button type="button" onclick="window.location.href='{{ route('penjualan.index') }}'">Kembali</button>
        </div>
    </form>
</body>
</html>
