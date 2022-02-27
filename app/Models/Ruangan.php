<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'rb_ruangan';
    protected $primaryKey = "id_ruangan";
    public $timestamps = false;
    protected $guarded = [];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_ruangan');
    }

    public function get_ruangan($sekolah_id)
    {
        $gedung = Gedung::where('id_identitas_sekolah', $sekolah_id)->get();
        $where = [];
        foreach ($gedung as $dta) {
            $where[] = $dta->id_gedung;
        }
        $ruangan = $this->whereIn('id_gedung', $where)->get();
        return $ruangan;
    }
}
