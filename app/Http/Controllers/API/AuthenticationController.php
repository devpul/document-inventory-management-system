<?php

namespace App\Http\Controllers\API;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ResponseFormatter;


use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login()
    {
        $email = request()->email;
        $password = request()->password;

        // ambil users (email dan password)
        $users = Users::where('email', $email)->first();
        if (is_null($users)) {
            // return response()->json([
            //     'pesan' => 'User tidak ditemukan!'
            // ]);
            return ResponseFormatter::error(400, null, [
                'User tidak ditemukan!'
            ]);
        }

        // dari table users
        $userPassword = $users->password;

        if (Hash::check($password, $userPassword)) {
            // bikin token 
            $token = $users->createToken(config('app.name'))->plainTextToken;

            return ResponseFormatter::success(['token' => $token], [
                'Berhasil Login!'
            ]);
        }

        return response()->json([
            'message' => 'Password salah!'
        ]);
    }
}
