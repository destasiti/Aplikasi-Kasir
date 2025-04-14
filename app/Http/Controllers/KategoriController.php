<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
        public function index(Request $request)
        {
            $search = $request->input('search');
            $query = Kategori::query();
            
            if ($search) {
                $query->where('NamaKategori', 'like', '%' . $search . '%'); // Pencarian berdasarkan NamaKategori
            }
            
            $kategoris = $query->orderBy('created_at', 'desc')->paginate(5); 
            
            return view('kategori.index', compact('kategoris'));
        }
    
        public function create()
        {
            return view('kategori.create');
        }
    
        public function store(Request $request)
        {
            $this->validate($request, [
                'NamaKategori' => 'required|max:50', 
                'Deskripsi' => 'nullable|string',
            ]);
        
            // Membuat kategori baru
            Kategori::create([
                'NamaKategori' => $request->NamaKategori,
                'Deskripsi' => $request->Deskripsi, 
            ]);
            
            return redirect()->route('kategori.index')->with('success', 'Berhasil Membuat Data Kategori');
        }
    
        public function edit($id)
        {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit', compact('kategori'));
        }
    
        public function update(Request $request, $id)
        {
            $this->validate($request, [
                'NamaKategori' => 'required|max:50', 
                'Deskripsi' => 'nullable|string', // Deskripsi tidak wajib diisi
            ]);
        
            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'NamaKategori' => $request->NamaKategori,
                'Deskripsi' => $request->Deskripsi, // Jika kosong, akan disimpan sebagai null
            ]);
        
            return redirect()->route('kategori.index')->with('success', 'Berhasil Memperbarui Data Kategori');
        }
    
        public function destroy($id)
        {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            
            return redirect()->route('kategori.index')->with('success', 'Berhasil Menghapus Data Kategori');
        }
    }
    