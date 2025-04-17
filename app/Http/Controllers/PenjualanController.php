<?php
namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\user;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PenjualanController extends Controller
{public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
    
        $penjualans = Penjualan::with(['pelanggan', 'details.produk', 'pembayaran', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('pelanggan', function ($q1) use ($search) {
                        $q1->where('NamaPelanggan', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
    
                    // Cek jika keyword adalah 'non-member' atau 'non member'
                    if (strtolower($search) === 'non-member' || strtolower($search) === 'non member') {
                        $q->orWhereNull('PelangganID');
                    }
                });
            })
            ->when($tanggalMulai && $tanggalSelesai, function ($query) use ($tanggalMulai, $tanggalSelesai) {
                return $query->whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('penjualan.index', compact('penjualans', 'tanggalMulai', 'tanggalSelesai'));
    }
    
    
    
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        $user = User::all();
        return view('penjualan.create', compact('pelanggan', 'produk','user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'TanggalPenjualan' => 'required|date',
            'PelangganID' => 'nullable|exists:pelanggan,PelangganID',
            'ProdukID' => 'required|array',
            'ProdukID.*' => 'exists:produk,ProdukID',
            'JumlahProduk' => 'required|array',
            'JumlahProduk.*' => 'integer|min:1',
        ]);
    
        $pelangganID = $request->PelangganID ?? null;
    
        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'PelangganID' => $pelangganID,
            'TotalHarga' => 0,
            'UserID' => Auth::id(),
        ]);
    
        $totalHarga = 0;
    
        foreach ($request->ProdukID as $key => $produkID) {
            $produk = Produk::findOrFail($produkID);
            $jumlahDibeli = $request->JumlahProduk[$key];
    
            // Cek stok cukup
            if ($produk->Stok < $jumlahDibeli) {
                return redirect()->back()->with('error', "Stok produk {$produk->NamaProduk} tidak mencukupi.");
            }
    
            $subTotal = $jumlahDibeli * $produk->Harga;
            $totalHarga += $subTotal;
    
            DetailPenjualan::create([
                'PenjualanID' => $penjualan->PenjualanID,
                'ProdukID' => $produkID,
                'JumlahProduk' => $jumlahDibeli,
                'SubTotal' => $subTotal,
            ]);
    
            // Kurangi stok
            $produk->Stok -= $jumlahDibeli;
            $produk->save();
        }
    
        $penjualan->update(['TotalHarga' => $totalHarga]);
    
        return redirect()->route('pembayaran.create', ['id' => $penjualan->PenjualanID])
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }    
    
   
        public function show($id)
    {
        $penjualan = Penjualan::with('details.produk', 'pelanggan')->findOrFail($id);
return view('penjualan.show', compact('penjualan'));
}
    
    public function destroy($id)
    {
        $penjualan = Penjualan::with('details')->findOrFail($id); // Tambahkan with('details')
    
        if ($penjualan->details->isNotEmpty()) { // Pastikan ada data
            foreach ($penjualan->details as $detail) {
                $produk = Produk::find($detail->ProdukID);
                if ($produk) {
                    $produk->Stok += $detail->JumlahProduk;
                    $produk->save();
                }
                $detail->delete(); // Hapus detail transaksi
            }
        }
    
        $penjualan->delete(); // Hapus transaksi utama
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus.');
    }

public function cetakPDF(Request $request)
{
    // Ambil tanggal dari request
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalSelesai = $request->input('tanggal_selesai');

    // Query data berdasarkan rentang tanggal atau semua data
    $query = Penjualan::with(['pelanggan', 'details.produk'])->orderBy('TanggalPenjualan', 'desc');

    if ($tanggalMulai && $tanggalSelesai) {
        $query->whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai]);
    }

    $penjualans = $query->get();

    // Generate PDF
    $pdf = Pdf::loadView('penjualan.pdf', compact('penjualans', 'tanggalMulai', 'tanggalSelesai'));

    return $pdf->download('laporan_penjualan.pdf');
}

    
}
