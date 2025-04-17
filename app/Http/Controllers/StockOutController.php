<?php
namespace App\Http\Controllers;
use App\Models\StockOut;
use App\Models\Produk;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts =StockOut::with('produk')->latest()->paginate(10);
        return view('stock_out.index', compact('stockOuts'));
    }
    

    public function create()
    {
        $produk = Produk::where('Stok', '>', 0)->get(); // hanya produk yang masih ada stok
        return view('stock_out.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ProdukID' => 'required|exists:produk,ProdukID',
            'Jumlah' => 'required|integer|min:1',
            'Keterangan' => 'required|string|max:255',
        ]);

        $produk = Produk::findOrFail($request->ProdukID);

        if ($produk->Stok < $request->Jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        StockOut::create([
            'ProdukID' => $request->ProdukID,
            'Jumlah' => $request->Jumlah,
            'TanggalKeluar' => now(),
            'Keterangan' => $request->Keterangan,
        ]);

        $produk->decrement('Stok', $request->Jumlah);

        return redirect()->route('stock_out.index')->with('success', 'Barang keluar berhasil dicatat.');
    }
}
