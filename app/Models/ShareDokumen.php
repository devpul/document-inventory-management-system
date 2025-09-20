<?php

namespace App\Models;

use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class ShareDokumen extends Model
{
    protected $table = 'share_dokumen';

    protected $fillable = [
        'dokumen_id',
        'dibagikan_oleh_id',
        'email_tujuan',
        'link_token',
        'expired_at',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];


    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(Users::class, 'dibagikan_oleh_id');
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
