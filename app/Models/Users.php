<?php

namespace App\Models;
// agar auth bekerja
use App\Models\Roles;
use App\Models\Dokumen;
use App\Models\ShareDokumen;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property Users $user
 */
class Users extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'image',
        'nama',
        'email',
        'no_telepon',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    // seorang user has many dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'owner_id');
    }

    // user bisa kirim banyak dokumen
    public function share_dokumen()
    {
        return $this->hasMany(ShareDokumen::class, 'dibagikan_oleh_id');
    }
}
