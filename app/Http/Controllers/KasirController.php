<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalPelanggan = Pelanggan::count();
        $totalKategori = Kategori::count();
        $totalTransaksi = Penjualan::count();

    // Ambil produk best seller dengan minimal 5 pembelian
    $bestSellers = DB::table('detailpenjualan')
    ->select('ProdukID', DB::raw('SUM(JumlahProduk) as total_terjual'))
    ->groupBy('ProdukID')
    ->havingRaw('SUM(JumlahProduk) >= 5') // Hanya ambil yang terjual minimal 5 kali
    ->orderByDesc('total_terjual')
    ->limit(5) // Ambil maksimal 5 produk terbaik
    ->get();
    
    // Ambil detail produk berdasarkan ProdukID yang sudah difilter
    $produkBestSeller = Produk::whereIn('ProdukID', $bestSellers->pluck('ProdukID'))->get();
    
    $produkHampirHabis = Produk::where('Stok', '<=', 5)->get();

        return view('kasir.dashboard', compact(
            'produkHampirHabis','bestSellers','produkBestSeller','totalProduk', 'totalPelanggan', 'totalKategori', 'totalTransaksi'
        ));
    }
}
