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
        $produk = Produk::with(['kategori'])
            ->when($search, function ($query) use ($search) {
                return $query->where('NamaProduk', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    
            
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
        $foto = null;

        if ($request->hasFile('FotoProduk')) {
            $foto = $request->file('FotoProduk')->store('produk', 'public');
        }

        DB::beginTransaction();
        try {
            Produk::create([
                'NamaProduk'  => $request->NamaProduk,
                'Harga'       => $harga,
                'Stok'        => 0, // default (optional, karena migration sudah set default juga)
                'KategoriID'  => $request->KategoriID,
                'FotoProduk'  => $foto,
                'created_at'  => now(),
                'updated_at'  => now()
            ]);

            DB::commit();
            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan produk.');
        }
    }

    public function edit($id)
    {
        $produk = Produk::where('ProdukID', $id)->firstOrFail();
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

        $produk = Produk::where('ProdukID', $id)->firstOrFail();
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
            'updated_at'  => now()
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::where('ProdukID', $id)->firstOrFail();

        if ($produk->FotoProduk) {
            Storage::disk('public')->delete($produk->FotoProduk);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
    public function pindahKeStockOut(Request $request)
{
    $produk = Produk::findOrFail($request->ProdukID);
    $kedaluwarsa = $produk->Kedaluwarsa;

    // Cek apakah stok ini udah pernah dipindahkan sebelumnya
    $cekSudahAda = StockOut::where('ProdukID', $produk->ProdukID)
        ->whereDate('Kedaluwarsa', $kedaluwarsa)
        ->exists();

    if ($cekSudahAda) {
        return redirect()->back()->with('error', 'Produk ini sudah pernah dipindahkan ke Barang Keluar untuk tanggal kedaluwarsa tersebut.');
    }

    // Kurangi stok
    $produk->Stok -= $request->Jumlah;
    $produk->save();

    // Simpan ke stock_out
    StockOut::create([
        'ProdukID' => $produk->ProdukID,
        'Jumlah' => $request->Jumlah,
        'TanggalKeluar' => now(),
        'Keterangan' => $request->Keterangan ?? 'Kedaluwarsa',
        'Kedaluwarsa' => $kedaluwarsa,
    ]);

    return redirect()->back()->with('success', 'Produk berhasil dipindahkan ke barang keluar.');
}

}
