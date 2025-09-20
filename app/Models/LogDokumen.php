<?php

namespace App\Models;

use App\Models\Dokumen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogDokumen extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'tanggal_dihapus';
    protected $table = 'log_dokumen';
    public $timestamps = false;
    protected $fillable = [
        'dokumen_id',
        'tanggal_dibagikan',
        'tanggal_dibuat',
        'tanggal_diubah',
        'tanggal_dihapus',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'date',
        'tanggal_dibagikan' => 'datetime',
        'tanggal_diubah' => 'datetime'
    ];


    // each document must have atleast 1 to 1 log_dokumen
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
