@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Pelanggan Baru</h5>
                <small class="text-muted">Form Input Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.store') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaPelanggan">Nama</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" placeholder="Masukkan Nama" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Alamat">Alamat</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea class="form-control" id="Alamat" name="Alamat" placeholder="Masukkan Alamat" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Email">Email</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" class="form-control" id="Email" name="Email" placeholder="Masukkan Email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NomorTelepon">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon" placeholder="Masukkan Nomor Telepon" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="JenisKelamin" id="JenisKelamin" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
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
    // Validasi Nomor Telepon agar hanya angka
    document.getElementById('NomorTelepon').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function validateForm() {
        let nama = document.getElementById('NamaPelanggan').value.trim();
        let alamat = document.getElementById('Alamat').value.trim();
        let nomorTelepon = document.getElementById('NomorTelepon').value.trim();
        let email = document.getElementById('Email').value.trim();
        let jenisKelamin = document.getElementById('JenisKelamin').value;

        if (nama === '' || alamat === '' || nomorTelepon === '' || email === '' || jenisKelamin === '') {
            alert('Semua field harus diisi!');
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
