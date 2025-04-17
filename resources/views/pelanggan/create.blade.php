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
                        <label class="col-sm-3 col-form-label" for="Alamat">Alamat Lengkap</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea class="form-control" id="Alamat" name="Alamat" placeholder="Masukkan Alamat Lengkap (Jalan, RT/RW, dll)" required></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Provinsi -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="province_id">Provinsi</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="province_id" id="province_id" required>
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Kabupaten/Kota -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="regency_id">Kabupaten/Kota</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="regency_id" id="regency_id" required disabled>
                                <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Kecamatan -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="district_id">Kecamatan</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="district_id" id="district_id" required disabled>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Desa/Kelurahan -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="village_id">Desa/Kelurahan</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="village_id" id="village_id" required disabled>
                                <option value="" disabled selected>Pilih Desa/Kelurahan</option>
                            </select>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Validasi Nomor Telepon agar hanya angka
    document.getElementById('NomorTelepon').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function validateForm() {
        let nama = document.getElementById('NamaPelanggan').value.trim();
        let alamat = document.getElementById('Alamat').value.trim();
        let provinsi = document.getElementById('province_id').value;
        let kabupaten = document.getElementById('regency_id').value;
        let kecamatan = document.getElementById('district_id').value;
        let desa = document.getElementById('village_id').value;
        let nomorTelepon = document.getElementById('NomorTelepon').value.trim();
        let email = document.getElementById('Email').value.trim();
        let jenisKelamin = document.getElementById('JenisKelamin').value;

        if (nama === '' || alamat === '' || provinsi === '' || kabupaten === '' || 
            kecamatan === '' || desa === '' || nomorTelepon === '' || email === '' || jenisKelamin === '') {
            alert('Semua field harus diisi!');
            return false;
        }
        if (nomorTelepon.length < 10 || nomorTelepon.length > 15) {
            alert('Nomor telepon harus antara 10-15 digit!');
            return false;
        }
        return true;
    }

    // Mendapatkan data kabupaten ketika provinsi dipilih
    $(document).ready(function() {
        $('#province_id').on('change', function() {
            let provinceId = $(this).val();
            if(provinceId) {
                $.ajax({
                    url: '{{ route("regencies") }}',
                    type: "GET",
                    data : {"province_id": provinceId},
                    dataType: "json",
                    success: function(data) {
                        $('#regency_id').empty();
                        $('#regency_id').removeAttr('disabled');
                        $('#regency_id').append('<option value="" disabled selected>Pilih Kabupaten/Kota</option>');
                        $.each(data, function(key, value) {
                            $('#regency_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        // Reset kecamatan dan desa
                        $('#district_id').empty();
                        $('#district_id').attr('disabled', 'disabled');
                        $('#district_id').append('<option value="" disabled selected>Pilih Kecamatan</option>');
                        $('#village_id').empty();
                        $('#village_id').attr('disabled', 'disabled');
                        $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
                    }
                });
            } else {
                $('#regency_id').empty();
                $('#regency_id').attr('disabled', 'disabled');
                $('#regency_id').append('<option value="" disabled selected>Pilih Kabupaten/Kota</option>');
                $('#district_id').empty();
                $('#district_id').attr('disabled', 'disabled');
                $('#district_id').append('<option value="" disabled selected>Pilih Kecamatan</option>');
                $('#village_id').empty();
                $('#village_id').attr('disabled', 'disabled');
                $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
            }
        });

        // Mendapatkan data kecamatan ketika kabupaten dipilih
        $('#regency_id').on('change', function() {
            let regencyId = $(this).val();
            if(regencyId) {
                $.ajax({
                    url: '{{ route("districts") }}',
                    type: "GET",
                    data : {"regency_id": regencyId},
                    dataType: "json",
                    success: function(data) {
                        $('#district_id').empty();
                        $('#district_id').removeAttr('disabled');
                        $('#district_id').append('<option value="" disabled selected>Pilih Kecamatan</option>');
                        $.each(data, function(key, value) {
                            $('#district_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                        // Reset desa
                        $('#village_id').empty();
                        $('#village_id').attr('disabled', 'disabled');
                        $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
                    }
                });
            } else {
                $('#district_id').empty();
                $('#district_id').attr('disabled', 'disabled');
                $('#district_id').append('<option value="" disabled selected>Pilih Kecamatan</option>');
                $('#village_id').empty();
                $('#village_id').attr('disabled', 'disabled');
                $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
            }
        });

        // Mendapatkan data desa ketika kecamatan dipilih
        $('#district_id').on('change', function() {
            let districtId = $(this).val();
            if(districtId) {
                $.ajax({
                    url: '{{ route("villages") }}',
                    type: "GET",
                    data : {"district_id": districtId},
                    dataType: "json",
                    success: function(data) {
                        $('#village_id').empty();
                        $('#village_id').removeAttr('disabled');
                        $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
                        $.each(data, function(key, value) {
                            $('#village_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            } else {
                $('#village_id').empty();
                $('#village_id').attr('disabled', 'disabled');
                $('#village_id').append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
            }
        });
    });
</script>
@endsection