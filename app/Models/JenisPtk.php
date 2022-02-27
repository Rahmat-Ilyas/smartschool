<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPtk extends Model
{
    use HasFactory;

    protected $table = 'rb_jenis_ptk';
    protected $primaryKey = "id_jenis_ptk";
    public $timestamps = false;
    protected $guarded = [];
}