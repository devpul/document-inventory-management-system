<?php

namespace App\Models;
use App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nama_role'];

    public function user()
    {
        return $this->hasOne(Users::class, 'role_id');
    }
}
