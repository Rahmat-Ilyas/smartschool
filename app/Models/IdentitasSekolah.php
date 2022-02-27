<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentitasSekolah extends Model
{
    use HasFactory;

    protected $table = 'rb_identitas_sekolah';
    protected $primaryKey = "id_identitas_sekolah";
    public $timestamps = false;
    protected $guarded = [];
}
