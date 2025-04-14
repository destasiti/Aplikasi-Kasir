@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Kategori</h5>
                <small class="text-muted">Form Input Data</small>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaKategori">Nama Kategori</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-folder"></i></span>
                                <input type="text" class="form-control" id="NamaKategori" name="NamaKategori" placeholder="Masukkan Nama Kategori" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Deskripsi">Deskripsi</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-info-circle"></i></span>
                                <textarea class="form-control" id="Deskripsi" name="Deskripsi" placeholder="Masukkan Deskripsi" required></textarea>
                            </div>
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
@endsection