<?php

namespace App\Http\Controllers\Documents;

use Exception;
use Carbon\Carbon;
// import Models
use App\Models\Users;
use App\Models\Dokumen;
use App\Models\LogDokumen;
use App\Models\ShareDokumen;
use Illuminate\Http\Request;

use App\Mail\ShareDocumentMail;
use App\Models\KategoriDokumen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index() 
    {
        // hanya visible ke user yang punya saja
        $ownerId = auth()->user()->id;

        if (auth()->user()->role_id == 1) {
            $documents = Dokumen::with('user', 'log_dokumen')
                    ->where('owner_id', '=', $ownerId)
                    ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null)
                    ->orderBy('id', 'desc')->get();
        } else {
            $documents = Dokumen::with('user', 'log_dokumen')
                            ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null)
                            ->orderBy('id', 'desc')->get();
        }

        return view ('documents.documents', compact('documents'));
    }

    public function create(){
        $users = Users::with('role')->get();
        $documents = Dokumen::get();
        $publicUrl = null; // default kosong
        return view ('documents.create_document', compact('publicUrl', 'users', 'documents'));
    }

    private function generateNamaDokumen($file)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // ganti _ atau - jadi spasi
        $cleanName = str_replace(['_', '-'], ' ', $originalName);

        // kapitalisasi tiap kata
        return ucwords($cleanName);
    }

    public function store(Request $request)
    {
        $owner_id = auth()->user()->id; // aman
        $owner_id_by_admin = $request->owner_id;

        $validated_data = $request->validate([
            'kategori_id'       => 'required', 
            // 'nama_dokumen'      => 'required|string|max:255', 
            'keyword'           => 'required|string', 
            'deskripsi'         => 'nullable|string', 
            'tanggal_terbit'    => 'required|date', 
            'file_attachment'   => 'required|file|mimes:pdf,docx,doc,jpg,png,jpeg,webp,xlsx,jfif|max:2048'
        ], [
            'kategori_id.required' => 'Kategori harus diisi!',
            // 'nama_dokumen.required' => 'Nama dokumen wajib diisi!',
            'keyword.required' => 'Keyword wajib diisi!',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi!',
            'file_attachment.required' => 'File wajib diisi!',
            'file_attachment.mimes' => 'File harus berupa PDF, Word, Gambar, atau Excel.',
            'file_attachment.max'   => 'Ukuran file maksimal 2MB.',
        ]);

        if(!$validated_data['file_attachment']){
            return back()->with('failed', 'File Tidak Valid');
        }

        try {
            $file = $request->file('file_attachment');
            $filePath = $file->store('documents', 'public');

            // ambil nama dokumen otomatis
            $namaDokumen = $this->generateNamaDokumen($file);

            // Ambil kategori (misalnya dari tabel kategori)
            $kategori = KategoriDokumen::findOrFail($validated_data['kategori_id']);

            // Cari nomor urut terakhir di kategori ini
            $lastDoc = Dokumen::where('kategori_id', $validated_data['kategori_id'])
                            ->orderBy('id', 'desc')
                            ->first();

            $nextNumber = $lastDoc ? $lastDoc->id + 1 : 1; 
            // atau bisa pakai $lastDoc->nomor_urut kalau ada field khusus

            // Format nomor dokumen => KATEGORI/NOMOR/TANGGAL
            $nomorDokumen = strtoupper($kategori->nama_kategori) . '/' .
                            str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '/' .
                            date('Y', strtotime($validated_data['tanggal_terbit']));

            // Buat dokumen
            $dokumen = Dokumen::create([
                'owner_id' => (Auth()->user()->role_id == 1) ? $owner_id : $owner_id_by_admin,
                'kategori_id' => $validated_data['kategori_id'],
                'nama_dokumen' => $namaDokumen,
                'nomor_dokumen' => $nomorDokumen,
                'keyword' => $validated_data['keyword'],
                'deskripsi' => $validated_data['deskripsi'] ?? null,
                'tanggal_terbit' => $validated_data['tanggal_terbit'],
                'status' => 'draf',
                'file_attachment' => $filePath,
            ]);

            // Logging
            LogDokumen::create([
                'dokumen_id' => $dokumen->id,
                'tanggal_dibagikan' => null,
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => null,
                'tanggal_dihapus' => null,
            ]);

            return redirect()->route('dashboard.documents')
                            ->with('success', 'Anda Berhasil Menambahkan Dokumen.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.documents')
                            ->with('failed', 'Gagal Menambahkan Dokumen.');
        }
    }





    // ======================= PRIVATE FUNCTION (only class child can access)
    private function renderDocument($id, $filename, $view)
    {
        $dokumen = Dokumen::with('user', 'log_dokumen', 'share_dokumen', 'kategori_dokumen')->findOrFail($id);

        $path = storage_path('app/public/documents/' . $filename);

        if (!file_exists($path)) {
            return redirect()->route('dashboard.documents')
                            ->with('failed' , 'File tidak ditemukan atau sudah dihapus.');
        }

        $content = file_get_contents($path);
        $mime = mime_content_type($path);
        $publicUrl = asset('storage/documents/' . $filename);

        return view($view, compact('publicUrl', 'mime', 'filename', 'dokumen'));
    }

    public function detail($id, $filename)
    {
        return $this->renderDocument($id, $filename, 'documents.detail_dokumen');
    }

    public function edit($id, $filename)
    {   
        return $this->renderDocument($id, $filename, 'documents.edit_document');
    }

    public function update(Request $request, $id)
    {
        $owner_id = auth()->user()->id; // aman

        $dokumen = Dokumen::findOrFail($id);

        $validated_data = $request->validate([
            'kategori_id'       => 'required', 
            'nama_dokumen'      => 'required|string|max:255',  
            'keyword'           => 'required|string', 
            'deskripsi'         => 'nullable|string', 
            'tanggal_terbit'    => 'nullable|date', 
            'file_attachment'   => 'nullable|file|mimes:pdf,docx,doc,jpg,png,jpeg,webp,xlsx,jfif|max:2048'
        ], [
            'kategori_id.required'   => 'Kategori harus diisi!',
            'nama_dokumen.required'  => 'Nama dokumen wajib diisi!',
            'keyword.required'       => 'Keyword wajib diisi!',
            'file_attachment.mimes'  => 'File harus berupa PDF, Word, Gambar, atau Excel.',
            'file_attachment.max'    => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            // ambil kategori (pastikan tabel kategori ada field kode, kalau tidak pakai nama_kategori)
            $kategori = KategoriDokumen::findOrFail($validated_data['kategori_id']);
            $kodeKategori = strtoupper($kategori->nama_kategori); // contoh: SOP, IK, LPR

            // pakai ID dokumen sebagai nomor urut (atau bikin field khusus nomor_urut kalau mau lebih rapi)
            $nomorUrut = str_pad($dokumen->id, 3, '0', STR_PAD_LEFT);

            // ambil tanggal dari request, fallback ke tanggal lama
            $tanggalTerbitFull = $validated_data['tanggal_terbit'] 
                ? Carbon::createFromFormat('Y-m-d', $validated_data['tanggal_terbit'])->format('Y-m-d')
                : $dokumen->tanggal_terbit;

            // ambil tahun untuk nomor dokumen
            $tahunTerbit = Carbon::parse($tanggalTerbitFull)->format('Y');

            // format nomor dokumen baru
            $nomorDokumen = $kodeKategori . '/' . $nomorUrut . '/' . $tahunTerbit;

            $updateData = [
                'kategori_id'    => $validated_data['kategori_id'],
                'nama_dokumen'   => $validated_data['nama_dokumen'],
                'keyword'        => $validated_data['keyword'],
                'deskripsi'      => $validated_data['deskripsi'] ?? null,
                'tanggal_terbit' => $tanggalTerbitFull, // simpan full date
                'status'         => 'draf',
                'nomor_dokumen'  => $nomorDokumen,
            ];

            // cek apakah ada file baru diupload
            if ($request->hasFile('file_attachment')) {
                if ($dokumen->file_attachment && Storage::disk('public')->exists($dokumen->file_attachment)) {
                    Storage::disk('public')->delete($dokumen->file_attachment);
                }

                $file = $request->file('file_attachment');
                $filePath = $file->store('documents', 'public');

                $updateData['file_attachment'] = $filePath;
                $updateData['nama_dokumen'] = $this->generateNamaDokumen($file);
            } else {
                // kalau tidak upload file baru, tetap pakai inputan manual user
                $updateData['nama_dokumen'] = $validated_data['nama_dokumen'];
            }

            // update tabel dokumen
            $dokumen->update($updateData);

            // update log
            LogDokumen::where('dokumen_id', $dokumen->id)
                ->update([
                    'tanggal_diubah' => now(),
                ]);

            return redirect()->route('dashboard.documents')
                ->with('success', 'Anda Berhasil Mengubah Dokumen.');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.documents')
                ->with('failed', 'Gagal Mengubah Dokumen. Error: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            // cari dokumen dulu
            $dokumen = Dokumen::findOrFail($id);

            // hapus file fisik di storage
            
            if ($dokumen->file_attachment && Storage::disk('public')->exists($dokumen->file_attachment)) {
                Storage::disk('public')->delete($dokumen->file_attachment);
            }

            // update log dokumen
            LogDokumen::where('dokumen_id', $dokumen->id)
                ->update([
                    'tanggal_dihapus' => now()
                ]);

            // hapus row dokumen
            $dokumen->delete();

            return redirect()->route('dashboard.documents')
                            ->with('success', 'Anda Berhasil Menghapus Dokumen.');
        } catch (\Exception $e) {
            // return response()->json(['gagal' => $e->getMessage()]);
            return redirect()->route('dashboard.documents')->with('failed', 'Gagal Menghapus Dokumen');
        }
    }

    public function download($id, $filename)
    {   
        $dokumen = Dokumen::findOrFail($id);

        $path = storage_path('app/public/documents/' . $filename);

        if (!file_exists($path)) {
            return redirect()->route('dashboard.documents')
                            ->with('failed' , 'File tidak ditemukan atau sudah dihapus.');
        }

        $mime = mime_content_type($path);
        $publicUrl = asset('storage/documents/' . $filename);

        // return view('documents.edit_document', compact('dokumen', 'publicUrl', 'mime', 'filename'));
        //  return response()->file($path, [
        //     'Content-Type' => $mime,
        //     'Content-Disposition' => 'inline; filename="' . $filename . '"'
        // ]);
        return response()->download($path, $filename);
    }

    public function preview($id, $filename)
    {
        $dokumen = Dokumen::findOrFail($id);

        $path = storage_path('app/public/documents/' . $filename);

        if (!file_exists($path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan atau sudah dihapus.'
            ], 404);
        }

        $mime = mime_content_type($path);
        $publicUrl = asset('storage/documents/' . $filename);

        return response()->json([
            'status' => 'success',
            'url' => $publicUrl,
            'mime' => $mime,
            'filename' => $filename
        ]);
    }

    // public function previewFile($filename)
    // {
    //    $path = storage_path('app/public/documents/' . $filename);

    //     if (!file_exists($path)) {
    //         abort(404);
    //     }

    //     $mime = mime_content_type($path);
    //     $publicUrl = asset('storage/documents/' . $filename);

    //     // return view dan kirim $mime + $publicUrl + $filename
    //     return view('documents.create_document', compact('publicUrl', 'mime', 'filename'));
    // }

    public function sharePage($id)
    {
         $document = Dokumen::with('user')->findOrFail($id);
        //  dd($document);

         return view('documents.share_document', compact('document'));
    }

    public function share(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $document = Dokumen::findOrFail($id);
        $document_file = $document->file_attachment;
        $sender = auth()->user();

        try{
            // kirim doc ke email tujuan
            Mail::to($request->email)->send(new ShareDocumentMail($document, $sender));
            
            // update tanggal_dibagikan
            $log_document = LogDokumen::where('dokumen_id', '=', $document->id)
            ->update([
                'tanggal_dibagikan' => now()
            ]);

            // create data share dokumen
            $share_document = ShareDokumen::create([
                'dokumen_id' => $document->id,
                'dibagikan_oleh_id' => $document->owner_id,
                'email_tujuan' => $request->email,
                'link_token' => null,
                'expired_at' => null,
                'created_at' => now()
            ]);

            // update status dibagikan
            $document = Dokumen::where('id', '=', $document->id)
            ->update([
                'status' => 'dibagikan'
            ]);
            
            return back()->with('success', 'Dokumen berhasil dibagikan ke email: '. $request->email);

        }catch(Exception $e){
            // return response()->json(['gagal' => $e]);
            return redirect()->route('dashboard.documents')->with('failed', 'Gagal Membagikan Dokumen ke email: ' . $request->email);
        }
       
    }

    public function search(Request $request)
    {
        $ownerId = auth()->id();

        if (auth()->user()->role_id == 1) {
            // user: hanya miliknya
            $query = Dokumen::with('user', 'log_dokumen')
                ->where('owner_id', $ownerId)
                ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null);
        } else {
            // admin: semua dokumen
            $query = Dokumen::with('user', 'log_dokumen')
                ->whereRelation('log_dokumen', 'tanggal_dihapus', '=', null);
        }

        // search fix (dibungkus)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'LIKE', "%{$search}%")
                ->orWhere('keyword', 'LIKE', "%{$search}%");
            });
        }
        // SQL NYA :
        // WHERE owner_id = 5
        //   AND tanggal_dihapus IS NULL
        //   AND (
        //        nama_dokumen LIKE '%abc%'
        //        OR keyword LIKE '%abc%'
        //       )

        //     // searching
        //     if ($request->filled('q')) {
        //         $query->where('nama_dokumen', 'LIKE', '%' . $request->q . '%')
        //               ->orWhere('keyword', 'LIKE', '%' . $request->q . '%');
        //     }
        $documents = $query->orderBy('id', 'desc')->paginate(6);

        // modif data -> tambah badge
        $documents->getCollection()->transform(function ($doc) {
            return [
                'id'              => $doc->id,
                'nomor_dokumen'   => $doc->nomor_dokumen,
                'nama_dokumen'    => $doc->nama_dokumen,
                'file_attachment' => $doc->file_attachment,
                'user'            => $doc->user ? ['nama' => $doc->user->nama] : null,
                'log_dokumen'     => $doc->log_dokumen ? [
                                        'tanggal_dibuat' => $doc->log_dokumen->tanggal_dibuat,
                                        'tanggal_diubah' => $doc->log_dokumen->tanggal_diubah,
                                    ] : null,
                'badge'           => getFileBadge(basename($doc->file_attachment)), // 🔥 helper dipakai di sini
            ];
        });

        return response()->json($documents);
    }
}
