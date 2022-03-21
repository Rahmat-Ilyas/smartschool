<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'rb_guru';
    protected $primaryKey = "id_guru";
    public $timestamps = false;
    protected $guarded = [];

    public function member($id)
    {
        return GuruMember::where('id_guru', $id)->first();
    }    
}
