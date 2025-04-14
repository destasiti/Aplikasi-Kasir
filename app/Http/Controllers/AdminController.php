<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class AdminController extends Controller
{public function index()
    {
        $today = Carbon::today();
    
        // Data penjualan bulanan (group by YEAR & MONTH)
        $penjualanBulanan = Penjualan::selectRaw('YEAR(TanggalPenjualan) as tahun, MONTH(TanggalPenjualan) as bulan, SUM(TotalHarga) as total_penjualan')
            ->groupBy('tahun', 'bulan')
            ->orderByRaw('tahun ASC, bulan ASC')
            ->get();
    
        // Siapkan label dan data untuk Chart.js
        $labels = [];
        $dataPenjualan = [];
        foreach ($penjualanBulanan as $pb) {
            // Contoh: 'March 2025'
            $labels[] = Carbon::createFromDate($pb->tahun, $pb->bulan, 1)->format('F Y');
            $dataPenjualan[] = $pb->total_penjualan;
        }
        $totalPenjualan = array_sum($dataPenjualan);
    
        // Ambil produk dengan stok ≤ 5
        $produkHampirHabis = Produk::where('Stok', '<=', 5)->get();
    
        // Produk kadaluarsa hari ini
        $produkKedaluwarsaHariIni = Produk::whereHas('stock_in', function ($query) use ($today) {
            $query->whereDate('Kedaluwarsa', $today);
        })->get();
        
        // Produk mendekati kadaluarsa (30 hari ke depan)
        $produkMenjelangKedaluwarsa = Produk::whereHas('stock_in', function ($query) use ($today) {
            $query->whereBetween('Kedaluwarsa', [$today, $today->copy()->addDays(30)]);
        })->get();
        
        $totalProduk = Produk::count();
        $totalPelanggan = Pelanggan::count();
        $totalKategori = Kategori::count();
        $totalTransaksi = Penjualan::count();
    
        // Ambil produk best seller
        $bestSellers = DB::table('detailpenjualan')
            ->select('ProdukID', DB::raw('SUM(JumlahProduk) as total_terjual'))
            ->groupBy('ProdukID')
            ->havingRaw('SUM(JumlahProduk) >= 5')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();
    
        $produkBestSeller = Produk::whereIn('ProdukID', $bestSellers->pluck('ProdukID'))->get();
    
        // Hitung kenaikan penjualan (bulan ini vs bulan lalu)
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->subMonth()->year;
    
        $totalPenjualanBulanIni = Penjualan::whereYear('TanggalPenjualan', $tahunIni)
            ->whereMonth('TanggalPenjualan', $bulanIni)
            ->sum('TotalHarga');
    
        $totalPenjualanBulanLalu = Penjualan::whereYear('TanggalPenjualan', $tahunLalu)
            ->whereMonth('TanggalPenjualan', $bulanLalu)
            ->sum('TotalHarga');
    
        $persentaseKenaikan = 0;
        if ($totalPenjualanBulanLalu > 0) {
            $persentaseKenaikan = (($totalPenjualanBulanIni - $totalPenjualanBulanLalu) / $totalPenjualanBulanLalu) * 100;
        } elseif ($totalPenjualanBulanIni > 0) {
            $persentaseKenaikan = 100;
        }
    
        // Kirim data ke view
        return view('admin.dashboard', compact(
            'labels',            // array label bulan ex: ['March 2025', 'April 2025']
            'dataPenjualan',     // array total penjualan per bulan
            'totalPenjualan',    // total semua penjualan (sum dataPenjualan)
            'totalTransaksi',
            'produkBestSeller',
            'bestSellers',
            'totalProduk',
            'totalKategori',
            'totalPelanggan',
            'produkHampirHabis',
            'produkKedaluwarsaHariIni',
            'produkMenjelangKedaluwarsa',
            'persentaseKenaikan',
            'totalPenjualanBulanIni'
        ));
    }
}    