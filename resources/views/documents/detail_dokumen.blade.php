@extends('layout')
@section('title', 'Detail Dokumen')

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
                <h1 class="text-2xl font-semibold">Detail Dokumen</h1>
                <div id="btn-group" class="flex justify-end gap-x-5 w-[50%] items-center">
                    <!-- Lihat Tombol -->
                    <a href="javascript:void(0)" 
                    onclick="openPreview('{{ asset('storage/documents/' . basename($dokumen->file_attachment)) }}', '{{ mime_content_type(storage_path('app/public/documents/' . basename($dokumen->file_attachment))) }}')" 
                    class="px-3 py-1 bg-blue-500 text-white rounded ">
                    Lihat Dokumen
                    </a>
                     <!-- Kembali -->
                    <a href="{{ route('dashboard.documents') }}" 
                    class="bg-red-500 text-white font-semibold px-3 py-1 rounded">Kembali</a>
                </div>
            </div>    
        </section>

        <!-- Modal -->
        <div id="previewModal" 
            class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]">
            <div class="bg-white w-4/5 h-4/5 rounded-lg p-4 relative shadow-lg">
                <button onclick="closePreview()" 
                        class="absolute top-2 right-2 text-red-500 font-bold">X</button>
                <div id="previewContent" class="w-full h-full"></div>
            </div>
        </div>

        <!-- main -->
        <main class="px-6 relative flex-grow min-h-screen">
            <div class="bg-white shadow p-6 rounded-2xl flex flex-col-reverse gap-y-5">
                <!-- information -->
                <div class="flex justify-between space-x-10">
                    <!-- #div1 -->
                    <div id="leftSide" class="w-[50%] space-y-4">
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Nomor Dokumen</label>
                            <input type="text" value="{{ $dokumen->nomor_dokumen }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Nama Dokumen</label>
                            <input type="text" value="{{ $dokumen->nama_dokumen }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Kategori</label>
                            @if($dokumen->kategori_id == 1)
                            <input type="text" value="SOP (Standar Operasional Prosedur)" readonly 
                            class="w-full"> 
                            @endif

                            @if($dokumen->kategori_id == 2)
                            <input type="text" value="Non SOP (Standar Operasional Prosedur)" readonly 
                            class="w-full"> 
                            @endif
                            @if($dokumen->kategori_id == 3)
                            <input type="text" value="IK (Instruksi Kerja)" readonly 
                            class="w-full"> 
                            @endif

                            @if($dokumen->kategori_id == 4)
                            <input type="text" value="LPR (Laporan)" readonly 
                            class="w-full"> 
                            @endif
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Pemilik</label>
                            <input type="text" value="{{ $dokumen->user->nama  }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Deskripsi</label>
                            <input type="text" value="{{ $dokumen->deskripsi ? $dokumen->deskripsi : '-' }}" readonly 
                            class="w-full"> 
                        </div>
                         <!-- FILLABLE -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Tanggal Terbit</label>
                            <input type="text" value="{{ $dokumen->tanggal_terbit ? $dokumen->tanggal_terbit->format('d-m-Y') : '-'  }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- FILLABLE -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Keyword atau Tags</label>
                            <input type="text" value="{{ $dokumen->keyword }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Status</label>
                            <input type="text" value="{{ strtoupper($dokumen->status ) }}" readonly 
                            class="w-full"> 
                        </div>
                        <!-- -->
                        <div class="input-group space-y-1">
                            <label class="font-semibold">Format File</label>
                            <input type="text" value="{{ strtoupper(pathinfo($dokumen->file_attachment, PATHINFO_EXTENSION)) }}" readonly 
                            class="w-full"> 
                        </div>
                        
                    </div>

                    <!-- #div2 -->
                    <div id="rightSide" class="w-[50%] flex flex-col">
                        <div id="input-right-upper-group" class="space-y-4">
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Nama Pengirim</label>
                                <input type="text" value="{{ $dokumen->user->nama }}" readonly 
                                class="w-full"> 
                            </div>
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Email Pengirim</label>
                                <input type="text" value="{{ $dokumen->user->email }}" readonly 
                                class="w-full"> 
                            </div>
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Email Penerima</label>
                                <input type="text" value="{{ $dokumen->share_dokumen ? $dokumen->share_dokumen->user->email : '-' }}" readonly 
                                class="w-full"> 
                            </div>
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Tanggal_dibagikan</label>
                                <input type="text" value="{{ $dokumen->log_dokumen->tanggal_dibagikan ? $dokumen->log_dokumen->tanggal_dibagikan->format('d-m-Y h:i:s')  : '-'}}" readonly
                                class="w-full">
                            </div>
                        </div>
                        
                        <div class="input-right-lower-group flex flex-col space-y-4">
                            <div class="bg-blue-200 text-blue-500 font-semibold w-full mt-10 text-center py-2 px-4 text-lg">
                                Informasi Tambahan
                            </div>
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Ukuran File</label>
                                <input type="text" value="{{ formatSizeUnits(getFileSizeSafe($dokumen->file_attachment)) }}" readonly
                                class="w-full">
                            </div>
                            <!-- -->
                            <div class="input-group space-y-1">
                                <label class="font-semibold">Tanggal Upload</label>
                                <input type="text" value="{{ $dokumen->log_dokumen->tanggal_dibuat->format('d-m-Y') }}" readonly
                                class="w-full">
                            </div>
                            <div class="space-y-4">
                                <!-- -->
                                <div class="input-group space-y-1">
                                    <label class="font-semibold">Tanggal Diubah</label>
                                    <input type="text" value="{{ $dokumen->log_dokumen->tanggal_dibagikan ? $dokumen->log_dokumen->tanggal_dibagikan->format('d-m-Y h:i:s')  : '-'}}" readonly
                                    class="w-full">
                                </div>
                                 <!-- -->
                                <div class="input-group space-y-1">
                                    <label class="font-semibold">file_attachment</label>
                                    <input type="text" value="{{ basename($dokumen->file_attachment)  }}" readonly 
                                    class="w-full"> 
                                </div>
                
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- HEADER DETAIL -->
                <div id="header-detail" class="flex justify-between space-x-10" >
                    <div class="bg-yellow-200 text-yellow-500 font-semibold w-[50%] text-center py-2 px-4 text-lg">
                        Tentang Dokumen
                    </div>

                    <div class="bg-green-200 text-green-500 font-semibold w-[50%] text-center py-2 px-4 text-lg">
                        Detail Dibagikan
                    </div>
                   
                </div>
            </div>

            <!-- footer -->
            @include('partials.footer')
        </main>
    </div>

     <script>
        function openPreview(url, mime) {
            let content = '';

            if (mime.includes('pdf') || mime.includes('word') || mime.includes('excel') || mime.includes('officedocument')) {
                content = `<iframe src="https://docs.google.com/viewer?url=${encodeURIComponent(url)}&embedded=true" width="100%" height="100%" style="border:none;"></iframe>`;
            } else if (mime.includes('image')) {
                content = `<img src="${url}" class="w-full h-full object-contain">`;
            } else {
                content = `<a href="${url}" class="text-blue-500 underline">Download File</a>`;
            }

            document.getElementById('previewContent').innerHTML = content;
            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }
    </script>

@endsection