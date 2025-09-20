<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function loginUser(Request $request)
    {
        $validated_data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Auth::attempt otomatis cek Hash::check()
        if (Auth::guard('web')->attempt([
            'email' => $validated_data['email'],
            'password' => $validated_data['password'],
        ])) 
        {
            
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->route('dashboard.index_user')->with('welcome', 'Anda Berhasil Login ke Aplikasi DMS.');
            // $request->session()->put('nama', $user->nama);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
