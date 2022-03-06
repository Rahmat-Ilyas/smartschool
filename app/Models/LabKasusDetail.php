<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabKasusDetail extends Model
{
    use HasFactory;

    protected $table = 'rb_labor_kasus_detail';
    protected $primaryKey = "id_labor_kasus_detail";
    public $timestamps = false;
    protected $guarded = [];
}
