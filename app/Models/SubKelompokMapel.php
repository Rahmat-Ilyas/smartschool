<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKelompokMapel extends Model
{
    use HasFactory;

    protected $table = 'rb_kelompok_mata_pelajaran_sub';
    protected $primaryKey = "id_kelompok_mata_pelajaran_sub";
    public $timestamps = false;
    protected $guarded = [];

    public function kelompok_mapel()
    {
        return $this->belongsTo(KelompokMapel::class, 'id_kelompok_mata_pelajaran');
    }

    public function get_sub_kelompok($sekolah_id)
    {
        $kelompok = KelompokMapel::where('id_identitas_sekolah', $sekolah_id)->get();
        $where = [];
        foreach ($kelompok as $dta) {
            $where[] = $dta->id_kelompok_mata_pelajaran;
        }
        $sub_kelompok = $this->whereIn('id_kelompok_mata_pelajaran', $where)->get();
        return $sub_kelompok;
    }
}
