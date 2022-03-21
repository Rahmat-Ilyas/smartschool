<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        if (request()->segments()[1] == 'siswa') {
            $this->middleware('auth:siswa');
        } else {
            $this->middleware('auth:guru');
        }
    }

    public function home()
    {
        return view('users/home');
    }

    public function page($level, $page)
    {
        return view('users/' . $page);
    }

    public function pagedir($level, $dir = NULL, $page)
    {
        return view('users/' . $dir . '/' . $page);
    }
}
