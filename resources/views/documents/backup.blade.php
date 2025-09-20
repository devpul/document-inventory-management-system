@extends('layout')


@section('content')
<!-- Sidebar -->
        @include('partials.sidebar')
        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('partials.header')
            <!-- Documents Header -->
            <div class="p-6 items-center">
                <div class="bg-transparent py-0 px-4 flex justify-between items-center mb-10">
                    <h1 class="text-2xl font-semibold">Documents</h1>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('dashboard.document_create') }}" class="border border-blue-600 py-2 px-5 rounded-lg text-white bg-blue-600 font-semibold cursor-pointer hover:bg-blue-700 hover:transition duration-300">Create Document</a>
                    </div>
                </div>

                <div class="bg-white shadow p-4 rounded-2xl mb-6">
                    <div class="flex items-center space-x-4 relative mb-4">
                        <input id="searchInput" type="text" placeholder="Search by name"
                            class="w-[300px] border rounded-lg px-10 py-2 text-sm border-2 focus:border-blue-400"/>

                        <div class="absolute right-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 
                                    5.196 5.196a7.5 7.5 0 0 0 
                                    10.607 10.607Z" />
                            </svg>
                        </div>
                    </div>

                    <table class="w-full border-collapse">
                        <thead> ... </thead>
                        <tbody id="documentTableBody" class="text-center">
                            {{-- isi tabel akan diisi lewat AJAX --}}
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div id="pagination" class="flex justify-center mt-4 space-x-2"></div>
                </div>
      
            </div>
            

            <!-- Main -->
            <main class="px-6 relative flex-grow min-h-screen">
                <!-- Table 1 -->
                <div class="bg-white rounded-2xl shadow p-6 mb-20">            
                    <!-- <h2 class="text-lg font-semibold mb-4">Recent Activity</h2> -->
                    <div>
                        <table class="w-full  border-collapse">
                            <thead class="text-center" id="documentTableHead">
                                <tr class="text-center" id="thead">
                                    <th class="p-3">ID</th>
                                    <th class="p-3">No. Dokumen</th>
                                    <th class="p-3 ">Owner</th>
                                    <th class="p-3">Nama Dokumen</th>
                                    <th class="p-3">Tipe</th>
                                    <th class="p-3">Deskripsi</th>
                                    {{-- <th class="p-3">Tanggal Terbit</th> --}}
                                    {{-- <th class="p-3">File Attachment</th> --}}
                                    <th class="p-3">Tanggal Upload</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-center" id="documentTableBody">
                                @if(!$documents)
                                <h1>halo</h1>
                                @endif                                
                                @foreach($documents as $dokumen)
                                    <tr class="border-t hover:bg-gray-100 text-center">
                                        {{-- ID DOK --}}
                                         <td class="p-3">{{ $dokumen->id }}</td>
                                        {{-- NOMOR DOKUMEN --}}
                                        <td class="p-3">{{ $dokumen->nomor_dokumen }}</td>
                                        {{-- OWNER DOKUMEN --}}
                                        <td class="p-3">{{ $dokumen->user->nama }}</td>
                                        {{-- NAMA DOKUMEN --}}
                                        <td class="p-3">{{ $dokumen->nama_dokumen }}</td>
                                        {{-- TIPE --}}
                                        <td class="p-3"><span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full font-medium">XLSX</span></td>
                                        {{-- TANGGAL DI BUAT --}}
                                        <td class="p-3">
                                            {{ optional($dokumen->log_dokumen)->tanggal_dibuat?->format('d M Y') ?? '-' }}
                                        </td>
                                        {{-- Action --}}
                                        <td class="p-3">
                                            <div class="flex space-x-2 justify-center" id="actions">
                                                {{-- DOWNLOAD --}}
                                                <a href="">
                                                    <div class="bg-blue-200 border flex items-center rounded-full p-2  hover:bg-blue-300 text-blue-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                {{-- PREVIEW --}}
                                                <a href="">
                                                    <div class="bg-gray-200 border flex items-center rounded-full p-2  hover:bg-gray-300 text-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                         </svg>
                                                    </div>
                                                </a>
                                                {{-- EDIT --}}
                                                 <a href="{{ route('dashboard.document_edit', [$dokumen->id, basename($dokumen->file_attachment)]) }}">
                                                    <div class="bg-yellow-200 border flex items-center rounded-full p-2  hover:bg-yellow-300 text-yellow-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                {{-- SHARE --}}
                                                <form action="{{ route('dashboard.document_share', $dokumen->id) }}" method="POST">
                                                    @csrf
                                                    <input type="email" name="email" placeholder="Masukkan email penerima" required>
                                                    <button type="submit" class="bg-green-200 border flex items-center rounded-full p-2  hover:bg-green-300 text-green-600">
                                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                             <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                {{-- DELETE --}}
                                                <form action="{{ route('dashboard.document_delete', $dokumen->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <div class="bg-red-200 border flex items-center rounded-full p-2  hover:bg-red-300 text-red-600 ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
               

                <!-- Footer -->
                @include('partials.footer')
            </main>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
        $(document).ready(function () {
            // const route_download
            // const route_preview
            const route_edit = "{{ route('dashboard.document_edit', [':id', ':filename']) }}";
            const route_share = "{{ route('dashboard.document_share', ':id') }}";
            const route_delete = "{{ route('dashboard.document_delete', ':id') }}";
            const csrfToken = "{{ csrf_token() }}";
            const actions = document.getElementById('actions').innerHTML;
            let currentPage = 1;
            let query = "";

            function fetchDocuments(page = 1, q = "") {
            $.ajax({
                url: "{{ route('dashboard.documents.search') }}",
                type: "GET",
                data: { page: page, q: q },
                success: function (res) {
                    let rows = "";
                    let thead = "";
                    if (res.data.length > 0) {
                        $.each(res.data, function (i, doc) {
                            

                            let editUrl = route_edit
                                .replace(':id', doc.id)
                                .replace(':filename', doc.file_attachment.split('/').pop());

                             let shareUrl = route_share
                                .replace(':id', doc.id);

                            let deleteUrl = route_delete
                                .replace(':id', doc.id);

                            thead = `
                                <tr class="text-center">
                                    <th class="p-3">ID</th>
                                    <th class="p-3">No. Dokumen</th>
                                    <th class="p-3 ">Owner</th>
                                    <th class="p-3">Nama Dokumen</th>
                                    <th class="p-3">Tipe</th>
                                    <th class="p-3">Deskripsi</th>
                                    <th class="p-3">Tanggal Upload</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            `;

                            // render ulang semua action, jangan ambil dari #actions
                            rows += `
                            <tr class="border-t hover:bg-gray-100">
                                <td class="p-3">${doc.id}</td>
                                <td class="p-3">${doc.nomor_dokumen}</td>
                                <td class="p-3">${doc.user ? doc.user.nama : '-'}</td>
                                <td class="p-3">${doc.nama_dokumen}</td>
                                <td class="p-3"><span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded-full font-medium">DOC</span></td>
                                <td class="p-3">${doc.deskripsi ?? 'Belum di isi'}</td>
                                <td class="p-3">${doc.log_dokumen?.tanggal_dibuat ? new Date(doc.log_dokumen.tanggal_dibuat).toLocaleDateString() : '-'}</td>
                                <td class="p-3">
                                    <div class="flex space-x-2 justify-center">
                                        <!-- DOWNLOAD -->
                                        <a href="/documents/${doc.id}/download">
                                            <div class="bg-blue-200 border flex items-center rounded-full p-2  hover:bg-blue-300 text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                            </div>
                                        </a>
                                        <!-- PREVIEW -->
                                        <a href="/documents/${doc.id}/preview">
                                           <div class="bg-gray-200 border flex items-center rounded-full p-2  hover:bg-gray-300 text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </div>
                                        </a>
                                        <!-- EDIT -->
                                        <a href="${editUrl}">
                                            <div class="bg-yellow-200 border flex items-center rounded-full p-2  hover:bg-yellow-300 text-yellow-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </div>
                                        </a>
                                        <!-- SHARE -->
                                        <a href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                            </svg>
                                        </a>
                                        <!-- DELETE -->
                                        <form action="${deleteUrl}" method="POST">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">
                                                <div class="bg-red-200 border flex items-center rounded-full p-2  hover:bg-red-300 text-red-600 ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="8" class="p-3 text-center">Dokumen Tidak Ada</td></tr>`;
                    }
                    $("#documentTableHead").html(thead);
                    $("#documentTableBody").html(rows);

                    // pagination
                    let pagination = "";
                    for (let i = 1; i <= res.last_page; i++) {
                        pagination += `<button data-page="${i}" class="px-3 py-1 border rounded ${i == res.current_page ? 'bg-blue-600 text-white' : ''}">${i}</button>`;
                    }
                    $("#pagination").html(pagination);
                }
            });
        }


            // initial load
            fetchDocuments();

            // search event
            $("#searchInput").on("keyup", function () {
                query = $(this).val();
                fetchDocuments(1, query);
            });

            // pagination click
            $(document).on("click", "#pagination button", function () {
                let page = $(this).data("page");
                currentPage = page;
                fetchDocuments(page, query);
            });
        });
        </script>


@endsection
