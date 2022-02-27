<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'rb_kurikulum';
    protected $primaryKey = "kode_kurikulum";
    public $timestamps = false;
    protected $guarded = [];
}
