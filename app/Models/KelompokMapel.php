<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMapel extends Model
{
    use HasFactory;

    protected $table = 'rb_kelompok_mata_pelajaran';
    protected $primaryKey = "id_kelompok_mata_pelajaran";
    public $timestamps = false;
    protected $guarded = [];
}
