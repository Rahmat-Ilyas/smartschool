<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    use HasFactory;

    protected $table = 'rb_raport';
    protected $primaryKey = "id_raport";
    public $timestamps = false;
    protected $guarded = [];
}
