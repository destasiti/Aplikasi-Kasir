@component('mail::message')
# Terima Kasih Telah Berbelanja di {{ $profileToko->NamaToko ?? 'Toko Kami' }}!

Halo {{ $penjualan->pelanggan->NamaPelanggan ?? 'Pelanggan' }},

Kami telah menerima pembayaran Anda dengan detail sebagai berikut:

---

**Tanggal Penjualan:** {{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d M Y') }}  
**Metode Pembayaran:** {{ $pembayaran->MetodeBayar }}  
**Status Pembayaran:** {{ $pembayaran->StatusBayar }}  
**Total Bayar:** Rp {{ number_format($pembayaran->JumlahBayar, 0, ',', '.') }}  
**Kembalian:** Rp {{ number_format($pembayaran->Kembalian, 0, ',', '.') }}

---

## Rincian Barang:

@foreach ($penjualan->details as $detail)
- {{ $detail->produk->NamaProduk ?? '-' }} x {{ $detail->JumlahProduk }}  
  @ Rp {{ number_format($detail->produk->Harga ?? 0, 0, ',', '.') }}  
@endforeach

---

@if ($profileToko && $profileToko->Alamat)
**Alamat Toko:**  
{{ $profileToko->Alamat }}  
@endif

Jika Anda memiliki pertanyaan, silakan hubungi kami di  
📞 {{ $profileToko->No_Telp ?? '-' }}  
📧 {{ $profileToko->Email ?? '-' }}

Terima kasih telah menjadi pelanggan kami!

Salam,  
**{{ $profileToko->NamaToko ?? 'Kasir SMK Industri' }}**

@endcomponent
