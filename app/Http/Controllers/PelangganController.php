<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use PDF;
// Import model IndoRegion
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

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
        $provinces = Province::all();
        return view('pelanggan.create', compact('provinces'));
    }

    // Mendapatkan data kabupaten/kota berdasarkan provinsi
    public function getRegencies(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)->get();
        return response()->json($regencies);
    }

    // Mendapatkan data kecamatan berdasarkan kabupaten/kota
    public function getDistricts(Request $request)
    {
        $districts = District::where('regency_id', $request->regency_id)->get();
        return response()->json($districts);
    }

    // Mendapatkan data desa/kelurahan berdasarkan kecamatan
    public function getVillages(Request $request)
    {
        $villages = Village::where('district_id', $request->district_id)->get();
        return response()->json($villages);
    }

    // Menyimpan pelanggan baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'province_id' => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
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

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $provinces = Province::all();
        
        // Pre-load related data dengan nama yang benar
        $regencies = Regency::where('province_id', $pelanggan->province_id)->get();
        $districts = District::where('regency_id', $pelanggan->regency_id)->get(); 
        $villages = Village::where('district_id', $pelanggan->district_id)->get();
        
        return view('pelanggan.edit', compact('pelanggan', 'provinces', 'regencies', 'districts', 'villages'));
    }
    public function update(Request $request, $id)
    {
        // Find the pelanggan first
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Validasi input dengan nama field yang benar dan primary key yang sesuai
        $validated = $request->validate([
            'NamaPelanggan' => 'required|string|max:255',
            'Alamat' => 'required|string',
            'province_id' => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'Email' => 'required|email|unique:pelanggan,Email,' . $id . ',PelangganID', // Asumsikan primary key adalah PelangganID
            'NomorTelepon' => 'required|regex:/^[0-9]+$/|max:15',
            'JenisKelamin' => 'required|in:laki-laki,perempuan',
        ]);
    
        $pelanggan->update($validated);
    
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