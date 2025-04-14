<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Produk;
use App\Models\Supplier;

class StockController extends Controller
{public function search(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
    
        // Ambil data berdasarkan range tanggal dengan pagination (misal 4 per halaman)
        $stockIns = StockIn::with('produk', 'supplier')
            ->whereBetween('TanggalMasuk', [$tanggalMulai, $tanggalSelesai])
            ->paginate(10);
        
        // Untuk stockOuts, jika tidak perlu dipaginasi, tetap gunakan get()
        $stockOuts = StockOut::with('produk')
            ->whereBetween('TanggalKeluar', [$tanggalMulai, $tanggalSelesai])
            ->get();
    
        // Ambil data produk dengan pagination (misal 5 per halaman)
        $produk = Produk::paginate(5);
        $supplier = Supplier::all();
    
        return view('stock.index', compact('stockIns', 'stockOuts', 'produk', 'supplier', 'tanggalMulai', 'tanggalSelesai'));
    }
    
    
    public function index(Request $request)
    {
        // Ambil data produk dengan pagination 5 per halaman
        $produk = Produk::paginate(10);
        
        // Ambil data supplier (tidak di-paginate)
        $supplier = Supplier::all();
        
        // Jika ada filter tanggal, ambil stock in sesuai range dengan pagination 4 per halaman, jika tidak, ambil semua stock in dengan pagination
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $stockIns = StockIn::with('produk', 'supplier')
                ->whereBetween('TanggalMasuk', [$request->tanggal_mulai, $request->tanggal_selesai])
                ->latest()
                ->paginate(4);
        } else {
            $stockIns = StockIn::with('produk', 'supplier')
                ->latest()
                ->paginate(10);
        }
        
        // Ambil stock out (misalnya tidak di-paginate atau sesuai kebutuhan)
        $stockOuts = StockOut::with('produk')->latest()->get();
        
        return view('stock.index', compact('stockIns', 'stockOuts', 'produk', 'supplier'));
    }
    

    public function storeStockIn(Request $request)
    {
        $request->validate([
            'ProdukID' => 'required|exists:produk,ProdukID',
            'SupplierID' => 'required',
            'Jumlah' => 'required|integer|min:1',
            'HargaBeli' => 'nullable|numeric|min:1',
            'TanggalMasuk' => 'required|date',
            'Kedaluwarsa' => 'required|date|after:TanggalMasuk',
        ]);

        StockIn::create($request->all());

        $produk = Produk::find($request->ProdukID);
        if ($produk) {
            $produk->increment('Stok', $request->Jumlah);
        }

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan');
    }

    public function storeStockOut(Request $request)
    {
        $request->validate([
            'ProdukID' => 'required|exists:produk,ProdukID',
            'Jumlah' => 'required|integer|min:1',
            'HargaJual' => 'required|numeric',
            'TanggalKeluar' => 'required|date',
        ]);

        $produk = Produk::find($request->ProdukID);
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        if ($produk->Stok < $request->Jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        StockOut::create($request->all());
        $produk->decrement('Stok', $request->Jumlah);

        return redirect()->back()->with('success', 'Barang berhasil keluar dari stok');
    }

    public function downloadPDF(Request $request)
    {
        $query = StockIn::query();

        if ($request->has('search')) {
            $query->whereHas('supplier', function ($q) use ($request) {
                $q->where('NamaSupplier', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('TanggalMasuk', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $stocks = $query->get();

        if ($stocks->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data untuk filter yang dipilih.');
        }

        $pdf = PDF::loadView('stock.pdf', compact('stocks'));

        return $pdf->download('Laporan_Stock_' . now()->format('Y-m-d') . '.pdf');
    }
}
