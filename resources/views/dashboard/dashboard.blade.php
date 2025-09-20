@extends('layout')
@section('title', 'Dashboard')

@section('content')
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('partials.header')

            <!-- Dashboard Header -->
            <div class="p-6 items-center">
                <div class="bg-transparent py-0 px-4 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold">Dashboard</h1>
                    <div class="flex items-center space-x-3">
                        
                        @if( auth()->user()->role_id == 1 )
                            <h2 class="font-bold text-xl">Selamat Datang User <span class=" text-blue-600">{{ auth()->user()->nama }}</span> 👋</h2>
                        @endif

                        @if( auth()->user()->role_id == 2 )
                            <h2 class="font-bold text-xl">Selamat Datang Admin <span class=" text-blue-600">{{ auth()->user()->nama }}</span> 👋</h2>
                        @endif
                    </div>
                </div>
            </div>
            

            <!-- Main -->
            <main class="p-6 relative flex-grow min-h-screen">
                <!-- Card-Group -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Card 1 -->
                    <div class="bg-red-500 hover:bg-red-600 transition-all duration-300 rounded-2xl shadow p-6 ">
                        <a href="{{ route('dashboard.documents') }}">
                            <h2>Total Dokumen</h2>
                            @if(auth()->user()->role_id == 1)
                            <p class="text-2xl font-bold">  {{ $total_dokumen_user }}</p>
                            @endif
                            @if(auth()->user()->role_id == 2)
                            <p class="text-2xl font-bold">  {{ $total_dokumen_users }}</p>
                            @endif
                        </a>
                        
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-yellow-500 hover:bg-yellow-600 transition-all duration-300 rounded-2xl shadow p-6 ">
                        <a href="{{ route('dashboard.document_shared_page') }}">
                            <h2>Dibagikan</h2>
                            <p class="text-2xl font-bold">{{ $total_dibagikan }}</p> <!-- here ........ -->
                        </a>
                    </div>

                    @if( auth()->user()->role_id == 1)
                        <div class="bg-green-500 hover:bg-green-600 transition-all duration-300 rounded-2xl shadow p-6 ">
                            <a>
                                <h2>Total User</h2>
                                <p class="text-2xl font-bold">{{ $total_user }}</p>
                            </a>
                        </div>
                    @endif

                    <!-- Card 3 -->
                    @if( auth()->user()->role_id == 2)
                        <div class="bg-green-500 hover:bg-green-600 transition-all duration-300 rounded-2xl shadow p-6 ">
                            <a href="{{ route('dashboard.manage_users') }}">
                                <h2>Total User</h2>
                                <p class="text-2xl font-bold">{{ $total_user }}</p>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Table 1 -->
                <div class="bg-white rounded-2xl shadow p-6">            
                    <h2 class="text-lg font-semibold mb-4 ml-3">Dokumen Terbaru 📁</h2>
                    <div class="mt-5">
                        <table class="w-full text-left border-collapse">
                            <thead class="">
                                <tr class="text-center">
                                    <th class="p-3 text-left">Nomor Dokumen</th>
                                    <th class="p-3">Nama Dokumen</th>
                                    {{-- <th class="p-3">Deskripsi</th> --}}
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Jenis File</th>
                                    <th class="p-3">Ukuran</th>
                                    <th class="p-3">Tanggal Upload</th>                  
                                </tr>
                            </thead>
                            <tbody>
                                <!-- user -->
                                @if(auth()->user()->role_id == 1)
                                    @forelse($dokumen_terbaru as $dokumen)
                                        <tr class="border-t hover:bg-gray-100 text-center">
                                            <td class="p-3 text-left">{{ $dokumen->nomor_dokumen }}</td>
                                            <td class="p-3">{{ $dokumen->nama_dokumen }}</td>
                                            <td class="p-3">{{ $dokumen->status }}</td>
                                            <td class="p-3">{!! getFileBadge($dokumen->file_attachment) !!}</td>
                                            <td class="p-3">{{ formatSizeUnits(getFileSizeSafe($dokumen->file_attachment)) }}</td>
                                            <td class="p-3">{{ $dokumen->log_dokumen->tanggal_dibuat->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-20">
                                                <a href="{{ route('dashboard.document_create') }}" class="text-xl text-blue-500 font-light italic">
                                                    klik di sini untuk membuat dokumen
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                                <!-- admin -->
                                @if(auth()->user()->role_id == 2)
                                    @forelse($dokumen_terbaru_admin as $dokumen)
                                        <tr class="border-t hover:bg-gray-100 text-center">
                                            <td class="p-3 text-left">{{ $dokumen->nomor_dokumen }}</td>
                                            <td class="p-3">{{ $dokumen->nama_dokumen }}</td>
                                            <td class="p-3">{{ $dokumen->status }}</td>
                                            <td class="p-3">{!! getFileBadge($dokumen->file_attachment) !!}</td>
                                            <td class="p-3">{{ formatSizeUnits(getFileSizeSafe($dokumen->file_attachment)) }}</td>
                                            <td class="p-3">{{ $dokumen->log_dokumen->tanggal_dibuat->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-20">
                                                <a href="{{ route('dashboard.document_create') }}" class="text-xl text-blue-500 font-light italic">
                                                    klik di sini untuk membuat dokumen
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                @include('partials.footer')
            </main>
        </div>
@endsection