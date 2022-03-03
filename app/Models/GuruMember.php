<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMember extends Model
{
    use HasFactory;

    protected $table = 'rb_guru_membership';
    protected $primaryKey = "id_membership";
    public $timestamps = false;
    protected $guarded = [];
}
