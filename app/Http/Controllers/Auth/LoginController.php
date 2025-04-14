<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user->role_as === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_as === 'kasir') {
            return redirect()->route('kasir.dashboard');
        } else {
            auth()->logout();
            return redirect('/login')->withErrors(['error' => 'Role tidak valid.']);
        }
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
