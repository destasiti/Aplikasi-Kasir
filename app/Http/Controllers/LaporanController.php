<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $penjualans = [];
    
        // Hanya ambil data jika kedua tanggal sudah ada
        if ($tanggalMulai && $tanggalSelesai) {
            $penjualans = Penjualan::with(['pelanggan', 'details.produk', 'pembayaran'])
                ->whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai])
                ->orderBy('TanggalPenjualan', 'desc')
                ->get();
        }
    
        return view('laporan.index', compact('penjualans', 'tanggalMulai', 'tanggalSelesai'));
    }
    

    public function cetakPDF(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $query = Penjualan::with(['pelanggan', 'details.produk'])->orderBy('TanggalPenjualan', 'desc');

        if ($tanggalMulai && $tanggalSelesai) {
            $query->whereBetween('TanggalPenjualan', [$tanggalMulai, $tanggalSelesai]);
        }

        $penjualans = $query->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('penjualans', 'tanggalMulai', 'tanggalSelesai'));

        return $pdf->download('laporan_penjualan.pdf');
    }
}
