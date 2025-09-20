@extends('layout')
@section('title', 'Ubah Dokumen')

@section('content')
    <!-- sidebar -->
    @include('partials.sidebar')

    <!-- content -->
    <div class="flex-1 flex flex-col">
        <!-- header -->
        @include('partials.header')

        <!-- sub header -->
        <section class="pt-6 px-6 items-center">
            <div class="bg-transparent py-0 px-4 flex justify-between items-center mb-10">
                <h1 class="text-2xl font-semibold">Edit Document</h1>
            </div>    
        </section>

        <!-- main -->
        <main class="px-6 relative flex-grow min-h-screen">
            <div class="bg-white shadow p-4 rounded-2xl flex justify-between space-x-10">
                <!-- form -->
                <form action="" class="flex flex-col w-[50%] space-y-5" enctype="multipart/form-data">
                    <div class="input-group flex flex-col space-y-2">
                        <label for="nomor_dokumen">No Dokumen</label>
                        <input type="text" name="nomor_dokumen" value="{{ $dokumen->nomor_dokumen }}" required>
                    </div>

                    <!-- admin only -->
                    @if( auth()->user()->role_id == 2 )
                        <div class="input-group flex flex-col space-y-2">
                            <label for="owner_id">Owner</label>
                            <input type="text" value="{{ $dokumen->owner_id }}" readonly>
                        </div>
                    @endif
                    
                    <div class="input-group flex flex-col space-y-2">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" value="{{ $dokumen->nama_dokumen }}" required>
                    </div>

                    <div class="input-group flex flex-col space-y-2">
                        <label for="kategori_id">Kategori Dokumen</label>
                        <select name="kategori_id" id="">
                            @if($dokumen->kategori_id == 1)
                                <option value="1" selected>SOP</option>
                                <option value="2" >NON SOP</option>
                            @endif

                            @if($dokumen->kategori_id == 2)
                                <option value="1" >SOP</option>
                                <option value="2" selected>NON SOP</option>
                            @endif
                        </select>
                    </div>

                    <div class="input-group flex flex-col space-y-2">
                        <label for="keyword">Keyword</label>
                        <input type="text" name="keyword" value="{{ $dokumen->keyword }}" required>
                    </div>

                    <div class="input-group flex flex-col space-y-2">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ $dokumen->deskripsi ?? null  }}">
                    </div>

                    <div class="input-group flex flex-col space-y-2">
                        <label for="tanggal_terbit">Tanggal terbit</label>
                            <input type="date" name="tanggal_terbit"  value="{{ $dokumen->tanggal_terbit ?? null  }}">
                    </div>

                    <!-- status field here... -->
                    <!-- status field here... -->
                    <!-- status field here... -->

                    <div class="input-group flex flex-col space-y-2">
                        <label for="file_attachment">File_Attachment</label>
                        <input type="text" name="file_attachment" value="{{ $dokumen->file_attachment }}" required>
                        <input type="file" name="file_attachment" value="{{ $dokumen->file_attachment }}" required>
                    </div>

                    <!-- button group -->
                    <div class="flex gap-x-2">
                        <button type="submit"
                        class="bg-yellow-500 font-semibold py-2 px-5">Edit</button>
                        <a href="{{ route('dashboard.documents') }}"
                        class="bg-red-500 font-semibold text-white py-2 px-5">Kembali</a>
                    </div>
                </form>

                <!-- file preview -->
                <div class="file-preview w-[50%]" >
                    @php
                        use Illuminate\Support\Str;
                    @endphp

                    @if(!empty($mime)) 
                        {{-- Kalau PDF atau gambar --}}
                        {{-- @if(Str::contains($mime, 'pdf') || Str::contains($mime, 'image'))
                            <iframe src="{{ $publicUrl }}" width="100%" height="600" style="border:none;"></iframe>
                        @endif --}}
                        @if(Str::contains($mime, 'pdf'))
                            <iframe 
                                src="https://docs.google.com/viewer?embedded=true&url={{ urlencode(asset('storage/documents/' . $filename)) }}" 
                                width="100%" 
                                height="600" 
                                style="border:none;">
                            </iframe>

                        @elseif(Str::contains($mime, 'image'))
                            <iframe 
                                src="{{ asset('storage/documents/' . $filename) }}" 
                                alt="Preview Gambar" 
                                style="width:100%; height:100%; border:1px solid #ccc; border-radius:8px;">
                            </iframe>
                        @endif

                        {{-- Kalau DOCX --}}
                        @if(Str::contains($mime, 'word'))
                            <div class="h-[100%] flex flex-col">
                                <h1>File Preview</h1>
                                <div id="docx-preview" style="padding:10px; background:white;border:3px solid rgb(54, 99, 222); height:100%;"></div>
                            </div>
                            
                            <script src="https://unpkg.com/mammoth/mammoth.browser.min.js"></script>
                            <script>
                                fetch("{{ $publicUrl }}")
                                    .then(res => res.arrayBuffer())
                                    .then(arrayBuffer => mammoth.extractRawText({arrayBuffer}))
                                    .then(result => document.getElementById("docx-preview").innerText = result.value)
                                    .catch(err => console.error(err));
                            </script>
                        @endif

                        {{-- Kalau XLSX --}}
                        @if(Str::contains($mime, 'sheet'))
                            <div class="h-[100%] flex flex-col">
                                <h1>File Preview</h1>
                                <div id="excel-preview" style="overflow-x:auto; background:rgb(200, 254, 189); border:3px solid green; height:100%;"></div>
                            </div>
                            
                            <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
                            <script>
                                fetch("{{ $publicUrl }}")
                                    .then(res => res.arrayBuffer())
                                    .then(data => {
                                            const workbook = XLSX.read(data, {type: "array"});
                                            const html = XLSX.utils.sheet_to_html(workbook.Sheets[workbook.SheetNames[0]]);
                                            document.getElementById("excel-preview").innerHTML = html;
                                                })
                                        .catch(err => console.error(err));
                                </script>
                        @endif
                    @else
                        <div class="bg-black w-[50%] h-[600px]"></div>
                    @endif
                </div>
                
            </div>
            <!-- footer -->
            @include('partials.footer')
        </main>
    </div>

@endsection