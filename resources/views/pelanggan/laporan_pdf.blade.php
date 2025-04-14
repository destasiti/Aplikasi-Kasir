<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pelanggan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Pelanggan</h2>

    @if($pelanggan->isEmpty())
        <p>Tidak ada data pelanggan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan->sortBy('NamaPelanggan')->values() as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Nomor urut dimulai dari 1 -->
                    <td>{{ ucwords($p->NamaPelanggan) }}</td>
                    <td>{{ $p->Email }}</td>
                    <td>{{ $p->NomorTelepon }}</td>
                    <td>{{ ucwords($p->Alamat) }}</td>
                    <td>{{ ucfirst($p->JenisKelamin) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
