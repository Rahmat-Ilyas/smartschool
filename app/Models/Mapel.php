<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'rb_mata_pelajaran';
    protected $primaryKey = "id_mata_pelajaran";
    public $timestamps = false;
    protected $guarded = [];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    public function kelompok_mapel($id)
    {
        return KelompokMapel::where('id_kelompok_mata_pelajaran', $id)->first();
        // return $this->belongsTo(KelompokMapel::class, 'id_kelompok_mata_pelajaran');
    }
}
