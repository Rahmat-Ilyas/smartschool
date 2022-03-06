<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabKasus extends Model
{
    use HasFactory;

    protected $table = 'rb_labor_kasus';
    protected $primaryKey = "id_labor_kasus";
    public $timestamps = false;
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function detail()
    {
        return $this->hasMany(LabKasusDetail::class, 'id_labor_kasus');
    }
}
