
            <!-- FORM BARANG KELUAR -->
            <div class="mb-4">
                <h5>Tambah Barang Keluar</h5>
                <form method="POST" action="{{ route('stock.out') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <select name="ProdukID" class="form-control" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produk as $item)
                                <option value="{{ $item->ProdukID }}">{{ $item->NamaProduk }}</option>
                            @endforeach
                            
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="Jumlah" class="form-control" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="HargaJual" class="form-control" placeholder="Harga Jual" required>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="TanggalKeluar" class="form-control" required>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button type="submit" class="btn btn-danger">Kurangi Stok</button>
                        </div>
                    </div>
                </form>
            </div>
