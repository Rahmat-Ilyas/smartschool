<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModul extends Model
{
    use HasFactory;

    protected $table = 'users_modul';
    protected $primaryKey = "id_umod";
    public $timestamps = false;
    protected $guarded = [];
}
