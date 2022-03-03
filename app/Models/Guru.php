<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'rb_guru';
    protected $primaryKey = "id_guru";
    public $timestamps = false;
    protected $guarded = [];

    public function member($id)
    {
        return GuruMember::where('id_guru', $id)->first();
    }    
}
