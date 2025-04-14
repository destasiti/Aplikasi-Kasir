<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createKasir()
    {
        $kasirs = User::where('role_as', 'kasir')->get(); // asumsi role_as == 'kasir'
        return view('kasir.create', compact('kasirs'));
    }
    
    
    public function storeKasir(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_as' => 'required', 
        ]);
            
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_as' => $request->role_as,
        ]);
    
        return redirect()->route('kasir.create')->with('success', 'Akun kasir berhasil dibuat!');
    }
    
}
