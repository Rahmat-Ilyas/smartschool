<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'rb_jadwal_pelajaran';
    protected $primaryKey = "kodejdwl ";
    public $timestamps = false;
    protected $guarded = [];
}
