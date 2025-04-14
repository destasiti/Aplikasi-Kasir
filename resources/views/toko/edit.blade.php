@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Profil Toko</h5>
                <small class="text-muted">Perbarui Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('toko.update', ['id' => $profileToko->TokoID]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        @method('PUT') <!-- atau bisa diganti PATCH -->
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaToko">Nama Toko</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-store"></i></span>
                                <input type="text" class="form-control" id="NamaToko" name="NamaToko" 
                                    value="{{ old('NamaToko', $profileToko->NamaToko) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Pemilik">Nama Pemilik</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control" id="Pemilik" name="Pemilik" 
                                    value="{{ old('Pemilik', $profileToko->Pemilik) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Email">Email</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                <input type="email" class="form-control" id="Email" name="Email" 
                                    value="{{ old('Email', $profileToko->Email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="No_Telp">No. Telepon</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="text" class="form-control" id="No_Telp" name="No_Telp" 
                                    value="{{ old('No_Telp', $profileToko->No_Telp) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Alamat">Alamat</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                <textarea class="form-control" id="Alamat" name="Alamat" required>{{ old('Alamat', $profileToko->Alamat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Logo">Logo Toko</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="Logo" name="Logo">
                            @if ($profileToko->Logo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $profileToko->Logo) }}" alt="Logo Toko" class="img-thumbnail" width="100">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Kembali</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
