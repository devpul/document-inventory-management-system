@extends('layout')
@section('title', 'Detail User')

@section('content')
        <!-- Sidebar -->
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
            <main class="p-6 relative flex-grow">
                <!-- Table 1 -->
                <div class="bg-white rounded-2xl shadow p-6 ">            
                    <h2 class="text-lg font-semibold mb-4 ml-3">Details</h2>
                    <form class="flex flex-col ml-3">
                            <label for="id" class="font-bold">ID</label>
                            <input type="text" name="id" value="{{ $user->id }}" readonly>

                            <label for="role_id" class="mt-4 font-bold">Role</label>
                            @if( $user->role_id == 1)
                                <input type="text" value="User" readonly>
                            @else
                                <input type="text" value="Admin" readonly>
                            @endif
                            

                            <label for="nama" class="mt-4 font-bold">Nama</label>
                            <input type="text" name="nama" value="{{ $user->nama }}" required>

                            <label for="password" class="mt-4 font-bold">Password</label>
                            <input type="password" value="{{ $user->password }}" readonly>
                            
                            <label for="email" class="mt-4 font-bold">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required>
                            
                            <label for="no_telepon" class="mt-4 font-bold">No. Telepon</label>
                            @if( is_null($user->no_telepon) )
                                <input type="text" name="no_telepon" placeholder="Belum di isi" readonly>
                            @else
                                <input type="text" name="no_telepon" value="{{ $user->no_telepon }}" required>
                            @endif     

                            <div class="flex gap-x-2 mt-4 ">
                                <label for="created_at" class="font-bold">Dibuat pada tanggal: </label>
                                <input type="text" id="created_at" value="{{ $user->created_at->format('d M Y') }}" readonly>
                            </div>

                            <div class="flex gap-x-2 mt-4">
                                <label class="font-bold">Terakhir diubah:  </label>
                                <input type="text" value="{{ $user->updated_at->format('d M Y') }}" readonly>
                            </div>
                            
                            <a href="{{ route('dashboard.manage_users') }}"
                                class="bg-blue-500 font-semibold text-center mt-5">
                                Back
                            </a>
                    </form>
                </div>


                @include('partials.footer')
            </main>
        </div>
@endsection