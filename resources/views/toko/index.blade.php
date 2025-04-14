@extends('layout.template')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-4">Profil Toko</h3>

            @if(session('success'))
                <div id="success-message" class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 5000);
                </script>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 20%">Nama Toko</th>
                            <td>{{ $profileToko->NamaToko ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pemilik</th>
                            <td>{{ $profileToko->Pemilik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $profileToko->Email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ $profileToko->No_Telp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $profileToko->Alamat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Logo</th>
                            <td>
                                @if ($profileToko && $profileToko->Logo)
                                    <img src="{{ asset('storage/' . $profileToko->Logo) }}" alt="Logo Toko" class="img-thumbnail" width="150">
                                @else
                                    <p class="text-muted">Belum ada logo</p>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-end">
                @if ($profileToko)
                    <a href="{{ route('toko.edit', $profileToko->TokoID) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                @else
                    <a href="{{ route('toko.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Profil
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
