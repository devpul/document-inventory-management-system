<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;

// Models
use App\Models\Users;
use App\Models\LogDokumen;
use App\Models\ShareDokumen;
use App\Models\KategoriDokumen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{

    // use SoftDeletes;
    protected $table = 'dokumen';
    public $timestamps = false;

    protected $fillable = [
        'owner_id',
        'kategori_id',
        'nomor_dokumen',
        'nama_dokumen',
        'keyword',
        'deskripsi',
        'tanggal_terbit', //string
        'status',
        'file_attachment'
    ];

    // agar bisa pakai carbon
    protected $casts = [
        'tanggal_terbit' => 'date'
    ];

    // dokumen bergantung ke user, banyak dokumen tapi satu user
    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'owner_id');
    }

    public function kategori_dokumen()
    {
        return $this->belongsTo(KategoriDokumen::class, 'dokumen_id');
    }

    //dokumen 1 to 1 log dokumen
    public function log_dokumen()
    {
        return $this->hasOne(LogDokumen::class, 'dokumen_id');
    }

    // dokumen boleh banyak share
    public function share_dokumen()
    {
        return $this->hasOne(ShareDokumen::class, 'dokumen_id');
    }
    
}
