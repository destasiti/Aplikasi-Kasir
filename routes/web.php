<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Routes accessible without authentication.
|
*/use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\User;



Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin/dashboard'); // Sesuaikan dengan role
    }

    $produks = Produk::latest()->get();

    // Menghitung jumlah data dari tabel terkait
    $jumlah_penjualan = Penjualan::count() ?? 0;
    $jumlah_pelanggan = Pelanggan::count() ?? 0;
    $jumlah_produk = Produk::count() ?? 0;
    $jumlah_user = User::count() ?? 0;

    return view('welcome', compact('produks', 'jumlah_penjualan', 'jumlah_pelanggan', 'jumlah_produk', 'jumlah_user'));
});

    
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/kasir/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');

    // Laporan Routes
    Route::get('/laporan/penjualan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak');
    Route::get('/laporan/pelanggan', [LaporanController::class, 'cetakPelanggan'])->name('laporan.pelanggan');

    // Pembayaran Routes
    Route::get('/pelanggan/export-pdf', [PelangganController::class, 'exportPdf'])->name('pelanggan.exportPdf');
    Route::get('/penjualan/pdf', [PenjualanController::class, 'cetakPDF'])->name('penjualan.pdf');
    Route::get('/pembayaran/create/{id}', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran/store/{penjualanId}', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/struk/{id}', [PembayaranController::class, 'struk'])->name('pembayaran.struk');
    Route::get('/produk/sync-stock/{id?}', [ProdukController::class, 'syncStock'])->name('produk.syncStock');

    // Resource Routes (CRUD)
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('penjualan', PenjualanController::class);

    // Stock Routes
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/search', [StockController::class, 'search'])->name('stock.search');
    Route::get('/stock/pdf', [StockController::class, 'downloadPDF'])->name('stock.pdf');
    Route::post('/stock/in', [StockController::class, 'storeStockIn'])->name('stock.in');
    Route::post('/stock/out', [StockController::class, 'storeStockOut'])->name('stock.out');

    // Toko Routes
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
    Route::get('/toko/create', [TokoController::class, 'create'])->name('toko.create');
    Route::post('/toko/store', [TokoController::class, 'store'])->name('toko.store');
    Route::get('/toko/edit/{id}', [TokoController::class, 'edit'])->name('toko.edit');
    Route::put('/toko/update/{id}', [TokoController::class, 'update'])->name('toko.update');

    // User Routes
    Route::get('/kasir/create', [UserController::class, 'createKasir'])->name('kasir.create');
    Route::post('/kasir/store', [UserController::class, 'storeKasir'])->name('kasir.store');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Tambahkan route berikut ke routes/web.php

// Route untuk sinkronisasi stok (satu produk atau semua)
Route::get('/produk/sync-stock/{id?}', [ProdukController::class, 'syncStock'])->name('produk.syncStock');
Route::get('/kasir/create', [UserController::class, 'createKasir'])->name('kasir.create');
Route::post('/kasir/store', [UserController::class, 'storeKasir'])->name('kasir.store');
Route::get('produk/cek-kedaluwarsa', [ProdukController::class, 'cekKedaluwarsa'])->name('produk.cek_kedaluwarsa');
// Route::post('/produk/{id}/update-stok', [ProdukController::class, 'updateStok'])->name('produk.updateStok');
// Route::delete('/barang-keluar/{id}', [StockOutController::class, 'destroy'])->name('stock_out.destroy');
// Route::get('/barang-keluar', [StockOutController::class, 'index'])->name('stock_out.index');
// Route::get('/barang-keluar/create', [StockOutController::class, 'create'])->name('stock_out.create');
// Route::post('/barang-keluar', [StockOutController::class, 'store'])->name('stock_out.store');
Route::post('/produk/pindah-ke-stock-out', [ProdukController::class, 'pindahKeStockOut'])->name('produk.pindahKeStockOut');
Route::get('/stock-out', [StockOutController::class, 'index'])->name('stock_out.index');
Route::get('/stock-out/create', [StockOutController::class, 'create'])->name('stock_out.create');
Route::post('/stock-out', [StockOutController::class, 'store'])->name('stock_out.store');
Route::delete('/stock-out/{id}', [StockOutController::class, 'destroy'])->name('stock_out.destroy');
Route::put('/kasir/reset/{id}', [UserController::class, 'resetPassword'])->name('kasir.reset');
// Routes untuk IndoRegion// routes/web.php
Route::get('/regencies', [PelangganController::class, 'getRegencies'])->name('regencies');
Route::get('/districts', [PelangganController::class, 'getDistricts'])->name('districts');
Route::get('/villages', [PelangganController::class, 'getVillages'])->name('villages');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| Routes yang hanya dapat diakses oleh user yang sudah login.
|

*/
require __DIR__.'/auth.php';
