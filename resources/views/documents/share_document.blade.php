@extends('layout')
@section('title', 'Bagikan Dokumen')

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
                <h1 class="text-2xl font-semibold">Share Document</h1>
            </div>    
        </section>

        <!-- main -->
        <main class="px-6 relative flex-grow min-h-screen">
            <div class="bg-white rounded-2xl shadow p-6 mb-20">
                <form action="{{ route('dashboard.document_share', $document->id) }}" 
                method="POST"
                class="flex flex-col">
                    @csrf
                    <!-- form group -->
                    <div class="form-control flex justify-between w-[100%] space-x-10">
                        <div id="left" class="w-[50%] flex flex-col">
                            <div class="input-group flex justify-between w-[90%] items-center mb-3">
                                <h1 class="font-semibold w-[100%] text-center text-yellow-500 bg-yellow-200 rounded-xl p-2 text-xl">Detail Dokumen</h1>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">id</label>
                                <input type="text" class="w-full"  value="{{ $document->id }}" readonly>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">Nama Dokumen</label>
                                <input type="text" class="w-full"  value="{{ $document->nomor_dokumen }}" readonly>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">Nomor Dokumen</label>
                                <input type="text" class="w-full" value="{{ $document->nama_dokumen }}" readonly>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">Owner Dokumen</label>
                                <input type="text" class="w-full" value="{{ $document->user->nama }}" readonly>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">Status</label>
                                <input type="text" class="w-full" value="{{ $document->status }}" readonly>
                            </div>
                            <div class="input-group flex justify-between w-[90%] items-center space-y-3">
                                <label class="w-[40%] font-semibold">Tipe File</label>
                                <input type="text" class="w-full" value="{{ strtoupper(pathinfo($document->file_attachment, PATHINFO_EXTENSION)) }}" readonly>
                            </div>
                        </div>

                        <div id="right" class="w-[50%] flex flex-col justify-between">
                            <div id="pengirim">
                                <div class="input-group flex justify-between w-[90%] items-center mb-2">
                                    <h1 class="font-semibold w-[100%] text-center text-blue-500 bg-blue-200 rounded-xl p-2">Pengirim</h1>
                                </div>
                                <div class="input-group flex justify-between w-[90%] items-center space-y-3 ">
                                    <label class="w-[40%] font-semibold">Nama Pengirim</label>
                                    <input type="text" class="w-full"  value="{{ $document->user->nama }}" readonly>
                                </div>
                                <div class="input-group flex justify-between w-[90%] items-center space-y-3 ">
                                    <label class="w-[40%] font-semibold">Email Pengirim</label>
                                    <input type="email" class="w-full"  value="{{ $document->user->email }}" readonly>
                                </div>
                            </div>
                            <div id="penerima">
                                <div class="input-group flex justify-between w-[90%] items-center mb-2">
                                    <h1 class="font-semibold w-[100%] text-center text-green-500 bg-green-200 rounded-xl p-2">Penerima</h1>
                                </div>
                                {{-- <div class="input-group flex justify-between w-[90%] items-center space-y-3 ">
                                <input type="text" class="w-full"  value="" placeholder="Masukan Nama Penerima" required>      <label class="w-[40%] font-semibold">Nama Penerima</label>
                                  
                                </div> --}}
                                <div class="input-group flex justify-between w-[90%] items-center space-y-3 ">
                                    <label class="w-[40%] font-semibold">Email Penerima</label>
                                    <input type="email" class="w-full" name="email" 
                                    placeholder="Masukan email penerima"
                                    required>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- submit button  -->
                    <div class="input-group flex justify-center gap-x-6 mt-12 px-6">
                        <button type="submit" class="bg-blue-500 font-bold text-white py-3 px-10 mt-3 rounded-xl">Bagikan Dokumen</button>
                        <a href="{{ route('dashboard.documents') }}" class="bg-red-500 font-bold text-white py-3 px-10 mt-3 rounded-xl">Batalkan</a>
                    </div>
                </form>
            </div>
        </main>
        
    </div>
@endsection