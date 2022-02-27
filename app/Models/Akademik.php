<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akademik extends Model
{
    use HasFactory;

    protected $table = 'rb_tahun_akademik';
    protected $primaryKey = "id_tahun_akademik";
    public $timestamps = false;
    protected $guarded = [];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_tahun_akademik');
    }
}
