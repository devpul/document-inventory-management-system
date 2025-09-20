<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Users;

class RegisterController extends Controller
{
    public function create() {
        return view ('auth.register');
    }

    public function store(Request $request) {
        $validated_data = $request->validate([
            'nama' => 'required|min:3|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $users = Users::create([
            'nama' => $validated_data['nama'],
            'email' => $validated_data['email'],
            'password' => bcrypt($validated_data['password'])
        ]);
        
        if($users) {
            return redirect()->route('login')
                            ->with('success', 'Berhasil buat akun!');
        }

        return view('auth.register');
    }
}
