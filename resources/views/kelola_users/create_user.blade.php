@extends('layout')
@section('title', 'Buat User')

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
                    <h1 class="text-2xl font-semibold">Create User</h1>
                </div>
            </div>
            

            <!-- Main -->
            <main class="p-6 relative flex-grow">
                <!-- Table 1 -->
                <div class="bg-white rounded-2xl shadow p-6">
                    <h1 class="font-bold text-center">CREATE USER</h1>
                        <form action="{{ route('dashboard.manage_store_user') }}" method="POST" class="flex flex-col">
                        @csrf
                            
                            <label for="nama" class="mt-4">Nama</label>
                            <input type="text" name="nama" required>
                            
                            <label for="role_id"  class="mt-4">Role</label>
                            <select name="role_id">
                                <option value="1">User</option>
                                <option value="2">Admin</option>
                            </select>

                            <label for="email" class="mt-4">Email</label>
                            <input type="email" name="email" required>

                            <label for="password" class="mt-4">Password</label>
                            <input type="password" name="password" required>

                            <label for="no_telepon" class="mt-4">No. Telepon</label>
                            <input type="text" name="no_telepon">

                            <div class="flex space-x-3">
                                <a href="{{ route('dashboard.manage_users') }}" class=" bg-red-500 font-semibold mt-5">Cancel</a>
                                <button type="submit" class=" bg-blue-500 font-semibold mt-5">Create</button>
                            
                            </div>
                            
                        </form>
                </div>
                
                

                @include('partials.footer')
            </main>
        </div>
@endsection