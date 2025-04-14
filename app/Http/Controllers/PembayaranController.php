<?php

namespace App\Http\Controllers;
use App\Mail\NotifikasiPembayaran;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Models\Toko;

use App\Models\Pembayaran;
use App\Models\Penjualan;

class PembayaranController extends Controller
{
    /**
     * Menampilkan daftar pembayaran.
     */
    public function index()
    {
        $pembayaran = Pembayaran::with('penjualan')->get();
        return view('pembayaran.index', compact('pembayaran'));
    }

    /**
     * Menampilkan form pembayaran baru untuk transaksi tertentu.
     */
    public function create($id)
    {
        $penjualan = Penjualan::with('details.produk', 'pelanggan')->findOrFail($id);
        return view('pembayaran.create', compact('penjualan'));
    }

    /**
     * Menyimpan pembayaran baru dan mengarahkan ke halaman struk.
     */


public function store(Request $request, $penjualanId)
{
    $request->validate([
        'MetodeBayar' => 'required|in:Cash,Transfer,E-Wallet,Kredit',
        'JumlahBayar' => 'required|string',
    ]);

    $penjualan = Penjualan::findOrFail($penjualanId);
    $totalHarga = $penjualan->TotalHarga;

    $jumlahBayar = (float) str_replace('.', '', $request->JumlahBayar);
    $kembalian = max($jumlahBayar - $totalHarga, 0);
    $statusBayar = $jumlahBayar >= $totalHarga ? 'Lunas' : 'Belum Lunas';

    $pembayaran = Pembayaran::create([
        'PenjualanID'  => $penjualan->PenjualanID,
        'MetodeBayar'  => $request->MetodeBayar,
        'JumlahBayar'  => $jumlahBayar,
        'Kembalian'    => $kembalian,
        'StatusBayar'  => $statusBayar,
    ]);

    // Ambil data toko dari tabel profile_toko (model Toko)
    $profileToko = Toko::first(); // kalau cuma 1 toko

    // Kirim email
    if ($penjualan->PelangganID && $penjualan->pelanggan->Email && $profileToko) {
        Mail::to($penjualan->pelanggan->Email)->send(new NotifikasiPembayaran($penjualan, $pembayaran, $profileToko));
    }

    return redirect()->route('pembayaran.struk', ['id' => $pembayaran->PembayaranID])->with('success', 'Pembayaran berhasil!');
}

    

    /**
     * Menampilkan halaman struk pembayaran.
     * 
     */public function struk($id)
{
    $pembayaran = Pembayaran::with('penjualan.details.produk', 'penjualan.pelanggan')->findOrFail($id);
    $penjualan = $pembayaran->penjualan;
    $profileToko = Toko::first();

    return view('pembayaran.struk', compact('penjualan', 'pembayaran', 'profileToko'));
}

    

    /**
     * Menampilkan detail pembayaran tertentu.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Menampilkan form edit pembayaran.
     */
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $penjualan = Penjualan::all();
        return view('pembayaran.edit', compact('pembayaran', 'penjualan'));
    }

    /**
     * Memperbarui data pembayaran.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'JumlahBayar' => 'required|numeric|min:0',
            'MetodeBayar' => 'required|in:Cash,Transfer,E-Wallet,Kredit',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $totalHarga = $pembayaran->penjualan->TotalHarga;
        $jumlahBayar = $request->JumlahBayar;
        $kembalian = max($jumlahBayar - $totalHarga, 0);
        $statusBayar = $jumlahBayar >= $totalHarga ? 'Lunas' : 'Belum Lunas';

        $pembayaran->update([
            'JumlahBayar'  => $jumlahBayar,
            'Kembalian'    => $kembalian,
            'MetodeBayar'  => $request->MetodeBayar,
            'StatusBayar'  => $statusBayar,
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    /**
     * Menghapus pembayaran.
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
