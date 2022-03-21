<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'rb_kota';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $guarded = [];
}
