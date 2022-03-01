<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'rb_users';
    protected $primaryKey = "id_user";
    public $timestamps = false;
    protected $guard = 'admin';
    protected $guarded = [];

    public function is_skl()
    {
        return $this->hasOne(IdentitasSekolah::class, 'id_identitas_sekolah', 'id_identitas_sekolah');
    }

    public function user_modul()
    {
        return $this->hasMany(UserModul::class, 'id_user');
    }
}
