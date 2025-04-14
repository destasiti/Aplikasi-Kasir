@extends('layout.template')

@section('content')
<div class="container">
    <h2>Tambah Transaksi</h2>
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="PenjualanID" value="{{ $penjualan->PenjualanID }}">
        <div class="form-group">
            <label for="MetodeBayar">Metode Pembayaran:</label>
            <select name="MetodeBayar" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="E-Wallet">E-Wallet</option>
                <option value="Kredit">Kredit</option>
            </select>
        </div>
        <div class="form-group">
            <label for="JumlahBayar">Jumlah Bayar:</label>
            <input type="number" name="JumlahBayar" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
