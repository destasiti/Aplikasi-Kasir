<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProdukController extends Controller
{
      public function index(Request $request)
        {
            $search = $request->input('search');
            $produk = Produk::with('kategori')
            ->when($search, function ($query) use ($search) {
                return $query->where('NamaProduk', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        
    
            foreach ($produk as $item) {
                $stockData = StockIn::where('ProdukID', $item->ProdukID)
                    ->orderBy('Kedaluwarsa', 'asc')
                    ->first();
                
                $item->Stok = StockIn::where('ProdukID', $item->ProdukID)->sum('Jumlah');
                $item->Kedaluwarsa = $stockData ? $stockData->Kedaluwarsa : '-';
            }
    
            return view('produk.index', compact('produk', 'search'));
        }
    
        public function create()
        {
            $kategori = Kategori::all();
            return view('produk.create', compact('kategori'));
        }
    
        public function store(Request $request)
        {
            $request->validate([
                'NamaProduk'  => 'required|string|max:255',
                'Harga'       => 'required|numeric|min:1',
                'KategoriID'  => 'required|exists:kategori,KategoriID',
                'FotoProduk'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            $harga = preg_replace('/\D/', '', $request->Harga);
            $foto = $request->hasFile('FotoProduk') ? $request->file('FotoProduk')->store('produk', 'public') : null;
    
            Produk::create([
                'NamaProduk'  => $request->NamaProduk,
                'Harga'       => $harga,
                'KategoriID'  => $request->KategoriID,
                'FotoProduk'  => $foto,
            ]);
    
            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
        }
    
        public function edit($id)
        {
            $produk = Produk::findOrFail($id);
            $kategori = Kategori::all();
            return view('produk.edit', compact('produk', 'kategori'));
        }
    
        public function update(Request $request, $id)
        {
            $request->validate([
                'NamaProduk'  => 'required|string|max:255',
                'Harga'       => 'required|numeric|min:1',
                'KategoriID'  => 'required|exists:kategori,KategoriID',
                'FotoProduk'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            $produk = Produk::findOrFail($id);
            $harga = preg_replace('/\D/', '', $request->Harga);
    
            if ($request->hasFile('FotoProduk')) {
                if ($produk->FotoProduk) {
                    Storage::disk('public')->delete($produk->FotoProduk);
                }
                $produk->FotoProduk = $request->file('FotoProduk')->store('produk', 'public');
            }
    
            $produk->update([
                'NamaProduk'  => $request->NamaProduk,
                'Harga'       => $harga,
                'KategoriID'  => $request->KategoriID,
                'FotoProduk'  => $produk->FotoProduk,
            ]);
    
            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
        }
        public function destroy($id)
{
    $produk = Produk::findOrFail($id);
    
    // Jika ada foto produk, hapus file tersebut dari storage
    if ($produk->FotoProduk && Storage::disk('public')->exists($produk->FotoProduk)) {
        Storage::disk('public')->delete($produk->FotoProduk);
    }
    
    // Hapus data produk dari database
    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
}

public function cekKedaluwarsa()
{
    // Ambil produk yang kedaluwarsa hari ini
    $produkKedaluwarsa = Produk::whereHas('stock_in', function ($query) {
        $query->whereDate('Kedaluwarsa', '=', Carbon::today()->toDateString());
    })->get();

    return view('produk.kedaluwarsa', compact('produkKedaluwarsa'));
}

public function updateStok(Request $request, $id)
{
    // Cari produk berdasarkan ID
    $produk = Produk::findOrFail($id);

    // Periksa apakah checkbox untuk kedaluwarsa dicentang
    if ($request->has('cek_kedaluwarsa')) {
        // Update stok produk menjadi 0
        $produk->Stok = 0;
        
        // Pindahkan produk ke tabel barang keluar atau pengeluaran (misalnya)
        StockOut::create([
            'ProdukID' => $produk->ProdukID,
            'Jumlah' => $produk->Stok,
            'TanggalKeluar' => Carbon::now(),
        ]);

        // Simpan perubahan
        $produk->save();

        // Set notifikasi sukses
        session()->flash('message', 'Produk kedaluwarsa sudah diproses!');
    }

    // Kembali ke halaman produk dengan notifikasi
    return redirect()->route('produk.index');
}


    }