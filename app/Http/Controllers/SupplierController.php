<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Fitur pencarian berdasarkan nama supplier
        $search = $request->input('search');
        $supplier = Supplier::when($search, function ($query, $search) {
            return $query->where('NamaSupplier', 'LIKE', '%' . $search . '%');
        })->latest()->paginate(5);

        return view('supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NamaSupplier' => 'required|string|max:255|unique:supplier,NamaSupplier',
            'Kontak' => 'nullable|regex:/^[0-9]+$/|max:15',
            'Alamat' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'NamaSupplier' => 'required|string|max:255|unique:supplier,NamaSupplier,' . $supplier->SupplierID . ',SupplierID',
            'Kontak' => 'nullable|regex:/^[0-9]+$/|max:15',
            'Alamat' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
