<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'rb_siswa';
    protected $primaryKey = "id_siswa";
    public $timestamps = false;
    protected $guarded = [];
}