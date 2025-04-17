@extends('layout.template')

@section('content')
<div class="d-flex justify-content-center mt-5"> 
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Edit Produk</h5>
                <small class="text-muted">Form Edit Data</small>
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

                <form action="{{ route('produk.update', $produk->ProdukID) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="NamaProduk">Nama Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-package"></i></span>
                                <input type="text" class="form-control" id="NamaProduk" name="NamaProduk" value="{{ old('NamaProduk', $produk->NamaProduk) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Harga">Harga</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-money"></i></span>
                                <input type="text" class="form-control" id="Harga" name="Harga" value="{{ old('Harga', number_format($produk->Harga, 0, ',', '.')) }}" onkeyup="formatRupiah(this)" required>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="Stok">Stok</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-layer"></i></span>
                                <input type="number" class="form-control" id="Stok" name="Stok" value="{{ old('Stok', $produk->Stok) }}" required>
                            </div>
                        </div>
                    </div> --}}
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label d-flex align-items-center" for="KategoriID">Kategori Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-list-ul"></i></span>
                                <select name="KategoriID" id="KategoriID" class="form-select select2" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->KategoriID }}" {{ old('KategoriID', $produk->KategoriID ?? '') == $k->KategoriID ? 'selected' : '' }}>
                                            {{ $k->NamaKategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Foto Produk</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bx bx-image"></i></span>
                                <input type="file" name="FotoProduk" class="form-control" accept="image/*">
                            </div>
                            @if ($produk->FotoProduk)
                                <img src="{{ asset('storage/' . $produk->FotoProduk) }}" alt="Foto Produk Lama" width="150" class="img-thumbnail">
                            @endif
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
    function formatRupiah(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }
</script>
@endsection
