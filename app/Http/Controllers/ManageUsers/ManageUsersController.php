<?php

namespace App\Http\Controllers\ManageUsers;

use Illuminate\Support\Facades\Storage;

use Exception;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = Users::with('role');

        if ($request->has('search') && $request->search != '') {
            
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('role', function($q) use ($search) {
                $q->where('nama_role', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

        // kalau request via AJAX → balikin JSON
        if ($request->ajax()) {
            return response()->json($users);
        }

        // kalau buka halaman biasa → balikin Blade
        return view('kelola_users.users', compact('users'));
    }

    public function detailUser($id)
    {
        // $user = Users::where('id', '=',$id)->first();
        $user = Users::findOrFail($id);

        return view('kelola_users.read_user', compact('user'));
    }

    public function create()
    {
        return view ('kelola_users.create_user');
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'role_id' => 'required|string',
            'nama' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'no_telepon' => 'nullable|string',
        ]);

        $hashedPassword = bcrypt($validated_data['password']);

        $payload = [
            'role_id' => $validated_data['role_id'],
            'nama' => $validated_data['nama'],
            'email' => $validated_data['email'],
            'password' => $hashedPassword,
            'no_telepon' => $validated_data['no_telepon'],
            // created_at
            // updated_at
        ];

        if (!is_null(request()->image)){
            $payload['image'] = request()->file('image')->store(
                'profile-image', 'public'
            );
        }

        try{
            $user = Users::create($payload);

            // debug sementara
            // dd($user);

            return redirect()->route('dashboard.manage_users')
                            ->with('success', 'Anda Berhasil Menambahkan User Baru.');
   
        }catch(Exception $e){
            
            // return response()->json(['gagal' => $e]);
            return redirect()->route('dashboard.manage_users')->with('failed', 'Gagal Membuat User.');;
        }
    }
    
    public function edit($id) 
    {
        $user = Users::findOrFail($id);

        return view('kelola_users.edit_user',  compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = Users::findOrFail($id);

        $validated_data = $request->validate([
            'image'      => 'nullable|image|max:1024',
            'role_id'    => 'required|string',
            'nama'       => 'required|string',
            'password'   => 'nullable|string|min:6', // kasih minimal biar aman
            'email'      => 'nullable|string|email',
            'no_telepon' => 'nullable|string',
        ]);

        try {
            // kalau ada upload file baru
            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::disk('public')->delete('profile-image/' . $user->image);
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile-image', $filename, 'public');

                $validated_data['image'] = $filename;
            } else {
                unset($validated_data['image']);
            }

            // kalau password kosong, jangan update password
            if (empty($validated_data['password'])) {
                unset($validated_data['password']);
            } else {
                $validated_data['password'] = bcrypt($validated_data['password']);
            }

            // cek role user login
            if (auth()->user()->role_id == 1) {
                $user->update([
                    'nama'       => $validated_data['nama'],
                    'email'      => $validated_data['email'] ?? $user->email,
                    'no_telepon' => $validated_data['no_telepon'] ?? null,
                    'image'      => $validated_data['image'] ?? $user->image,
                    'password'   => $validated_data['password'] ?? $user->password,
                ]);

                return redirect()
                ->route('dashboard.manage_edit_user', Auth()->user()->id)
                ->with('success_edit', 'Anda Berhasil Mengupdate Data Profile.');
            }

            if (auth()->user()->role_id == 2) {
                $user->update([
                    'role_id'    => $validated_data['role_id'],
                    'nama'       => $validated_data['nama'],
                    'email'      => $validated_data['email'] ?? $user->email,
                    'no_telepon' => $validated_data['no_telepon'] ?? null,
                    'image'      => $validated_data['image'] ?? $user->image,
                    'password'   => $validated_data['password'] ?? $user->password,
                ]);

                return redirect()
                ->route('dashboard.manage_users')
                ->with('success_edit', 'Anda Berhasil Mengupdate Data Profile.');
            }

            
        } catch (\Exception $e) {
            return response()->json(['Gagal' => $e->getMessage()]);
        }
    }



    public function drop($id)
    {   
        try{

            $user = Users::where('id', '=', $id)->delete();

            // success
            return redirect()->route('dashboard.manage_users')->with('success', 'Anda Berhasil Menghapus User.');
        }catch(Exception $e){

            return redirect()->route('login');
        }
    }
}
