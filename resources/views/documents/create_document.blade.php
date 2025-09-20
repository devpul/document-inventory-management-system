@extends('layout')
@section('title', 'Buat Dokumen')

@section('content')
    {{-- {{ dd($publicUrl, $mime, $filename, $dokumen) }} --}}
    <!-- sidebar -->
    @include('partials.sidebar')

    <!-- content -->
    <div class="flex-1 flex flex-col">
        <!-- header -->
        @include('partials.header')

        <!-- sub header -->
        <section class="pt-6 px-6 items-center">
            <div class="bg-transparent px-4 flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Buat Dokumen Baru</h1>
                <form action="{{ route('dashboard.document_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div id="btn-group" class="flex justify-end gap-x-5 items-center">
                    <!-- Button Create -->
                    <div id="btn-submit">
                        <button type="submit" onclick="return confirm('Yakin ingin membuat dokumen ini ?')"
                        class="bg-blue-500 text-white font-semibold text-center rounded px-3 py-1">
                            Buat Dokumen
                        </button>
                    </div>
                     <!-- Kembali -->
                    <a href="{{ route('dashboard.documents') }}" 
                    class="bg-red-500 text-white font-semibold px-3 py-1 rounded">Kembali</a>
                </div>
            </div>    
        </section>

        <!-- main -->
        <main class="px-6 relative flex-grow min-h-screen">
            <div class="bg-white shadow p-6 rounded-2xl flex flex-col-reverse gap-y-5"> <!-- FLEX-COL REVERSED -->
                <!-- #1 information -->
                <div class="space-x-10 ">
                    
                        <!-- #div1 -->
                        <div id="leftSide" class="w-full space-y-4">
                            <!-- Nomor Dokumen -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Nomor Dokumen</label>
                                <input type="text" placeholder="Terisi otomatis" readonly
                                class="w-full focus:border border-blue-500 transition duration-300"> 
                            </div>
                            <!-- Nama Dokumen -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Nama Dokumen</label>
                                <input type="text" placeholder="Terisi otomatis" readonly
                                class="w-full focus:border border-blue-500 transition duration-300"> 
                            </div>
                            <!-- Kategori -->
                            <div class="input-group space-y-1 flex flex-col">
                                <label class="font-semibold">Kategori</label>
                                <select name="kategori_id" >
                                    <option value="1">SOP (Standar Operasional Prosedur)</option>
                                    <option value="2">Non-SOP (Standar Operasional Prosedur)</option>
                                    <option value="3">IK (Instruksi Kerja)</option>
                                    <option value="4">LPR (Laporan)</option>
                                </select>
                            </div>

                            <!-- PEMILIK -->
                            <!-- user -->
                            @if( Auth()->user()->role_id == 1 )
                            <div class="input-group space-y-1 flex flex-col">
                                <label class="font-semibold" hidden>Pemilik</label>
                                <input type="text" name="owner_id" value="{{ Auth()->user()->id }}" readonly hidden>
                            </div>
                            @endif
                            <!-- admin -->
                            @if( Auth()->user()->role_id == 2 )
                            <div class="input-group space-y-1 flex flex-col">
                                <label class="font-semibold">Pemilik</label>
                                <select name="owner_id" >
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama }} ({{ strtoupper($user->role->nama_role )}})</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <!-- Deskripsi -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Deskripsi Singkat</label>
                                <textarea name="deskripsi" placeholder="Masukan deskripsi di sini (opsional)" class="w-full focus:border border-blue-500 transition duration-300"></textarea>
                            </div>
                            <!-- Tanggal Terbit -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Tanggal Terbit</label>
                                <input type="date" name="tanggal_terbit" required
                                class="w-full focus:border border-blue-500 transition duration-300"> 
                            </div>
                            <!-- Keyword -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Keyword atau Tags</label>
                                <input type="text" name="keyword" required placeholder="Masukan keyword di sini"
                                class="w-full focus:border border-blue-500 transition duration-300"> 
                            </div>

                            <!-- File Attachment -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">File Attachment</label>
                                <input type="file" name="file_attachment" required placeholder="Masukan keyword di sini"
                                class="w-full focus:border border-blue-500 transition duration-300"> 
                            </div>
                            
                        </div>
                    </form>
                </div>
                <!-- #2 header -->
                <div class="bg-yellow-200 text-yellow-500 font-semibold w-full text-center py-2 px-4 text-lg">
                    Tentang Dokumen
                </div>
            </div>

            <!-- footer -->
            @include('partials.footer')
        </main>
    </div>


@endsection