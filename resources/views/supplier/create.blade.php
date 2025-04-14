@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Supplier Baru</h5>
                <small class="text-muted">Form Input Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Supplier -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaSupplier">Nama</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control @error('NamaSupplier') is-invalid @enderror"
                                    id="NamaSupplier" name="NamaSupplier" placeholder="Masukkan Nama"
                                    value="{{ old('NamaSupplier') }}" required>
                            </div>
                            @error('NamaSupplier')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Kontak">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" class="form-control @error('Kontak') is-invalid @enderror"
                                    id="Kontak" name="Kontak" placeholder="Masukkan Nomor Telepon"
                                    value="{{ old('Kontak') }}" required>
                            </div>
                            @error('Kontak')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Alamat">Alamat</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea class="form-control @error('Alamat') is-invalid @enderror"
                                    id="Alamat" name="Alamat" placeholder="Masukkan Alamat" required>{{ old('Alamat') }}</textarea>
                            </div>
                            @error('Alamat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Simpan & Kembali -->
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
    // Validasi input hanya angka untuk Nomor Telepon
    document.getElementById('Kontak').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi panjang nomor telepon sebelum submit
    document.querySelector('form').addEventListener('submit', function (e) {
        let Kontak = document.getElementById('Kontak').value.trim();
        if (Kontak.length < 10 || Kontak.length > 15) {
            alert('Nomor telepon harus antara 10-15 digit!');
            e.preventDefault();
        }
    });
</script>
@endsection
