@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Pelanggan</h5>
                <small class="text-muted">Form Edit Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaPelanggan">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Alamat">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="Alamat" name="Alamat" required>{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Email">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="Email" name="Email" value="{{ old('Email', $pelanggan->Email) }}" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NomorTelepon">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="JenisKelamin" name="JenisKelamin" required>
                                <option value="laki-laki" {{ old('JenisKelamin', $pelanggan->JenisKelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('JenisKelamin', $pelanggan->JenisKelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
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
    document.getElementById('NomorTelepon').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function validateForm() {
        let email = document.getElementById('Email').value.trim();
        let nomorTelepon = document.getElementById('NomorTelepon').value.trim();

        if (!email.includes('@') || !email.includes('.')) {
            alert('Format email tidak valid!');
            return false;
        }
        if (nomorTelepon.length < 10 || nomorTelepon.length > 15) {
            alert('Nomor telepon harus antara 10-15 digit!');
            return false;
        }
        return true;
    }
</script>
@endsection
