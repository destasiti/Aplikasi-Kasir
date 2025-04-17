@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Data Pelanggan</h5>
                <small class="text-muted">Form Edit Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaPelanggan">Nama</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control" id="NamaPelanggan" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Email">Email</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" class="form-control" id="Email" name="Email" value="{{ old('Email', $pelanggan->Email) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NomorTelepon">Nomor Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" class="form-control" id="NomorTelepon" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="JenisKelamin" id="JenisKelamin" required>
                                <option value="" disabled>Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ $pelanggan->JenisKelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ $pelanggan->JenisKelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="province_id">Provinsi</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="province_id" id="province_id" required>
                                <option value="" disabled>Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ $pelanggan->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                  <!-- Kabupaten/Kota -->
<div class="mb-3 row">
    <label class="col-sm-3 col-form-label" for="regency_id">Kabupaten/Kota</label>
    <div class="col-sm-9">
        <select class="form-select" name="regency_id" id="regency_id" required>
            <option value="" disabled>Pilih Kabupaten/Kota</option>
            @if(isset($regencies) && count($regencies) > 0)
                @foreach($regencies as $regency)
                    <option value="{{ $regency->id }}" {{ $pelanggan->regency_id == $regency->id ? 'selected' : '' }}>{{ $regency->name }}</option>
                @endforeach
            @endif
        </select>                            
    </div>
</div>

                    <!-- Kecamatan -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="district_id">Kecamatan</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="district_id" id="district_id" required>
                                <option value="" disabled>Pilih Kecamatan</option>
                                @if(isset($districts) && count($districts) > 0)
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ $pelanggan->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>                            
                        </div>
                    </div>

                    <!-- Desa/Kelurahan -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="village_id">Desa/Kelurahan</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="village_id" id="village_id" required>
                                <option value="" disabled>Pilih Desa/Kelurahan</option>
                                @if(isset($villages) && count($villages) > 0)
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}" {{ $pelanggan->village_id == $village->id ? 'selected' : '' }}>{{ $village->name }}</option>
                                    @endforeach
                                @endif
                            </select>                            
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Alamat">Detail Alamat</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea class="form-control" id="Alamat" name="Alamat" required>{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle dynamic loading of regencies, districts, and villages based on selection
    $('#province_id').on('change', function() {
    let provinceId = $(this).val();
    if (provinceId) {
        $.ajax({
            url: '{{ route("regencies") }}',
            type: "GET",
            data: { "province_id": provinceId },
            dataType: "json",
            success: function(data) {
                $('#regency_id').empty().append('<option value="" disabled selected>Pilih Kabupaten/Kota</option>');
                $.each(data, function(key, value) {
                    $('#regency_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
                $('#district_id').empty().append('<option value="" disabled selected>Pilih Kecamatan</option>');
                $('#village_id').empty().append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
            }
        });
    }
});

$('#regency_id').on('change', function() {
    let regencyId = $(this).val();
    if (regencyId) {
        $.ajax({
            url: '{{ route("districts") }}',
            type: "GET",
            data: { "regency_id": regencyId },
            dataType: "json",
            success: function(data) {
                $('#district_id').empty().append('<option value="" disabled selected>Pilih Kecamatan</option>');
                $.each(data, function(key, value) {
                    $('#district_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
                $('#village_id').empty().append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
            }
        });
    }
});

    $('#district_id').on('change', function() {
        let districtId = $(this).val();
        if (districtId) {
            $.ajax({
                url: '{{ route("villages") }}',
                type: "GET",
                data: { "district_id": districtId },
                dataType: "json",
                success: function(data) {
                    $('#village_id').empty().append('<option value="" disabled selected>Pilih Desa/Kelurahan</option>');
                    $.each(data, function(key, value) {
                        $('#village_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        }
    });
});

function validateForm() {
    // Basic form validation
    let province = document.getElementById('province_id').value;
    let city = document.getElementById('city_id').value;
    let district = document.getElementById('district_id').value;
    let village = document.getElementById('village_id').value;
    
    if (!province || !city || !district || !village) {
        alert('Silakan pilih semua data lokasi (Provinsi, Kabupaten/Kota, Kecamatan, dan Desa/Kelurahan)');
        return false;
    }
    return true;
}
</script>
@endsection