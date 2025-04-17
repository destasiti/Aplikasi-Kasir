@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Tambah Produk Baru</h5>
                <small class="text-muted">Form Input Data</small>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaProduk">Nama Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-package"></i></span>
                                <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" placeholder="Masukkan Nama Produk" value="{{ old('NamaProduk') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Harga">Harga</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-money"></i></span>
                                <input type="text" class="form-control" id="Harga" name="Harga" placeholder="Masukkan Harga" value="{{ old('Harga') }}" onkeyup="formatRupiah(this)" required>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        function formatRupiah(input) {
                            let value = input.value.replace(/[^0-9]/g, '');
                            let formatted = new Intl.NumberFormat('id-ID').format(value);
                            input.value = formatted;
                        }
                    </script>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Kategori Produk</label>
                        <div class="col-sm-9">
                            <div class="d-flex align-items-center gap-2">
                                <span class="input-group-text bg-light"><i class="bx bx-list-ul"></i></span>
                                <select name="KategoriID" class="form-select produk-select w-100" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach ($kategori as $k)
                                    <option value="{{ $k->KategoriID }}" {{ old('KategoriID', $produk->KategoriID ?? '') == $k->KategoriID ? 'selected' : '' }}>
                                        {{ $k->NamaKategori }}
                                    </option>                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Foto Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-image"></i></span>
                                <input type="file" name="FotoProduk" class="form-control" accept="image/*">
                            </div>
                            @if ($errors->has('Foto'))
                                <div class="text-danger mt-1">{{ $errors->first('Foto') }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();"><i class="bx bx-arrow-back"></i> Kembali</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#KategoriID').select2({
            placeholder: "-- Pilih Kategori --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection