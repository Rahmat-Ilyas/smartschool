<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin/login');
    }

    public function login(Request $request)
    {
        config()->set('auth.defaults.guard', 'admin');

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $credential = [
            'username' => $request->username,
            'password' => $request->password,
        ];;

        if (Auth::attempt($credential)) {
            $auth = Auth::user();
            if ($auth->level == 'admin') {
                // dd($auth);
                Auth::guard('admin')->attempt($credential, $request->filled('remember'));
                return redirect()->route('admin.home');
                exit();
            }
            Auth::guard('admin')->logout();
        }

        return redirect()->back()->withInput($request->only('username', 'password'))->withErrors(['error' => ['Username atau password yang anda masukkan salah!']]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/admin');
    }
}
