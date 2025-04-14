<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use PDF;

class PelangganController extends Controller
{
    // Menampilkan halaman daftar pelanggan
    public function index(Request $request)
    {
        // Tambahkan fitur pencarian berdasarkan nama
        $search = $request->input('search');
        $pelanggan = Pelanggan::where('NamaPelanggan', 'LIKE', '%' . $search . '%')
        ->orderBy('created_at', 'desc') 
                ->paginate(5);
        return view('pelanggan.index', compact('pelanggan'));
    }

    // Menampilkan form untuk menambah pelanggan baru
    public function create()
    {
        return view('pelanggan.create');
    }

    // Menyimpan pelanggan baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'Email' => 'required|email|unique:pelanggan',
            'NomorTelepon' => 'required|regex:/^[0-9]+$/|max:15',
            'JenisKelamin' => 'required|in:laki-laki,perempuan',
        ]);   

        // Membuat pelanggan baru
        Pelanggan::create($validated);

        // Redirect ke halaman daftar pelanggan dengan notifikasi
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Menampilkan detail pelanggan
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    // Menampilkan form untuk mengedit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    // Memperbarui data pelanggan
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'Email' => 'required|email|unique:pelanggan,Email,' . $id . ',PelangganID',
            'NomorTelepon' => 'required|regex:/^[0-9]+$/|max:15',
            'JenisKelamin' => 'required|in:laki-laki,perempuan',
        ]);

        // Menemukan pelanggan yang akan diperbarui
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($validated);

        // Redirect ke halaman daftar pelanggan dengan notifikasi
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    // Menghapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        // Redirect ke halaman daftar pelanggan dengan notifikasi
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function exportPdf()
    {
        $pelanggan = Pelanggan::orderBy('created_at', 'desc')->get();
        
        $pdf = PDF::loadView('pelanggan.laporan_pdf', compact('pelanggan'));
    
        // Langsung download tanpa perlu klik tombol lagi
        return $pdf->download('laporan_pelanggan.pdf');
    }
    
}