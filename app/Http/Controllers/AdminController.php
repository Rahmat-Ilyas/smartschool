<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function home()
    {
        return view('admin/home');
    }

    public function page($page)
    {
        return view('admin/' . $page);
    }

    public function pagedir($dir = NULL, $page)
    {
        return view('admin/' . $dir . '/' . $page);
    }
}
