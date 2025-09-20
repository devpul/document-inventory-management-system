<?php

namespace App\Models;

use App\Models\Dokumen;
use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
     protected $table = 'kategori_dokumen';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function dokumen()
    {
        return $this->hasOne(Dokumen::class, 'dokumen_id');
    }
}
