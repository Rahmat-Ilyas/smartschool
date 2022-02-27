<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepegawaian extends Model
{
    use HasFactory;

    protected $table = 'rb_status_kepegawaian';
    protected $primaryKey = "id_status_kepegawaian";
    public $timestamps = false;
    protected $guarded = [];
}
