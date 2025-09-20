@extends('layout')
@section('title', 'Ubah Data User')

@section('content')
        @include('partials.sidebar')
        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('partials.header')
            <!-- Documents Header -->
            <div class="p-6 items-center">
                <div class="bg-transparent py-0 px-4 flex  items-center">
                    <h1 class="text-2xl font-semibold">Edit User</h1>
                </div>
            </div>
            
            <!-- Main -->
            <main class="p-6 relative flex-grow min-h-screen">
                <div class="bg-white rounded-2xl shadow p-6 space-y-6">  
                    {{-- Form --}}
                    <form class="flex" action="{{ route('dashboard.manage_update_user', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col justify-between w-[100%]">
                            {{-- header-profile --}}
                            <div class="flex justify-between">
                                {{-- image --}}
                                <div class="flex space-x-10 items-center">
                                    <div id="img-group" class="relative">
                                        <img 
                                        src="{{ $user->image 
                                                    ? asset('storage/profile-image/' . $user->image) 
                                                    : asset('storage/profile-image/default-avatar.jpg') }}" 
                                        class="w-[125px] h-[125px] object-cover rounded-full" 
                                        alt="{{ $user->nama ?? 'User' }}">

                                        <!-- Tombol ganti foto (icon kamera) -->
                                        <label for="image" 
                                            class="absolute bottom-2 right-2 rounded-full shadow cursor-pointer">
                                            <!-- pakai heroicons/feather/lucide atau svg -->
                                            <div class="bg-gray-200 border rounded-full p-2  hover:bg-gray-300 text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </div>
                                        </label>

                                        <!-- Input file (disembunyikan) -->
                                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                                    </div>
                                    
                                    <div class="name-email flex flex-col gap-y-2">
                                        <h4 class="font-bold text-3xl text-blue-500">{{ $user->nama }}</h4>
                                        <p class="font-semibold text-lg">{{ $user->email }}</p>
                                    </div>
                                </div>
                                {{-- BUTTON EDIT & CANCEL --}}
                                <div class="flex space-x-5 items-center">
                                    <button type="submit" class="py-2 px-10 bg-blue-500 font-semibold text-center text-white rounded">Edit</button>
                                    
                                    @if( auth()->user()->role_id == 1)
                                        <a href="{{ route('dashboard.index_admin')  }}" class="py-2 px-10 bg-red-500 font-semibold text-center text-white rounded">Cancel</a>
                                    @endif
                                    
                                    @if( auth()->user()->role_id == 2)
                                        <a href="{{ route('dashboard.manage_users') }}" class="py-2 px-10 bg-red-500 font-semibold text-center text-white rounded">Cancel</a>
                                    @endif
                                </div>
                            </div>

                            {{-- form --}}
                            <div class="flex justify-between space-x-10 mt-10">
                                <div class="form-group flex flex-col w-[50%] space-y-4">
                                    <label for="id" class="font-bold">ID</label>
                                    <input type="text" name="id" value="{{ $user->id }}" readonly>
                                    
                                    @if(auth()->user()->role_id == 1)
                                        <label class=" font-bold">Hak Akses</label>
                                        <input name="role_id" value="User" readonly></input>
                                    @endif

                                    @if(auth()->user()->role_id == 2)
                                        <label for="role_id" class=" font-bold">Role</label>
                                        <select name="role_id" onchange="checkRole(this)">
                                            @if( $user->role_id == 1 )
                                                <option value="1" selected>User</option>
                                                <option value="2" >Admin</option>
                                            @endif

                                            @if( $user->role_id == 2 )
                                                <option value="1" >User</option>
                                                <option value="2" selected>Admin</option>
                                            @endif
                                        </select>
                                    @endif

                                    <label for="nama" class=" font-bold">Nama</label>
                                    <input type="text" name="nama" value="{{ $user->nama }}" required>
                                </div>

                                <div class="form-group flex flex-col w-[50%] space-y-4">
                                     <label for="email" class="font-bold">Email</label>
                                    <input type="email" name="email" placeholder="Masukan jika ingin ganti email (tidak disarankan)">

                                    <label for="password" class="font-bold">Password</label>
                                    <input type="password" name="password" placeholder="Masukan jika ingin ganti password (minimal 6 digit!)">

                                    <label for="no_telepon" class="font-bold">No. Telepon</label>
                                    @if( is_null($user->no_telepon) )
                                        <input type="text" name="no_telepon" placeholder="Belum di isi">
                                    @else
                                        <input type="text" name="no_telepon" value="{{ $user->no_telepon }}">
                                    @endif 
                                </div>
                            </div>

                            <hr class="mt-10 mb-5">

                            <div class="flex justify-between space-x-10">
                                <div class="flex flex-col w-[50%] form-group space-y-3">
                                    <label class="font-bold">Dibuat tanggal</label>
                                    <input type="text" value="{{ $user->created_at->format('d M Y') }}" readonly>
                                </div>

                                <div class="flex flex-col w-[50%] form-group space-y-3">
                                    <label class="font-bold">Terakhir diupdate</label>
                                    <input type="text" value="{{ $user->updated_at->format('d M Y') }}" readonly>
                                </div>           
                            </div>
                        </div>
                    </form>
                </div>

                @include('partials.footer')
            </main>
        </div>

    {{-- javascript --}}
    <script>
        function checkRole(select)
        {
            if ( select.value == "2" ){
                let confirmChange = confirm('Yakin ingin mengubah menjadi Admin ?');
                if (!confirmChange){
                    select.value == "1";
                }
            }

            if ( select.value == "1" ){
                let confirmChange = confirm('Yakin ingin mengubah menjadi User ?');
                if(!confirmChange){
                    select.value == "2";
                }
            }
        }
    </script>
@endsection