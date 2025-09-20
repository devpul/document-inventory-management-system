@extends('layout')
@section('title', 'Dokumen Dibagikan')

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
                <h1 class="text-2xl font-semibold">Shared Documents</h1>
            </div>    
        </section>

        <!-- main -->
        <main class="px-6 relative flex-grow min-h-screen">
            <div class="bg-white shadow p-4 rounded-2xl flex justify-between space-x-10">
                <!-- form -->
                {{-- {{ dd($shared_document) }} --}}
                <table class="w-full">
                    <thead>
                        <tr class="text-center">
                            <th class="p-3">#</th>
                            <th class="p-3">Nomor Dokumen</th>
                            <th class="p-3">Nama Dokumen</th>
                            <th class="p-3">Dibagikan Oleh</th>
                            <th class="p-3">Email Tujuan</th>
                            <th class="p-3">Tanggal Dibagikan</th>
                    </thead>
                    
                    @php $no = 1; @endphp

                    <tbody>
                    @forelse($shared_document as $shared)
                        <tr class="text-center">
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">{{ $shared->dokumen->nomor_dokumen }}</td>
                            <td class="p-3">{{ $shared->dokumen->nama_dokumen }}</td>
                            <td class="p-3">
                                <div class="flex flex-col">
                                    <div id="shared-nama">
                                        {{ $shared->user->nama }}
                                    </div>
                                    <div id="shared-email">
                                        {{ $shared->user->email }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">{{ $shared->email_tujuan }}</td>
                            <td class="p-3">
                                <div class="flex flex-col">
                                    <div id="shared-tanggal">
                                        {{ $shared->created_at->format('d M Y') }}
                                    </div>
                                    <div id="shared-jam">
                                        {{ $shared->created_at->format('h:i:s') }} WIB
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-xl text-gray-400 px-3 py-10 text-center italic font-light">
                                Dokumen Belum Dibagikan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>

            <!-- footer -->
            @include('partials.footer')
        </main>
    </div>
@endsection