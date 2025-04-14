<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    public function index()
    {
        $profileToko = Toko::first(); // Ambil data pertama (karena hanya ada satu toko)
        return view('toko.index', compact('profileToko'));
    }
    
    public function create()
    {
        return view('toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaToko' => 'required|string|max:100',
            'Pemilik' => 'required|string|max:100',
            'Email' => 'required|email|unique:profile_toko,Email',
            'No_Telp' => 'required|string|max:20',
            'Alamat' => 'required|string',
            'Logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $profileToko = new Toko();
        $profileToko->NamaToko = $request->NamaToko;
        $profileToko->Pemilik = $request->Pemilik;
        $profileToko->Email = $request->Email;
        $profileToko->No_Telp = $request->No_Telp;
        $profileToko->Alamat = $request->Alamat;

        if ($request->hasFile('Logo')) {
            $filePath = $request->file('Logo')->store('logos', 'public');
            $profileToko->Logo = $filePath;
        }

        $profileToko->save();

        return redirect()->route('toko.index')->with('success', 'Profil Toko berhasil ditambahkan.');
    }

    public function edit()
    {
        $profileToko = Toko::first();
        if (!$profileToko) {
            return redirect()->route('toko.create')->with('error', 'Belum ada data toko.');
        }
        return view('toko.edit', compact('profileToko'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NamaToko' => 'required|string|max:255',
            'Pemilik' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'No_Telp' => 'required|string|max:15',
            'Alamat' => 'required|string',
            'Logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $toko = Toko::findOrFail($id);
        $toko->NamaToko = $request->NamaToko;
        $toko->Pemilik = $request->Pemilik;
        $toko->Email = $request->Email;
        $toko->No_Telp = $request->No_Telp;
        $toko->Alamat = $request->Alamat;
    
        if ($request->hasFile('Logo')) {
            // Hapus logo lama jika ada
            if ($toko->Logo && Storage::exists('public/' . $toko->Logo)) {
                Storage::delete('public/' . $toko->Logo);
            }
            // Simpan logo baru
            $path = $request->file('Logo')->store('logos', 'public');
            $toko->Logo = $path;
        }
    
        $toko->save();
        return redirect()->route('toko.index')->with('success', 'Profil toko berhasil diperbarui.');
    }
    
}
