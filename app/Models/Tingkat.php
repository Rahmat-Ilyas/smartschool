<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;

    protected $table = 'rb_tingkat';
    protected $primaryKey = "id_tingkat";
    public $timestamps = false;
    protected $guarded = [];

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'kode_kurikulum');
    }

    public function raport()
    {
        return $this->belongsTo(Raport::class, 'id_raport');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_tingkat');
    }
}
